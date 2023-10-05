var map;
var directionsService;
var directionsDisplay;
var markers = [];
var waypoints = [];
var chunkSize = 25;
var chunkedWaypoints = [];
var responses = []; // Arreglo para almacenar las respuestas de las solicitudes de ruta
var distancesKtoM = [];

// Crear una instancia de DirectionsService de Google Maps.
var directionsService = new google.maps.DirectionsService();
// Crear una instancia de DirectionsRenderer de Google Maps.
var directionsDisplay = new google.maps.DirectionsRenderer();

var homeurl = getURLParameter('homeurl');
var csrfToken = getURLParameter('csrf');

// Esta función obtiene el valor de un parámetro de consulta (query parameter) de la URL
// en la que se encuentra actualmente el script que se está ejecutando.
function getURLParameter(param) {
    // Obtener todos los elementos <script> en el documento HTML.
    var scripts = document.getElementsByTagName('script');
    // Obtener la URL del último <script>, que generalmente es la URL del script actual.
    var scriptURL = scripts[scripts.length - 1].src;
    // Dividir la URL del script en dos partes: la parte antes del '?' y la parte después del '?' (el queryString).
    var queryString = scriptURL.split('?')[1];
    // Crear un objeto URLSearchParams a partir del queryString para facilitar la obtención de parámetros.
    var urlParams = new URLSearchParams(queryString);
    // Utilizar el método "get" del objeto URLSearchParams para obtener el valor del parámetro deseado.
    return urlParams.get(param);
}

// Inicializar el mapa
map = new google.maps.Map(document.getElementById('map'), {
    center: { lat: 19.427004658082968, lng: -99.16691826012136 }, // Coordenadas iniciales 19.427004658082968, -99.16691826012136
    zoom: 10 // Nivel de zoom inicial
});
directionsDisplay.setMap(map);

// Evento de clic para agregar puntos de control
map.addListener('click', function (event) {
    var marker = new google.maps.Marker({
        position: event.latLng,
        map: map
    });
    markers.push(marker);
});

// Manejar el clic del botón para generar la lista de coordenadas
document.getElementById('generate').addEventListener('click', function () {
    // Obtener las coordenadas de los marcadores en el mapa
    var coordinates = markers.map(function (marker) {
        return marker.getPosition().toUrlValue();
    });

    // Llamar a la función finalCoordinates para procesar las coordenadas
    waypoints = finalCoordinates(coordinates);

    // Mostrar las coordenadas resultantes en la consola
    //console.log('Coordenadas en waypoints: ', waypoints);

    // Llamar a la función insertCoordinates para guardar las coordenadas
    insertCoordinates();

    // Llamar a la función drawRoutes para dibujar la ruta en el mapa
    drawRoutes();
});


function finalCoordinates(originalCoordinates) {
    // Arreglo resultante de coordenadas en formato { lat: ..., lng: ... }
    var finalCoordinates = [];

    // Recorrer el arreglo original y convertir las coordenadas
    for (var i = 0; i < originalCoordinates.length; i++) {
        var coordinate = originalCoordinates[i].split(','); // Dividir la cadena en latitud y longitud
        var latitude = parseFloat(coordinate[0]); // Convertir la latitud a número
        var longitude = parseFloat(coordinate[1]); // Convertir la longitud a número

        // Crear un objeto en el formato { lat: ..., lng: ... }
        var objectCoordinate = { lat: latitude, lng: longitude };

        // Agregar el objeto al arreglo final
        finalCoordinates.push(objectCoordinate);
    }
    return finalCoordinates;
}

function drawRoutes() {
    // Dividir waypoints en grupos de 25 o menos
    chunkedWaypoints = chunkArray(waypoints, chunkSize);

    // Iniciar el cálculo de rutas para cada grupo de waypoints
    calculateRoute(0);
}

// Función para dividir un arreglo en grupos más pequeños
function chunkArray(array, size) {
    var chunked = [];
    for (var i = 0; i < array.length; i += size) {
        chunked.push(array.slice(i, i + size));
    }
    return chunked;
}

// Calcular la ruta para un grupo de waypoints
function calculateRoute(groupIndex) {
    if (groupIndex < chunkedWaypoints.length) {
        var chunk = chunkedWaypoints[groupIndex];

        // Crear una solicitud de ruta para el grupo actual
        var request = {
            origin: chunk[0], // El primer punto es el origen
            destination: chunk[chunk.length - 1], // El último punto es el destino
            waypoints: chunk.slice(1, -1).map(function (waypoint) {
                return { location: waypoint, stopover: true };
            }), // Los puntos intermedios son waypoints
            travelMode: 'DRIVING' // Modo de viaje (puedes cambiarlo según tus necesidades)
        };

        // Calcular la ruta utilizando DirectionsService
        directionsService.route(request, function (response, status) {
            if (status === 'OK') {
                // Almacenar la respuesta en el arreglo de respuestas
                responses.push(response);

                // Verificar si se han calculado todas las rutas
                if (responses.length === chunkedWaypoints.length) {
                    // Combinar todas las respuestas y mostrar la ruta completa en el mapa
                    var combinedResponse = mergeResponses(responses);
                    directionsDisplay.setDirections(combinedResponse);

                    // Calcular las distancias
                    calculateDistances();
                }

                // Calcular la siguiente ruta para el siguiente grupo
                calculateRoute(groupIndex + 1);
            } else {
                console.error('Error al calcular la ruta: ' + status);
            }
        });
    }
}

// Combinar respuestas de rutas en una sola
function mergeResponses(responses) {
    var combinedResponse = responses[0];

    // Combinar waypoints de rutas intermedias
    for (var i = 1; i < responses.length; i++) {
        combinedResponse.routes[0].legs = combinedResponse.routes[0].legs.concat(responses[i].routes[0].legs);
    }

    return combinedResponse;
}

function calculateDistances() {
    // Calcular distancias entre puntos en la ruta completa
    var route = directionsDisplay.getDirections().routes[0]; // Obtener la ruta del DirectionsRenderer
    var distances = []; // Un arreglo para almacenar las distancias
    var j = 1; // Variable para llevar un seguimiento del punto 2 en cada distancia

    // Iterar a través de las (legs) de la ruta
    for (var i = 0; i < route.legs.length; i++) {
        var leg = route.legs[i]; // Obtener la legs actual de la ruta

        // Crear un objeto con información de la distancia entre dos puntos
        distances.push({
            point1: i, // Punto de inicio (índice de la legs actual)
            point2: j, // Punto de llegada (se incrementa en cada iteración)
            meters: leg.distance.value, // Distancia en metros
            kilometers: (leg.distance.value / 1000).toFixed(3) // Distancia en kilómetros con 3 decimales
        });

        // Agregar información de distancia al elemento HTML con id 'distances'
        document.getElementById('distances').innerHTML += "<td>Punto " + i + " a punto " + j + ":</td><td>" + distances[i].meters + " m</td><td>" + distances[i].kilometers + " km</td>";

        j++; // Incrementar el punto de llegada para la próxima distancia
    }

    distancesKtoM = distances; // Asignar el arreglo de distancias a la variable global distancesKtoM
    //console.log('Distancias para la ruta completa:', distances); // Mostrar las distancias en la consola
    insertDistance(); // Llamar a la función para insertar las distancias en una base de datos.
}



// Inserta registro en la tabla Distance
function insertDistance() {
    for (var i = 0; i < distancesKtoM.length; i++) {
        var distanceData = {
            point1: distancesKtoM[i].point1,
            point2: distancesKtoM[i].point2,
            meters: distancesKtoM[i].meters,
            kilometers: distancesKtoM[i].kilometers,
            token: csrfToken,
            _csrf: csrfToken
        };

        $.post(homeurl + "?r=distance/create", distanceData, function (data) {
            //console.log(data);
            //insertCoordinates(idDistance); // Inserta coordenadas relacionadas con esta distancia
        });
    }
}

// Inserta coordenadas relacionadas con la distancia en la tabla Coordinate
function insertCoordinates() {
    for (var i = 0; i < waypoints.length; i++) {
        var coordinateData = {
            idDistance: idDistance = null,
            latitude: waypoints[i].lat,
            longitude: waypoints[i].lng,
            token: csrfToken,
            _csrf: csrfToken
        };

        $.post(homeurl + "?r=coordinate/create", coordinateData, function (data) {
            //console.log("Insert Coordinate: ", data);
            show();
        });
    }
}

// Esta función se llama "show".
function show() {
    // Realiza una solicitud POST utilizando jQuery ($.post).
    // La URL a la que se envía la solicitud POST es "homeurl" + "?r=coordinate/show".
    // También se envían dos parámetros en la solicitud POST:
    $.post(homeurl + "?r=coordinate/show", { token: csrfToken, _csrf: csrfToken },
        // La función de devolución de llamada se ejecutará cuando se reciba una respuesta del servidor.
        function (data) {
            // Después de recibir la respuesta del servidor, se realiza lo siguiente:

            // Actualizar el contenido de un elemento HTML con el id "coordinates"
            // con los datos recibidos del servidor.
            document.getElementById('coordinates').innerHTML = data;
        });
}
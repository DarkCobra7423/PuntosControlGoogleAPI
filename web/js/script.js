
var map;
var directionsService;
var directionsDisplay;
var idDistance;
var point1;
var point2;

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


// Crear una instancia de DirectionsService de Google Maps.
var directionsService = new google.maps.DirectionsService();
// Crear una instancia de DirectionsRenderer de Google Maps.
var directionsDisplay = new google.maps.DirectionsRenderer();

// Inicializar el mapa
map = new google.maps.Map(document.getElementById('map'), {
    center: { lat: 19.427004658082968, lng: -99.16691826012136 }, // Coordenadas iniciales 19.427004658082968, -99.16691826012136
    zoom: 10 // Nivel de zoom inicial
});
directionsDisplay.setMap(map);

// Variables para almacenar los puntos de control
var markers = [];

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
    var coordinates = markers.map(function (marker) {
        return marker.getPosition().toUrlValue();
    });
    //console.log(coordinates); // Puedes enviar esto al servidor o mostrarlo en la página
    finalCoordinates(coordinates);

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
        //insertCoordinate(latitude, longitude);//----------------

        // Agregar el objeto al arreglo final
        finalCoordinates.push(objectCoordinate);
    }

    // Imprimir el arreglo final en la consola
    //console.log(finalCoordinates);
    drawRoute(finalCoordinates);
}

function drawRoute(drawCoordinates) {
    // Crear un arreglo de "waypoints" a partir del arreglo "drawCoordinates".
    // Cada "waypoint" es un objeto con una "location" (coordenada) y "stopover" (parada) con valor true.
    var waypoints = drawCoordinates.map(function (coordinate) {
        return {
            location: coordinate,
            stopover: true
        };
    });

    // Crear un objeto "request" que representa una solicitud a la API de Google Maps Directions.
    var request = {
        // Establecer el punto de origen como la primera coordenada en el arreglo "drawCoordinates".
        origin: drawCoordinates[0],
        // Establecer el punto de destino como la última coordenada en el arreglo "drawCoordinates".
        destination: drawCoordinates[drawCoordinates.length - 1],
        // Establecer los "waypoints" para incluir todas las coordenadas en el arreglo "waypoints" creado anteriormente.
        waypoints: waypoints,
        // Establecer el modo de viaje como "DRIVING" (conducción).
        travelMode: 'DRIVING'
    };


    // La función directionsService.route realiza una solicitud a la API de Google Maps
    // para obtener una ruta entre dos puntos (request) y luego ejecuta una función de devolución de llamada.
    directionsService.route(request, function (response, status) {
        // Verificar si la respuesta de la API es 'OK', lo que significa que se encontró una ruta.
        if (status === 'OK') {
            // Establecer la dirección de la ruta en el objeto directionsDisplay para mostrarla en el mapa.
            directionsDisplay.setDirections(response);
            var j = 1;
            //var drawCoordinate = parseInt(drawCoordinates.length);
            for (var i = 0; i <= drawCoordinates.length; i++) {

                if (drawCoordinates[i] === undefined || drawCoordinates[j] === undefined) {
                    var distance = null;
                } else {
                    var distance = calculateDistanceBetweenPoints(drawCoordinates[i], drawCoordinates[j]).toFixed(2);
                }
                //console.log("Distancias a calcular: " + drawCoordinates[i].lat + drawCoordinates[i].lng + "---" + drawCoordinates[j].lat + drawCoordinates[j].lng);
                if (distance != null) {
                    // Mostrar la distancia en metros y convertirla a kilómetros.
                    document.getElementById('distances').innerHTML += "<td>Punto " + i + " a punto " + j + ":</td><td>" + distance + " m</td><td>" + metersToKilometers(distance) + " km</td>";
                    //console.log("Distancia entre punto " + i + " y punto " + j + ": " + distance.toFixed(2) + " metros son aproximadamente:" + metersToKilometers(distance.toFixed(2)) + " kilómetros.");
                }
                // Insertar la distancia en una función de inserción de a la base de datos (insertDistance).
                insertDistance(distance, metersToKilometers(distance), i, j, drawCoordinates[i].lat, drawCoordinates[i].lng);

                j++;
            }

        } else {
            // Si la respuesta de la API no es 'OK', mostrar un mensaje de error en la consola.
            console.error('Error al calcular la ruta: ' + status);
        }
    });

}


// Esta función calcula la distancia en metros entre dos puntos geográficos.
// Los puntos se representan mediante coordenadas de latitud y longitud.
function calculateDistanceBetweenPoints(coordinate1, coordinate2) {
    // Crear un objeto LatLng de Google Maps para el primer punto.
    var point1 = new google.maps.LatLng(coordinate1.lat, coordinate1.lng);
    // Crear un objeto LatLng de Google Maps para el segundo punto.
    var point2 = new google.maps.LatLng(coordinate2.lat, coordinate2.lng);
    // Calcular la distancia entre los dos puntos utilizando la función computeDistanceBetween.
    var distance = google.maps.geometry.spherical.computeDistanceBetween(point1, point2);

    // Devolver la distancia en metros.
    return distance;
}



function metersToKilometers(meters) {
    // 1 metro es igual a 0.001 kilómetros
    var kilometers = meters * 0.001;
    // Redondear a 3 decimales
    var roundedkilometers = Math.round(kilometers * 1000) / 1000;

    return roundedkilometers;
}
//Inserta registro en la tabla Coordinate
function insertCoordinate(idDistance, point1, point2, latitude, longitude) {

    $.post(homeurl + "?r=coordinate/create", { idDistance: idDistance, point1: point1, point2: point2, latitude: latitude, longitude: longitude, token: csrfToken, _csrf: csrfToken },
        function (data) {
            //console.log(data);
        });
    show();
}
//Inserta registro en la tabla Distance
function insertDistance(meters, kilometers, point1, point2, latitude, longitude) {

    $.post(homeurl + "?r=distance/create", { meters: meters, kilometers: kilometers, _csrf: csrfToken },
        function (data) {
            //console.log(data); //Devuelve el id
            insertCoordinate(data, point1, point2, latitude, longitude);
        });
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

<p align="center">
    <a href="https://cloud.google.com/apis?hl=es-419" target="_blank">
        <img src="https://www.gstatic.com/devrel-devsite/prod/v0f868bacf787bf31b228952b4e9f9c852485b2025a1f6f6571309b6d62ea4de2/cloud/images/cloud-logo.svg" height="200px">
    </a>
    <h1 align="center">Proyecto Prueba</h1>
    <br>
</p>

Crear una página web mediante PHP Yii2 que incluya un mapa en el que se pueda crear puntos de control mediante clicks, tenga un botón para generar una lista con las coordenadas secuenciadas, la distancia entre cada punto y dibuje la ruta en el mapa a través del API de Google Directions. 


ESTRUCTURA DE DIRECTORIOS
-------------------

      assets/             Contiene definición de activos
      commands/           Contiene comandos de consola (controllers)
      config/             Contiene configuraciones de aplicaciones
      controllers/        Contiene clases de controlador web
      mail/               Contiene archivos de vista para correos electrónicos
      models/             Contiene clases modelo
      runtime/            Contiene archivos generados durante el tiempo de ejecución
      tests/              Contiene varias pruebas para la aplicación básica
      vendor/             Contiene paquetes de terceros dependientes
      views/              Contiene archivos de vista para la aplicación web
      web/                Contiene el script de entrada y los recursos web


REQUISITOS
------------

Los requisitos mínimos para instalar esta aplicación web son los siguientes:
- Servidor web con PHP 8.2.0.
- Servidor de base de datos MySql o MariaDB.


INSTALACIÓN
------------

### Instalar a través de Git Clone

Si no tiene [git](https://git-scm.com/downloads), puede instalarlo siguiendo las instrucciones
en [git/INSTALL](https://github.com/git/git/blob/master/INSTALL).

- Dirijase al directorio raiz de su servidor `public_html` `htdocs` `www` o `wwwroot`.
- Abra una terminal o un git bash.
- Instale esta aplicación web usando el siguiente comando:

~~~
git clone https://github.com/DarkCobra7423/PuntosControlGoogleAPI.git
~~~

Ahora debería poder acceder a la aplicación a través de la siguiente URL, asumiendo que `ProyectoPrueba` es el directorio
directamente bajo la raíz Web.

~~~
https://127.0.0.1/ProyectoPrueba/web/index.php
~~~

### Instalar desde un archivo ZIP generado por GitHub

- Haga clic en el boton verde de nombre `Code` luego seleccione `Descargar ZIP`.
- Dirijase al directorio raiz de su servidor `public_html`, `htdocs`, `www` o `wwwroot`.
- Extraiga el archivo ZIP.

Ahora debería poder acceder a la aplicación a través de la siguiente URL, asumiendo que `ProyectoPrueba` es el directorio
directamente bajo la raíz Web.

~~~
https://127.0.0.1/ProyectoPrueba/web/index.php
~~~

### Importar la base de datos

- Dirijase al panel de control de su servidor de base de datos.
- Haga clic en `Importar` luego haga clic en seleccionar archivo.
- Busque el directorio `/databases` en el codigo fuente descargado seleccione `/proyectoprueba.sql`.
- Haga clic en continuar.

CONFIGURACIÓN
-------------

### Base de datos

Edite el archivo `config/db.php` con datos reales, por ejemplo:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=proyectoprueba',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
```

### Las tecnologias usadas

Para esta aplicación web se usaron diferentes tecnologias como lo son Framework, Librerias, y los propios lenguajes de programacion a continuacion se enlista los siguiente.
 
 - [Yii2 Framework](https://www.yiiframework.com/)
 - [Bootstrap 5.0](https://blog.getbootstrap.com/2023/07/26/bootstrap-5-3-1/)
 - [Lenguaje de programacion PHP](https://www.php.net/)
 - [Lenguaje de programacion JavaScript](https://www.javascript.com/)
 - [Lenguaje de marcado HTML5](https://lenguajehtml.com/html/)
 - [Recursos de Google Cloud](https://cloud.google.com/apis?hl=es-419)
 

### Desarrollador:
- [Carlos Daniel Angel Padilla (DarkCobra7423)](https://github.com/DarkCobra7423)
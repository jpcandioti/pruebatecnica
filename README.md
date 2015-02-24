Prueba Técnica
==============

### Descargar código fuente del repositorio.

~~~~
$ git clone git://github.com/jpcandioti/pruebatecnica
~~~~


### Cargar vendors de sus repositorios originales.

~~~~
$ cd pruebatecnica
$ composer install
~~~~


### Completar los datos de la API de Twitter (dev.twitter.com).

~~~~
// web/index.php

// Cuenta API de Twitter. (dev.twitter.com)
$app['endroid_twitter.consumer_key']        = '';
$app['endroid_twitter.consumer_secret']     = '';
$app['endroid_twitter.access_token']        = '';
$app['endroid_twitter.access_token_secret'] = '';
$app['endroid_twitter.api_url']             = 'https://api.twitter.com/1.1/';
~~~~


### Testing.

~~~~
$ phpunit tests/API.php
~~~~

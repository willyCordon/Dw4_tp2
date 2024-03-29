<?php
session_start();

// Antes que nada, requerimos el autoload.
require __DIR__ . '/../autoload.php';
require __DIR__ . '/../vendor/autoload.php';

// Guardamos la ruta absoluta de base del proyecto.
$rootPath = realpath(__DIR__ . '/../');

// Normalizamos las \ a /
$rootPath = str_replace('\\', '/', $rootPath);

// Requerimos las rutas de la aplicación.
require $rootPath . '/app/routes.php';

// Instanciamos nuestra App.
$app = new \DaVinci\Core\App($rootPath);

// Arrancamos la App.
$app->run();
<?php
require_once '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/.."); // .env location
$dotenv->load();
// Importa las variables globales.
require_once '../config/config.php';
// Helpers
require_once '../helpers/helpers.php';
// Importa el archivo que se encarga de importar las clases que se utilizen
require_once '../autoload.php';
// Importa las rutas de la aplicación web.
require_once '../App/routes.php';

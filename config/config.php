<?php

define('BASE_URL', $_ENV['BASE_URL']);
// Database
const DB_HOST = 'localhost';

define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);
define('DB_NAME', $_ENV['DB_NAME']);

// Zona horaria
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Separadores para el formato de moneda
const SPD = ".";
const SPM = ",";

//Simbolo de moneda
const SMONEY = "$";

// Crear variables constantes
//Datos envio de correo
const NOMBRE_REMITENTE = "Tienda Virtual";
const EMAIL_REMITENTE = "no-reply@empresa.com";
const NOMBRE_EMPESA = "Tienda Virtual";
const WEB_EMPRESA = "https://jonathanrs.000webhostapp.com";

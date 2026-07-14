<?php

use Dotenv\Dotenv;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv::createImmutable(__DIR__ . '/');
$dotenv->safeLoad();

function Conectarse()
{
  $dsn = "sqlsrv:Server={$_ENV['DB_HOST']};Database={$_ENV['DB_NAME']}";
  $username = $_ENV['DB_USERNAME'] ?? NULL;
  $password = $_ENV['DB_PASSWORD'] ?? NULL;
  $conn = new PDO($dsn, $username, $password);

  if ($conn === false) {
    echo "Unable to connect.</br>";
    die(print_r(sqlsrv_errors(), true));
  }

  return $conn;
}

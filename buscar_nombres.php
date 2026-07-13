<?php
// buscar_nombres.php

// Conecta a la base de datos (reemplaza con tu código de conexión)
require_once './conexion.php';
$connection = Conectarse();

// Obtiene el valor de búsqueda desde la solicitud POST
$query = $_POST['query'];

// Realiza la búsqueda en la base de datos (ajusta la consulta según tu esquema)
$sql = "SELECT NOMBRE FROM datos_personales WHERE NOMBRE LIKE '%$query%';";
$stmt = $connection->prepare($sql);
$stmt->execute();

// Obtiene y muestra los resultados como opciones para el datalist
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($resultados as $resultado) {
    echo '<option value="' . htmlspecialchars($resultado['NOMBRE']) . '">';
}
?>

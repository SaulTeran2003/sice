<?php
require_once __DIR__ . '/utils/functions.php';
protect_route();
require_once 'conexion.php';
$connection = Conectarse();

header('Content-Type: application/json');

try {
    // Obtener parámetros de filtrado, si se proporcionan
    $rfc = isset($_POST['rfc']) ? $_POST['rfc'] : '';
    $numcontrol = isset($_POST['numcontrol']) ? $_POST['numcontrol'] : '';
    $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';

    // Construir la consulta base
    $consulta = 'SELECT rfc, fecha, numcontrol, incidencias, endd FROM datos WHERE 1=1';

    // Agregar condiciones según los parámetros proporcionados
    if (!empty($rfc)) {
        $consulta .= " AND rfc = '$rfc'";
    }
    if (!empty($numcontrol)) {
        $consulta .= " AND numcontrol = '$numcontrol'";
    }
    if (!empty($fecha)) {
        $consulta .= " AND fecha = '$fecha'";
    }

    // Ejecutar la consulta
    $statement = $connection->prepare($consulta);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al obtener datos desde la base de datos.']);
}

$connection = null;
?>
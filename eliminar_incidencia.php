<?php
// Verifica que se haya recibido la solicitud mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibe los parámetros del formulario
    $numcontrol = isset($_POST['numcontrol']) ? $_POST['numcontrol'] : null;
    $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : null;

    // Validaciones adicionales si es necesario

    // Realiza la conexión a la base de datos (reemplaza con tu lógica de conexión)
    require_once 'conexion.php';
    $connection = Conectarse();

    // Prepara la consulta para eliminar la incidencia
    $deleteConsulta = "DELETE FROM datos WHERE numcontrol = :numcontrol AND fecha = :fecha";
    $deleteStatement = $connection->prepare($deleteConsulta);
    $deleteStatement->bindParam(':numcontrol', $numcontrol, PDO::PARAM_STR);
    $deleteStatement->bindParam(':fecha', $fecha, PDO::PARAM_STR);

    // Intenta ejecutar la consulta
    try {
        $deleteStatement->execute();

        // Devuelve una respuesta JSON con un mensaje de éxito
        echo json_encode(['message' => 'Incidencia eliminada correctamente']);
    } catch (PDOException $e) {
        // En caso de error, devuelve una respuesta JSON con un mensaje de error
        echo json_encode(['error' => 'Error al eliminar la incidencia']);
    }
} else {
    // Si la solicitud no es mediante POST, devuelve una respuesta JSON con un mensaje de error
    echo json_encode(['error' => 'Solicitud no válida']);
}
?>
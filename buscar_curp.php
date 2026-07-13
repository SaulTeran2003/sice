<?php

require_once __DIR__ . '/utils/functions.php';
protect_route();

require_once 'conexion.php';
$connection = Conectarse();

$numeroProfesor = $_POST["NE"];

$Consulta_CURP = "SELECT CURP FROM datos_personales WHERE NUMEMP = :numeroProfesor";
$stmt= $connection->prepare($Consulta_CURP);
$stmt->bindValue(':numeroProfesor', $numeroProfesor, PDO::PARAM_STR);
$stmt->execute();
$CURPP = $stmt->fetch(PDO::FETCH_ASSOC);

if ($CURPP) {
    echo $CURPP["CURP"];
} else {
    echo "No se encontró CURP.";
}

$connection = null;
?>
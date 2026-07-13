<?php

require_once __DIR__ . '/utils/functions.php';
protect_route();

require_once 'conexion.php';
$connection = Conectarse();

$CURP = $_POST['curp'];
$TIPO_BAJA = $_POST['tbaja'];
$FECHA = $_POST['fechabaja'];
$OBS = $_POST['OBSER'];

$inserta_datos="INSERT INTO Bajas(CURP,TIPO_BAJA, FECHA, OBSERVACIONES) VALUES('$CURP','$TIPO_BAJA','$FECHA','$OBS')";
$Change_Status="UPDATE datos_laborales SET ESTATUS='$TBaja' WHERE CURP='$CURP'";

$Status=$connection->prepare($Change_Status);
$Status->execute();
$statement = $connection->prepare($inserta_datos);
if ($statement->execute()) {
       $_SESSION['mensaje'] = "La baja de $CURP se ha realizado exitosamente.";
} else {
       $_SESSION['error'] = "Ocurrió un error al guardar los datos.";
   }
header("Location: Bajas.php");

?>

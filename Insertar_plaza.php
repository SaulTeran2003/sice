<?php

require_once __DIR__ . '/utils/functions.php';
protect_route();

require_once 'conexion.php';
$connection = Conectarse();


$CURP = $_POST['CURPP'];
$SUB = $_POST['SUB'];
$CLAV = $_POST['CLAV'];
$NP = $_POST['NP'];
$CLAVE = $_POST['CLAVE'];
$MOV = $_POST['MOV'];
$FIN = $_POST['FIN'];
$FTE = $_POST['FTE'];
$FAC = $_POST['FAC'];
$HIS = $_POST['HIS'];
$TP = $_POST['TP'];

$nombreArchivo = $_FILES['FUP']['name'];
$tipoArchivo = $_FILES['FUP']['type'];
$tamanoArchivo = $_FILES['FUP']['size'];
$archivoTemporal = $_FILES['FUP']['tmp_name'];

$directorioDestino = 'FUPs/';
$nombreUnico = uniqid() . '_' . $nombreArchivo;
$rutaCompleta = $directorioDestino . $nombreUnico;

$Consulta_CURP = "SELECT CURP FROM datos_personales WHERE CURP='$CURP'";
$stm= $connection->prepare($Consulta_CURP);
$stm->execute();
$result=$stm->fetchAll(PDO::FETCH_ASSOC);

if(count($result) > 0){

       if (move_uploaded_file($archivoTemporal, $rutaCompleta)) {
              $inserta_dato="INSERT INTO plazas(CURP,SUB,CLAV,NP,CLAVE,MOV,FIN,FTE,FAC,HIS,TP,FUP) VALUES('$CURP','$SUB','$CLAV','$NP','$CLAVE','$MOV','$FIN','$FTE','$FAC','$HIS','$TP','$rutaCompleta')";
              $statement = $connection->prepare($inserta_dato);
              if ($statement->execute()) {
                     $_SESSION['mensaje'] = "La plaza de $CURP se ha dado de Alta correctamente.";
              } else {
                     $_SESSION['error'] = "Ocurrió un error al guardar los datos.Favor de revisar la informacion ingresada";
              }       
       }}

else{
       $_SESSION['mensaje'] = "EL CURP: $CURP No esta asignado ningun personal activo, 
                                   favor de revisar los datos ingresados, o realizar el alta del personal";
}
header("Location: alta.php");
          exit();

?>

<?php
       require_once __DIR__ . '/utils/functions.php';
       protect_route();

       require_once 'conexion.php';
       $connection = Conectarse();


//Datos Personales
$CURP = $_POST['curp'];
$RFC = $_POST['rfc'];
$HOMOCLAVE = substr($RFC, -3);
$EMAIL = $_POST['correo'];
$NOMBRES = $_POST['nombre'];
$APELLIDOPAT = $_POST['apellidoPaterno'];
$APELLIDOMAT = $_POST['apellidoMaterno'];
$NOMBRE=$NOMBRES." ".$APELLIDOPAT." ".$APELLIDOMAT;
$SEXO = $_POST['sexo'];
$NPADRE = $_POST['nombrePadre'];
$NMADRE = $_POST['nombreMadre'];
$CIVIL = $_POST['estadoCivil'];
$CONYUGUE = $_POST['nombreCon'];
$EDAD = $_POST['edad'];
$FECHANACI = $_POST['fechaNa'];
$NACION = $_POST['nacionalidad'];
$LUGARNACE = $_POST['lugarNa'];
$NUMEMP  = $_POST['numEmpleado'];
$NUMINTER = $_POST['numint'];
$LENNAT = $_POST['hablanteLengua'];
$DISCAPACIDAD = $_POST['discapacidad'];

//Domicilio
$DOMICILIO = $_POST['calle'];
$COLONIA = $_POST['colonia'];
$DELEGACION = $_POST['alcal'];
$ENTIDAD = $_POST['estado']; //cambiar por un select

//Contacto
$TELOFI = $_POST['telOf'];
$TELCASA = $_POST['telCasa'];

//Datos Laborales
$NUMCONTRATO = $_POST['numContrato'];
$TURNO   = $_POST['turno'];
$FUNCION  = $_POST['funcion'];
$UBICACION  = $_POST['ubicacion'];
$ADS= $_POST['ads'];
$TIPO = $_POST['tipo'];
$AREACHECA = $_POST['acheca'];
// $IDFUN = $_POST['idfun'];
// $MODALIDAD  = $_POST['modalidad'];
// $CHECADOR  = $_POST['checador'];

//Datos Academicos
$NIVEL = $_POST['NIVEL'];
$OTRO_EST = $_POST['OTRO_EST'];
$NUM_CEDULA = $_POST['NUM_CEDULA'];
$SIGUE_ESTUDIANDO = $_POST['SIGUE_ESTUDIANDO'];
$QUE_ESTUDIA = $_POST['QUE_ESTUDIA'];
$DONDE_ESTUDIA = $_POST['DONDE_ESTUDIA'];
// $ID_HISTORIAL = $_POST['ID_HISTORIAL'];
$TITULADO = $_POST['TITULADO_NOTITULADO'];
 //llenado del id estudio
$ID_NIVEL=0;
if($NIVEL=='LIC. PASANTE'){$ID_NIVEL=1;}
elseif($NIVEL=='LIC. TITULADO'){$ID_NIVEL=2;}
elseif($NIVEL=='MAESTRIA'){$ID_NIVEL=3;}
elseif($NIVEL=='DOCTORADO'){$ID_NIVEL=4;}
elseif($NIVEL=='SECUNDARIA'){$ID_NIVEL=5;}
elseif($NIVEL=='BACHILLERATO'){$ID_NIVEL=6;}
elseif($NIVEL=='ESP. O POSGRADO'){$ID_NIVEL=7;}
elseif($NIVEL=='S/DOCUMENTOS'){$ID_NIVEL=8;}

//Datos Adicionales
$OBSER = $_POST['OBSER'];

//echo" Datos que no llegan: $AREACHECA $ADS $TIPO $IDFUN";

$sql = "SELECT * FROM datos_personales WHERE CURP = '$CURP'";
$statement4=$connection->prepare($sql);
$statement4->execute();
$result=$statement4->fetchAll(PDO::FETCH_ASSOC);


if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

if (count($result) > 0) {
    // Ya existe el CURP en la tabla, muestra una alerta
    echo "<script>alert('Ya existe este CURP en la base de datos. Sera redirigido para modificar la informacion');";
    echo "window.location = '/sicah-web/consultas/modifica.php';</script>";
} else {

if($_FILES["Foto"]["error"]==0){
       $permitidos=array("image/jpg");
       $file=$_FILES["Foto"]["name"];
       $file_type=strtolower(pathinfo($file,PATHINFO_EXTENSION));
       $size_image=204800;
       if($file_type=="jpg"){
           if($_FILES["Foto"]["size"]<$size_image){
           $ruta='./fotosdb/';
           $fotografia=$ruta.$NUMEMP . '.jpg';
           $resultado=@move_uploaded_file($_FILES["Foto"]["tmp_name"],$fotografia);
           if($resultado){
               ?>
               <script>window.alert('Fotografía Cargada con éxito')</script>
               <?php
               //echo"Fotografía Cargada con éxito";
           }else{
               ?>
               <script>window.alert('No se cargo la fotografía con éxito')</script>
               <?php
               //echo"No se cargo la fotografía con éxito";
           }
       }else{
           ?>
           <script>window.alert('Archivo Excede el limite de tamaño')</script>
           <?php 
       }}else{
           ?>
               <script>window.alert('Archivo NO permitido')</script>
               <?php
           //echo"Archivo NO permitido o excede el tamaño";
       }
   }

$inserta_dato="INSERT INTO datos_personales(RFC,NOMBRE,FNACIMIENTO,NUMEMP,CURP,SEXO,DOMICILIO,COLONIA,DELEG,ENTIDAD,TELCASA,TELOFI,CIVIL,CONYUGE,NPADRE,NMADRE,NACION,TIRNE_DISCAPACIDAD,LUGAR_NACIMIENTO,OBSERVACINES,Edad,HOMOCLAVE,HABLANTE_LENGUA,EMAIL,NUM_DE_INTERNO,FOTO,ESTATUS) VALUES('$RFC','$NOMBRE','$FECHANACI','$NUMEMP','$CURP','$SEXO','$DOMICILIO','$COLONIA','$DELEGACION','$ENTIDAD','$TELCASA','$TELOFI','$CIVIL','$CONYUGUE','$NPADRE','$NMADRE','$NACION','$DISCAPACIDAD','$LUGARNACE','$OBSER','$EDAD','$HOMOCLAVE','$LENNAT','$EMAIL','$NUMINTER','$NUMEMP','5')";
$statement = $connection->prepare($inserta_dato);

$inserta_lab="INSERT INTO datos_laborales(CURP,NUMCON,TURNO,ADS,UBICACION,TIPO,CHECA,AREA_DE_CHECADO,MODALIDAD,ID_FUNCION,FUNCION,ESTATUS) VALUES('$CURP','$NUMCONTRATO','$TURNO','$ADS','$UBICACION','$TIPO','$CHECADOR','$AREACHECA','$MODALIDAD','$IDFUN','$FUNCION','5')";
$statement2 = $connection->prepare($inserta_lab); 

$inserta_est="INSERT INTO datos_estudio(CURP,NIVEL,OTRO_EST,NUM_CEDULA,SIGUE_ESTUDIANDO,QUE_ESTUDIA,DONDE_ESTUDIA,ID_HISTORIAL,TITULADO_NOTITULADO,ID_NIVEL) VALUES('$CURP','$NIVEL','$OTRO_EST','$NUM_CEDULA','$SIGUE_ESTUDIANDO','$QUE_ESTUDIA','$DONDE_ESTUDIA','$ID_HISTORIAL','$TITULADO','$ID_NIVEL')";
$statement3 = $connection->prepare($inserta_est);

$mensaje = '';

    if ($statement->execute() && $statement2->execute() && $statement3->execute()) {
        $mensaje = "El Alta de $CURP se ha realizado correctamente.";
    } else {
        $mensaje = "Ocurrió un error. Verifica los datos e inténtalo de nuevo.";
    }

    $_SESSION['mensaje'] = $mensaje;

header("Location: alta.php");
}
?>
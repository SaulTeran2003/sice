<?php
    require_once __DIR__ . '/utils/functions.php';
    protect_route();
    
      require_once 'conexion.php';
      $connection = Conectarse();
    
      $numcontrol = $_POST['numcontrol'];
      $nombre = $_POST['nombre'];
      $rfc = $_POST['rfc'];
      $prefectura = $_POST['prefecturas'];
      $fecha = $_POST['fecha'];
      $endd = $_POST['endd'];
      $turno = $_POST['turno'];
      $horario = $_POST['horario'];
      $incidencias = $_POST['incidencias'];
      $observaciones = $_POST['observaciones'];
      $flag = false;
         

        if ($numcontrol === "" || $nombre === "" || $rfc === "" || $prefectura === "" || $fecha === "" || $turno === "" || $horario === "" || empty($incidencias) ) {
            $flag = true;
        }

        
        if ($flag) {
            // si alguna variable está vacía
            $_SESSION['mensaje'] = "Favor de llenar todos los campos del formulario";
            $_SESSION['numcontrol'] = $numcontrol;
            $_SESSION['nombre'] = $nombre;
            $_SESSION['rfc'] = $rfc;
            $_SESSION['prefecturas'] = $prefectura;
            $_SESSION['fecha'] = $fecha;
            $_SESSION['endd'] = $endd;
            $_SESSION['turno'] = $turno;
            $_SESSION['horario'] = $horario;
            $_SESSION['incidencias'] = $incidencias;
            $_SESSION['observaciones'] = $observaciones;
            header("Location: Incidencias.php");
                  exit();

        } 
        else {

             // Si todas las variables están llenas
            $consultaExistencia = "SELECT COUNT(*) AS count FROM datos WHERE numcontrol = :numcontrol AND fecha = :fecha";
            $paramsExistencia = array(':numcontrol' => $numcontrol, ':fecha' => $fecha);
            $statementExistencia = $connection->prepare($consultaExistencia);
            $statementExistencia->execute($paramsExistencia);
            $resultExistencia = $statementExistencia->fetch(PDO::FETCH_ASSOC);
            $countExistencia = $resultExistencia['count'];          

              if ($countExistencia > 0) {
                  // Ya existe una incidencia para este número de control en la fecha seleccionada
                  $_SESSION['mensaje'] = "Ya existe una incidencia para este número de control en la fecha seleccionada. Elimina la incidencia para poder agregar una nueva.";
                  header("Location: IncidenciasAutocompletar.php");
                  exit();
              }

            $Consulta_Baja="SELECT TIPO_BAJA, RFC, B.CURP FROM Bajas AS B JOIN datos_personales AS DP ON B.CURP = DP.CURP WHERE DP.RFC = '$rfc';";
            $stmBaja= $connection->prepare($Consulta_Baja);
            $stmBaja->execute();
            $resultBaja=$stmBaja->fetchAll(PDO::FETCH_ASSOC);

            if(count($resultBaja) > 0)
            {
              // El usuario esta dado de baja
              $_SESSION['mensaje'] = "El usuario que esta ingresando:$rfc  esta dado de baja.";
              header("Location: IncidenciasAutocompletar.php");
              exit();
            }

            // si todas las variables están llenas
            $Consulta_RFC = "SELECT RFC,NUM_DE_INTERNO FROM datos_personales WHERE RFC='$rfc' AND NUM_DE_INTERNO='$numcontrol'";
            $stm= $connection->prepare($Consulta_RFC);
            $stm->execute();
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);

            if(count($result) > 0){
              //si el rfc existe en altas

              if($incidencias=="Permiso Económico"){
                //Si se va a registrar un dia economico

                $consulta_DE ="SELECT fecha FROM datos WHERE MONTH(fecha) = MONTH(GETDATE()) AND incidencias='Permiso Económico' AND rfc='$rfc' AND numcontrol='$numcontrol'";
                $estatus=  $connection->prepare($consulta_DE);
                $estatus->execute();
                $resultado=$estatus->fetchAll(PDO::FETCH_ASSOC);
          
                if(count($resultado)>=3){
                  //si ya NO es posible registrar un dia economico
                  $_SESSION['mensaje'] = "El usuario $nombre ya tiene 3 dias economicos registrados, No es posible registrar mas ";
                  $_SESSION['numcontrol'] = $numcontrol;
                  $_SESSION['nombre'] = $nombre;
                  $_SESSION['rfc'] = $rfc;
                  $_SESSION['prefecturas'] = $prefectura;
                  $_SESSION['fecha'] = $fecha;
                  $_SESSION['endd'] = $endd;
                  $_SESSION['turno'] = $turno;
                  $_SESSION['horario'] = $horario;
                  $_SESSION['incidencias'] = $incidencias;
                  $_SESSION['observaciones'] = $observaciones;
                  header("Location: incidencias.php");
                      exit();
                }
                else{
                  //si aun es posible registrar el dia economico
                  $getIncidencias = "INSERT INTO datos (numcontrol, nombre, rfc, prefecturas, fecha, endd, turno, horario, incidencias, observaciones) VALUES ('$numcontrol','$nombre','$rfc','$prefectura','$fecha','$endd','$turno','$horario','$incidencias','$observaciones')";
                  $statement = $connection->prepare($getIncidencias);
                  if ($statement->execute()) {
                          $_SESSION['mensaje'] = "La incidencia: $incidencias de $nombre se ha registrado correctamente.";
                  } else {
                          $_SESSION['error'] = "Ocurrió un error al guardar los datos.";
                      }
                      header("Location: incidencias.php");
                      exit(); 
                }

              }

              $getIncidencias = "INSERT INTO datos (numcontrol, nombre, rfc, prefecturas, fecha, endd, turno, horario, incidencias, observaciones) VALUES ('$numcontrol','$nombre','$rfc','$prefectura','$fecha','$endd','$turno','$horario','$incidencias','$observaciones')";
              $statement = $connection->prepare($getIncidencias);
              if ($statement->execute()) {
                $data = array(
                  'rfc' => $rfc,
                  'fecha' => $fecha,
                  'incidencias' => $incidencias
                );
                $options = array(
                  'http' => array(
                      'header' => "Content-type: application/json\r\n",
                      'method' => 'POST',
                      'content' => json_encode($data),
                  ),
                );
                $context = stream_context_create($options);
                $result = file_get_contents('http://10.7.31.202:3000/notificar-incidencia', false, $context);
                      $_SESSION['mensaje'] = "La incidencia: $incidencias de $nombre se ha registrado correctamente.";
              } else {
                      $_SESSION['error'] = "Ocurrió un error al guardar los datos.";
                  }       
            }

            else{
              $_SESSION['mensaje'] = "EL RFC: $rfc o el Numero de control: $numcontrol de $nombre No esta asignado ningun personal activo,favor de revisar los datos ingresados, o realizar el alta del personal";
              $_SESSION['numcontrol'] = $numcontrol;
              $_SESSION['nombre'] = $nombre;
              $_SESSION['rfc'] = $rfc;
              $_SESSION['prefecturas'] = $prefectura;
              $_SESSION['fecha'] = $fecha;
              $_SESSION['endd'] = $endd;
              $_SESSION['turno'] = $turno;
              $_SESSION['horario'] = $horario;
              $_SESSION['incidencias'] = $incidencias;
              $_SESSION['observaciones'] = $observaciones;
            }
        }
        
        header("Location: IncidenciasAutocompletar.php");
    
?>

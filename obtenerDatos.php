<?php
require_once __DIR__ . '/utils/functions.php';
protect_route();

  require_once 'conexion.php';
  $connection = Conectarse();

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                
            $RFC=$_POST["rfc"];
            $NumControl=$_POST["numcontrol"];

            if(empty($RFC) and empty($NumControl)){
                $_SESSION['mensaje'] = "Favor de llenar algun campo";
                header("Location: IncidenciasAutocompletar.php");
                exit();
            }
            
            
            if(!empty($RFC) and !empty($NumControl)){
                $consulta="SELECT RFC,NUM_DE_INTERNO,NOMBRE FROM datos_personales where NUM_DE_INTERNO='$NumControl' AND RFC='$RFC' ";
            }

            elseif(!empty($RFC))
            {
                $consulta="SELECT RFC,NUM_DE_INTERNO,NOMBRE FROM datos_personales where RFC='$RFC'";
            
            }
            elseif(!empty($NumControl)){
                $consulta="SELECT RFC,NUM_DE_INTERNO,NOMBRE FROM datos_personales where NUM_DE_INTERNO='$NumControl'";
            }

            $statement = $connection->prepare($consulta);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (count($result)>0) {
          
                foreach ($result as $fila) {
                    $_SESSION['numcontrol'] = $fila["NUM_DE_INTERNO"];
                    $_SESSION['nombre'] = $fila["NOMBRE"];
                    $_SESSION['rfc'] = $fila["RFC"];
                }
                
            } 
            else {
                if(!empty($RFC) and !empty($NumControl)){
                    $_SESSION['mensaje'] = "EL Numero de control: $NumControl o el RFC: $RFC no coinciden entre ellos, verifique la informacion o Igrese solo uno para realizar el registro de la incidencia";
                    header("Location: IncidenciasAutocompletar.php");
                    exit();
                  }
                elseif(!empty($RFC)){
                  $_SESSION['mensaje'] = "No se encontraron resultados para el RFC:$RFC";
                  header("Location: IncidenciasAutocompletar.php");
                  exit();
                }
                elseif(!empty($NumControl)){
                  $_SESSION['mensaje'] = "No se encontraron resultados para el Numero de control:$NumControl";
                  header("Location: IncidenciasAutocompletar.php");
                  exit();
                }
                
            }
            }
            header("Location: incidencias.php");
            ?>
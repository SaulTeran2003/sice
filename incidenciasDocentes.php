<?php
  require_once __DIR__ . '/utils/functions.php';
  protect_route();
  require_once 'conexion.php';
  $connection = Conectarse();
  $logout = true;

  ini_set('display_errors',0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['numcontrolEditar']) && isset($_POST['fechaEditar']) && isset($_POST['incidenciaEditar'])) {
        $numcontrolEditar = $_POST['numcontrolEditar'];
        $fechaEditar = $_POST['fechaEditar'];
        $incidenciaEditar = $_POST['incidenciaEditar'];

        // Actualiza la incidencia en la base de datos
        $updateConsulta = "UPDATE datos SET incidencias = :incidenciaEditar WHERE numcontrol = :numcontrolEditar AND fecha = :fechaEditar";
        $updateStatement = $connection->prepare($updateConsulta);
        $updateStatement->bindParam(':incidenciaEditar', $incidenciaEditar, PDO::PARAM_STR);
        $updateStatement->bindParam(':numcontrolEditar', $numcontrolEditar, PDO::PARAM_STR);
        $updateStatement->bindParam(':fechaEditar', $fechaEditar, PDO::PARAM_STR);
        $updateStatement->execute();

        $_SESSION['success_message'] = 'La incidencia se actualizó correctamente.';
        // Redirige a la misma página después de la actualización
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="css/stylesIncidencias.css"> -->
    <link href="./css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="img/logoSICAH.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous" defer></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    <title>Incidencias</title>
</head>
<body>
    <?php include_once './partials/header_ipn.php'; ?>
    <?php include_once './partials/header.php'; ?>

    <?php
    $tipo_usuario='';
    $_SESSION['user']['TIPO_USUARIO'];
    $tipo_usuario=$_SESSION['user']['TIPO_USUARIO'];;
    if(!empty($tipo_usuario)){
            echo '<table border="0" width="100%">';
        echo'</br>';
        echo'</br>';
        echo '<td align="center" colspan="4">';
            echo'<strong><h2>Consulte sus Incidencias</h2></strong> ';
        echo'</td>';
            echo'</table>';
        echo'</br>';
        echo'</br>';
      ?>

<div class="container">

<script>
        function verificarRFC(){
          
          let rfcInput = document.getElementById("rfc");
          let rfc = rfcInput.value.trim();
          let resultado = document.getElementById("resultado");

          let rfcRegex = /^[A-Z]{4}\d{6}[A-Z0-9]{3}$/; 

          if (rfcRegex.test(rfc)){
            resultado.textContent = "El RFC ingresado es válido.";
            resultado.classList.remove("text-danger");
            resultado.classList.add("text-success"); 
          } else {
            resultado.textContent = "El RFC ingresado no es válido. Verifica el formato.";
            resultado.classList.remove("text-success");
            resultado.classList.add("text-danger"); 
          }
        }

        function convertirMayusculas() {
            var ids = ["numcontrol", "rfc", "homoClave", "email", "Nombres", "apellidoPaterno", "apellidoMaterno", "sexo", "nombrePadre", "nombreMadre", "nombreConyuge", "edad", "numEmpleado", "numint", "calle", "col", "alcal","estado", "telof", "telca", "numCon", "turno", "fun", "ubicacion", "ads", "tipo", "acheca", "exampleFormControlTextarea1", "CURPP", "SUB", "CLAV", "NP", "CLAVE", "MOV", "FIN", "FTE", "FAC", "HIS", "TP", "ENCARGADO", "NIVEL", "DICTAMEN"]; 
            for (var i = 0; i < ids.length; i++) {
                var elemento = document.getElementById(ids[i]);
                if (elemento) {
                    elemento.value = elemento.value.toUpperCase();
                }
            }
        }

        function verificarNumeroControl() {
            let numControlInput = document.getElementById("numcontrol");
            let numControl = numControlInput.value.trim();
            let resultado = document.getElementById("resultadoNumControl");

            let numControlRegex = /^[A-ZÑa-zñ0-9]{5,6}$/;

            if (numControlRegex.test(numControl)) {
                resultado.textContent = "El número de control ingresado es válido.";
                resultado.classList.remove("text-danger");
                resultado.classList.add("text-success");
            } else {
                resultado.textContent = "El número de control ingresado no es válido. Verifica el formato.";
                resultado.classList.remove("text-success");
                resultado.classList.add("text-danger");
            }
        }
</script>
        <div class="row">
            <h3>Incidencias de Usuario</h3>
            <form class="row g-3" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
               <div class="col-8">
                    <label for="rfc" class="form-label">RFC(Con HOMOCLAVE)</label>
                    <input type="text" class="form-control" id="rfc" name="rfc"  placeholder="RFC" maxlength=13 oninput="convertirMayusculas(); verificarRFC();" pattern="^[A-Z]{4}\d{6}[A-Z0-9]{3}$" value="<?php if (isset($_SESSION['rfc'])) { echo htmlspecialchars($_SESSION['rfc']); unset($_SESSION['rfc']);} ?>">
                    <span id="resultado" class="text-danger"></span>
                </div>
                <div class="col-8">
                    <label for="numcontrol" class="form-label">Numero de Control</label>
                    <input type="text" class="form-control" id="numcontrol" name="numcontrol" placeholder="No. de Control" maxlength=6 oninput="convertirMayusculas(); verificarNumeroControl();" pattern="^[A-Za-z0-9]{5,6}$">
                    <span id="resultadoNumControl" class="text-danger"></span>
                </div>
                <div class="col-8">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" id="fecha" name="fecha">
                </div>
              
                <div class="row mt-4 mx-3 mb-4">
                  
                   <div class="col-3">
                   <button id="consultarTablaBtn" type="submit" class="btn btn-primary w-100 h-100" onclick="return validarConsulta();">Consultar Tabla</button>
                   </div>
                   
                </div>

            </form>

          <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              $rfc = $_POST["rfc"];
              $numcontrol = $_POST["numcontrol"];
              $fecha = $_POST["fecha"];

              if (!empty($rfc) || !empty($numcontrol) || !empty($fecha)) {
                  if (!empty($rfc) && !empty($numcontrol)) {
                      $consulta = "SELECT nombre, fecha, numcontrol, incidencias FROM datos WHERE rfc = :rfc AND numcontrol = :numcontrol";
                      if (!empty($fecha)) {
                          $consulta .= " AND fecha = :fecha";
                      }
                      $statement = $connection->prepare($consulta);
                      $statement->bindParam(':rfc', $rfc, PDO::PARAM_STR);
                      $statement->bindParam(':numcontrol', $numcontrol, PDO::PARAM_STR);
                      if (!empty($fecha)) {
                          $statement->bindParam(':fecha', $fecha, PDO::PARAM_STR);
                      }
                  } elseif (!empty($rfc)) {
                      $consulta = "SELECT nombre, fecha, numcontrol, incidencias FROM datos WHERE rfc = :rfc";
                      if (!empty($fecha)) {
                          $consulta .= " AND fecha = :fecha";
                      }
                      $statement = $connection->prepare($consulta);
                      $statement->bindParam(':rfc', $rfc, PDO::PARAM_STR);
                      if (!empty($fecha)) {
                          $statement->bindParam(':fecha', $fecha, PDO::PARAM_STR);
                      }
                  } elseif (!empty($numcontrol)) {
                      $consulta = "SELECT nombre, fecha, numcontrol, incidencias FROM datos WHERE numcontrol = :numcontrol";
                      if (!empty($fecha)) {
                          $consulta .= " AND fecha = :fecha";
                      }
                      $statement = $connection->prepare($consulta);
                      $statement->bindParam(':numcontrol', $numcontrol, PDO::PARAM_STR);
                      if (!empty($fecha)) {
                          $statement->bindParam(':fecha', $fecha, PDO::PARAM_STR);
                      }
                  } elseif (!empty($fecha)) {
                      // Consulta específica para mostrar las incidencias del día
                      $consulta = "SELECT nombre, fecha, numcontrol, incidencias FROM datos WHERE fecha = :fecha";
                      $statement = $connection->prepare($consulta);
                      $statement->bindParam(':fecha', $fecha, PDO::PARAM_STR);
                  }

                  $statement->execute();
                  $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                  if (!empty($result)) {
                      echo "<div class='col-12'>";
                      echo "<h2 for='#'>Tabla de Incidencias</h2>";
                      echo "<table class='table table-bordered'>";

                      // Mostrar solo una vez los datos generales
                      if (!empty($result[0]["nombre"]) && !empty($result[0]["numcontrol"])) {
                          echo "<tbody>";
                          echo "<tr><th scope='row'>Nombre:</th><td>" . $result[0]["nombre"] . "</td></tr>";
                          echo "<tr><th scope='row'>No. de Control:</th><td>" . $result[0]["numcontrol"] . "</td></tr>";
                          echo "<tr><th scope='row'>Incidencia:</th><td>" . "</td></tr>";
                          echo "</tbody>";
                      }

                      echo "<tbody>";

                      foreach ($result as $fila) {
                          echo "<tr>";
                          echo "<td>" . $fila["incidencias"] . "</td>";
                          echo "<td>" . $fila["fecha"] . "</td>";
                          echo "<td><button class='btn btn-primary' onclick='editarIncidencia(\"myModal\", \"" . $fila["numcontrol"] . "\", \"" . $fila["fecha"] . "\", \"" . $fila["incidencias"] . "\")'>Editar</button></td>";
                          echo "<td><button class='btn btn-danger' onclick='eliminarIncidencia(\"" . $fila["numcontrol"] . "\", \"" . $fila["fecha"] . "\")'>Eliminar</button></td>";
                          echo "</tr>";
                      }

                      echo "</tbody>";
                      echo "</table>";
                      echo "</div>";
                  } else {
                    if (empty($result) && !empty($rfc) && !empty($numcontrol)) {
                        echo "<h2 class='text-danger'>El Numero de control: $numcontrol o el RFC: $rfc no coinciden entre ellos o no hay una incidencia en la fecha seleccionada, verifique la información de la fecha o ingrese solo un campo (RFC o Numero de control) para realizar la consulta de la incidencia.</h2>";
                    } elseif (empty($result) && !empty($rfc)) {
                        echo "<h2 class='text-danger'>No se encontraron resultados para el RFC: $rfc</h2>";
                    } elseif (empty($result) && !empty($numcontrol)) {
                        echo "<h2 class='text-danger'>No se encontraron resultados para el Numero de control: $numcontrol</h2>";
                    }
                }
              }
            } else {
              // Consulta para obtener todos los datos cuando no hay datos del formulario
              $consulta = "SELECT nombre, fecha, numcontrol, incidencias FROM datos";
              $statement = $connection->prepare($consulta);
              $statement->execute();
              $result = $statement->fetchAll(PDO::FETCH_ASSOC);

              if (!empty($result)) {
                  echo "<div class='col-12'>";
                  echo "<h2 for='#'>Tabla de Incidencias</h2>";
                  echo "<table class='table table-bordered'>";

                  // Mostrar solo una vez los datos generales
                  if (!empty($result[0]["nombre"]) && !empty($result[0]["numcontrol"])) {
                      echo "<tbody>";
                      echo "<tr><th scope='row'>Nombre:</th><td>" . "</td></tr>";
                      echo "<tr><th scope='row'>No. de Control:</th><td>" . "</td></tr>";
                      echo "<tr><th scope='row'>Incidencia:</th><td>" . "</td></tr>";
                      echo "</tbody>";
                  }

                  echo "<tbody>";

                  foreach ($result as $fila) {
                      // echo "<tr>";
                      // echo "<td>" . $fila["incidencias"] . "</td>";
                      // echo "<td>" . $fila["fecha"] . "</td>";
                      // echo "<td><button class='btn btn-primary' onclick='editarIncidencia(\"myModal\", \"" . $fila["numcontrol"] . "\", \"" . $fila["fecha"] . "\", \"" . $fila["incidencias"] . "\")'>Editar</button></td>";
                      // echo "<td><button class='btn btn-danger' onclick='eliminarIncidencia(\"" . $fila["numcontrol"] . "\", \"" . $fila["fecha"] . "\")'>Eliminar</button></td>";
                      // echo "</tr>";
                  }

                  echo "</tbody>";
                  echo "</table>";
                  echo "</div>";
              } else {
                  // echo "<h2 class='text-danger'>No hay resultados para mostrar.</h2>";
              }
            }
          ?>

                <div class="row mt-4 mx-3 mb-4">
                   <div class="col-3">
                     <button id="consultarBtn" type="submit" class="btn btn-primary w-100 h-100" onclick="return validarConsulta();">Consultar Calendario</button>
                   </div>                  
                </div>



                <div class="row mt-4 mx-3 mb-4">
                  <div  class=" col-12 mb-2">
                      <div id='calendar'></div>
                  </div>
                </div>
           
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Incidencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para editar la incidencia -->
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" id="numcontrolEditar" name="numcontrolEditar">
                        <input type="hidden" id="fechaEditar" name="fechaEditar">
                        <div class="mb-3">
                            <label for="incidenciaEditar" class="form-label">Editar Incidencia</label>
                            <select class="form-select" id="incidenciaEditar" name="incidenciaEditar">
                                  <option value="Act. Comp.">Act. Comp.</option>
                                  <option value="Comisión">Comisión</option>
                                  <option value="Enfermedad">Enfermedad</option>
                                  <option value="Cuidados Familiares">Cuidados Familiares</option>
                                  <option value="Justificantes">Justificantes</option>
                                  <option value="Pago de Tiempo">Pago de Tiempo</option>
                                  <option value="Permiso Económico">Permiso Económico</option>
                                  <option value="Rep. pase de salida">Rep. pase de salida</option>
                                  <option value="Pase de salida">Pase de salida</option>
                                  <option value="Vacaciones">Vacaciones</option>
                                  <option value="Premio">Premio</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
     }else{include('login_fail.php');}
    ?>

    <?php include_once './partials/footer_ipn.php'; ?>

</body>

<script>
    function editarIncidencia(modalId, numcontrol, fecha, incidencia) {
        // Configura el modal con los datos de la incidencia
        document.getElementById('numcontrolEditar').value = numcontrol;
        document.getElementById('fechaEditar').value = fecha;
        document.getElementById('incidenciaEditar').value = incidencia;

        // Abre el modal
        var myModal = new bootstrap.Modal(document.getElementById(modalId));
        myModal.show();
    }
</script>

<script>
    // Verifica si hay un mensaje de éxito y muestra la alerta
    document.addEventListener("DOMContentLoaded", function () {
        <?php
        if (isset($_SESSION['success_message'])) {
            // Imprime el mensaje de éxito y luego limpia la variable de sesión
            echo 'alert("' . $_SESSION['success_message'] . '");';
            unset($_SESSION['success_message']);
        }
        ?>
    });
</script>

<script>
    function eliminarIncidencia(numcontrol, fecha) {
        if (confirm("¿Estás seguro de que quieres eliminar esta incidencia?")) {

            fetch('eliminar_incidencia.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'numcontrol=' + numcontrol + '&fecha=' + fecha,
            })
            .then(response => response.json())
            .then(data => {
                // Actualiza la tabla o realiza cualquier acción adicional
                alert(data.message);
                // Recarga la página para reflejar los cambios
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }
</script>

<script>
function validarConsulta() {
        var rfc = document.getElementById("rfc").value.trim();
        var numcontrol = document.getElementById("numcontrol").value.trim();
        var fecha = document.getElementById("fecha").value.trim();

        if ((rfc === '' && numcontrol === '')) {
            alert('Favor de llenar al menos un campo (RFC o Número de Control).');
            return false;
        }

        return true;
    }
</script>

<script src="js\es.global.min.js"></script>
<script src="js\scriptIncidencias.js"></script>

</html>

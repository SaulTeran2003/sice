<?php
  require_once __DIR__ . '/utils/functions.php';
  protect_route();
  $logout = true;

  if (isset($_SESSION['mensaje'])) {
    echo "<script> alert('" . $_SESSION['mensaje'] . "') </script>";
    unset($_SESSION['mensaje']); // Limpiar el mensaje
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
        echo'<strong><h2>Llene el formulario</h2></strong> ';
      echo'</td>';
        echo'</table>';
    echo'</br>';
    echo'</br>';?>
    <div class="container">
        <div class="row">

    <script>
        function verificarRFC(){
          
          let rfcInput = document.getElementById("rfc");
          let rfc = rfcInput.value.trim();
          let resultado = document.getElementById("resultado");

          let rfcRegex = /^[A-Z]{4}\d{6}[A-Z0-9]{3}$/;
          //let rfcRegex = /^[A-Z]{4}\d{6}$/; 

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

        function convertirMayusculas() {
            var ids = ["numcontrol", "rfc", "homoClave", "email", "Nombres", "apellidoPaterno", "apellidoMaterno", "sexo", "nombrePadre", "nombreMadre", "nombreConyuge", "edad", "numEmpleado", "numint", "calle", "col", "alcal","estado", "telof", "telca", "numCon", "turno", "fun", "ubicacion", "ads", "tipo", "acheca", "exampleFormControlTextarea1", "CURPP", "SUB", "CLAV", "NP", "CLAVE", "MOV", "FIN", "FTE", "FAC", "HIS", "TP", "ENCARGADO", "NIVEL", "DICTAMEN"]; 
            for (var i = 0; i < ids.length; i++) {
                var elemento = document.getElementById(ids[i]);
                if (elemento) {
                    elemento.value = elemento.value.toUpperCase();
                }
            }
        }
 
    </script>
    
            <h3>Registro de incidencias</h3>
            <p>Porfavor ingrese un RFC O un  numero de control para el registro de la incidencia</p>
            <form class="row needs-validation" id="formulario" action="ObtenerDatos.php" novalidate method="post">
                <div class="col-4">
                    <label for="#" class="form-label">Numero de Control</label>
                    <input type="text" class="form-control" id="numcontrol" name="numcontrol" placeholder="No. de Control" maxlength=6 oninput="convertirMayusculas(); verificarNumeroControl();" pattern="^[A-Za-z0-9]{5,6}$" >
                    <span id="resultadoNumControl" class="text-danger"></span>
                </div>
                <div class="col-4">
                    <label for="#" class="form-label">RFC(Con HOMOCLAVE)</label>
                    <input type="text" class="form-control" id="rfc" name="rfc" placeholder="RFC" maxlength=13 pattern="^[A-Z]{4}\d{6}[A-Z0-9]{3}$" oninput="convertirMayusculas(); verificarRFC();">
                    <span id="resultado" class="text-danger"></span>
                </div>
                <div class="row mt-4 mb-4">
                    <input type="submit" class="btn btn-primary w-25">
                </div>
                
            </form>

        </div>
    </div>

<?php
     }else{include('login_fail.php');}
?>

<?php include_once './partials/footer_ipn.php'; ?>

</body>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
      'use strict'
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      const forms = document.querySelectorAll('.needs-validation')

      // Loop over them and prevent submission
      Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()

            alert("Favor de completar los campos requeridos.");
          }

          form.classList.add('was-validated')
        }, false)
      })
    })()
  </script>
</html>

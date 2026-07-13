<?php
  require_once __DIR__ . '/utils/functions.php';
  protect_route();
  $logout = true;

  if (isset($_SESSION['mensaje'])) {
    echo "<script>alert('" . $_SESSION['mensaje'] . "');</script>";
    unset($_SESSION['mensaje']);
    }

  if (isset($_SESSION['error'])) {
      echo "<script>alert('" . $_SESSION['error'] . "');</script>";
      unset($_SESSION['error']);
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SICAH bajas</title>
    <link rel="icon" href="img/logoSICAH.ico" type="image/x-icon">
    <link href="./css/bootstrap.min.css" rel="stylesheet" />
    <link href="./css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"
        defer></script>
    <script defer src="./js/autocomplete.js"></script>
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
    echo'<strong><h2>Seleccione una opción</h2></strong> ';
	echo'</td>';
    echo'</table>';
    echo'</br>';
    echo'</br>';?>

    <div class="container vh-">
      <div class="col-md-auto text-center m-4">
        <h1> Bajas</h1>
      </div>
      <script>
        function verificarCurp(){
          
          let curpInput = document.getElementById("curp");
          let curp = curpInput.value.trim();
          let resultado = document.getElementById("resultado");

          let curpRegex = /^[A-Z]{4}\d{6}[HM][A-Z]{5}[A-Z0-9]{2}$/;

          if (curpRegex.test(curp)){
            resultado.textContent = "El CURP ingresado es válido.";
            resultado.classList.remove("text-danger");
            resultado.classList.add("text-success"); 
          } else {
            resultado.textContent = "El CURP ingresado no es válido. Verifica el formato.";
            resultado.classList.remove("text-success");
            resultado.classList.add("text-danger"); 
          }
        }
      </script>

        <div class="row m-4">
            <form id="formulario-opcion1" action="insertar_baja.php" method="POST" class="needs-validation" novalidate>   <!-- Agregar aqui el action para la conexion y la subida a la BD -->
                <h2>Datos de baja</h2>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">CURP</label>
                            <input type="text" class="form-control" id="curp" name='curp' oninput="verificarCurp()" maxlength=18 required pattern="^[A-Z]{4}\d{6}[HM][A-Z]{5}[A-Z0-9]{2}$">
                            <span id="resultado" class="text-danger"></span>
                            </div>
                        </div>

                <div class="col-md-4">
                    <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Tipo de Baja</label>
                                <select class="form-select" name="tbaja" required>
                                    <option selected disabled value="">Seleccione tipo de baja</option>
                                    <option value="TEMPORAL">Baja temporal</option>
                                    <option value="CAMBIO PLANTEL">Baja por cambio de plantel</option>
                                    <option value="TERMINO DE INTERINATO">Baja por termino de interinato</option>
                                    <option value="RENUNCIA">Baja por renuncia</option>
                                    <option value="JUBILACIÓN">Baja por jubilación</option>
                                    <option value="DEFUNCION">Baja por defunción</option>
                                </select>
                                </div>
                            </div>
                    <div class="col-md-4">
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Fecha de Baja</label>
                            <input type="date" class="form-control" name="fechabaja" required>
                            </div>
                        </div>
                    </div>

                <div class="row mb-4">
                    <div class="col-md-5">
                        <div class="mb-5">
                            <label for="exampleFormControlTextarea1" class="form-label">Observaciones</label>
                            <textarea name="OBSER" class="form-control" id="exampleFormControlTextarea2" rows="5" style="resize: none;"></textarea>
                    </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 offset-md-10 justify-content-end">
                            <button id="mostrarBoton1" type="submit" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#confirmModal">Dar de Baja</button>
                        </div>
                    </div>
                </form>
                <!-- Ventana de confirmacion -->
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
        $(document).ready(function() {
            $('#opcion').on('change', function() {
                var opcionSeleccionada = $(this).val();

                // Oculta todos los formularios
                $('[id^=formulario-]').hide();

                // Muestra el formulario correspondiente a la opción seleccionada
                $('#formulario-' + opcionSeleccionada).show();
            });
        });
        </script>
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
     <!-- <script>
        (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')

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
  </script> -->

</div>

    <?php
     }else{include('login_fail.php');}
    ?>

    <?php include_once './partials/footer_ipn.php'; ?>

</body>

</html>

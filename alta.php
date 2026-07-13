<?php
  require_once __DIR__ . '/utils/functions.php';
  protect_route();
  $logout = true;

    if (isset($_SESSION['mensaje'])) {
        echo "<script>alert('" . $_SESSION['mensaje'] . "')</script>";
        unset($_SESSION['mensaje']); // Limpiar el mensaje
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>SICAH Altas</title>
        <link rel="icon" href="img/logoSICAH.ico" type="image/x-icon">
        <link href="./css/bootstrap.min.css" rel="stylesheet" />
        <link href="./css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"
                defer></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <!-- <script defer src="./js/autocomplete.js"></script> -->
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
      <h1>Altas</h1>
    </div>
    <div class="col-md-auto text-center m-4">
      <h3>Tipo de alta</h3>
    </div>
    <div class="row">
      <div class="col-md-4">
      </div>
      <div class="col-md-4">
        <select id="opcion" class="form-select text-center">
          <option selected disabled value="">Seleccione un tipo de Alta</option>
          <option value="opcion1">Personal</option>
          <option value="opcion2">Plaza</option>
        </select>
      </div>
    </div>

    <script>
        function convertirMayusculas() {
            var ids = ["curp", "RFC", "homoClave", "email", "Nombres", "apellidoPaterno", "apellidoMaterno", "sexo", "nombrePadre", "nombreMadre", "nombreConyuge", "edad", "numEmpleado", "numint", "calle", "col", "alcal","estado", "telof", "telca", "numCon", "turno", "fun", "ubicacion", "ads", "tipo", "acheca", "exampleFormControlTextarea1", "CURPP", "SUB", "CLAV", "NP", "CLAVE", "MOV", "FIN", "FTE", "FAC", "HIS", "TP", "ENCARGADO", "NIVEL", "DICTAMEN"]; 
            for (var i = 0; i < ids.length; i++) {
                var elemento = document.getElementById(ids[i]);
                if (elemento) {
                    elemento.value = elemento.value.toUpperCase();
                }
            }
        }

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

        function verificarCurp1(){
          
          let curpInput = document.getElementById("CURPP");
          let curp = curpInput.value.trim();
          let resultado = document.getElementById("resultado1");

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

        function verificarRFC(){
          
          let rfcInput = document.getElementById("RFC");
          let rfc = rfcInput.value.trim();
          let resultado = document.getElementById("resultado3");

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

        function validarTexto(id,res) {
          let textoInput= document.getElementById(id);
          let texto = textoInput.value.trim();
          let resultado = document.getElementById(res);

          let textoRegex=  /^[A-Za-zñÑ ]*$/;

          if (!textoRegex.test(texto)){
            resultado.textContent = "Ingrese unicamente caracteres validos"; 
          }
          else{
            resultado.textContent = " ";
          }
        }

        function validarTamañoArchivo(input) {
          const maxFileSize = 200 * 1024; // 200 KB en bytes
          const file = input.files[0];
          const flag =true;

          if (file && file.size > maxFileSize) {
            alert("El archivo es demasiado grande. El tamaño máximo permitido es 200KB, Porfavor seleccione otra fotografia");
            input.value = ""; //limpia la carga
          }
        }
        
        function validarCorreoElectronico() {
                var email = document.getElementById("email").value;
                var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                let resultado  = document.getElementById("resultado10"); 

                if (regex.test(email)) {
                  document.getElementById("email").classList.remove("invalid");
                  resultado.textContent = " ";
                } else {
                   document.getElementById("email").classList.add("invalid");
                   resultado.textContent = "El EMAIL ingresado no es válido. Verifica el formato.";
                    resultado.classList.add("text-danger");    
                }
        }

        function validarFormulario() {
                let fileInput = document.getElementById("Foto");
                let file = fileInput.files[0];
                var emailInput = document.getElementById("email");
                let resultado = document.getElementById("resultado11");

                if(!file){
                  alert("Favor de cargar una fotografia");
                  resultado.textContent = "Porfavor cargar una fotografia de MAX 200KB";
                  return false;
                }
                else{
                  resultado.textContent = "";
                }

                if (emailInput.value === "" || emailInput.classList.contains("invalid")) {
                  alert("Favor de completar un correo electrónico válido.");
                  return false; 
                }
                 return true; 
        }

        function verificarNumeroControl() {
            let numControlInput = document.getElementById("numint");
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

    <div class="row m-4">
      <form id="formulario-opcion1" style="display: none;"  action="insertar_alta.php" method="POST" class="needs-validation" enctype="multipart/form-data" onsubmit="return validarFormulario();" novalidate>
        <h2>Datos personales</h2>
        <hr> 
        <div class="row mb-3 justify-content-center">  
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">CURP</label>
              <input type="text" class="form-control" name="curp" id="curp" oninput="convertirMayusculas(); verificarCurp();" maxlength=18 required pattern="^[A-Z]{4}\d{6}[HM][A-Z]{5}[A-Z0-9]{2}$">
              <span id="resultado" class="text-danger"></span>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">RFC(Con HOMOCLAVE)</label>
              <input type="text" class="form-control" name="rfc" id="RFC" oninput="convertirMayusculas(); verificarRFC();" maxlength=13 required pattern="^[A-Z]{4}\d{6}[A-Z0-9]{3}$">
              <span id="resultado3" class="text-danger"></span>
            </div>
          </div>

          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label" >Correo Electronico</label>
              <input type="email" class="form-control" name="correo" id="email" required  oninput="validarCorreoElectronico()">
              <span id="resultado10" class="text-danger"></span>
            </div>
          </div>

          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Fecha de nacimiento</label>
              <input type="date" class="form-control" name="fechaNa" id="fNacimiento" required>
            </div>
          </div>
        </div> 


        <div class="row mb-4">
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Nombre(s)</label>
              <input type="text" class="form-control" name="nombre" id="Nombres" oninput="convertirMayusculas()" maxlength=50 required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Apellido Paterno</label>
              <input type="text" class="form-control" name="apellidoPaterno" id="apellidoPaterno" oninput="convertirMayusculas()" maxlength=50 required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label" >Apellido Materno</label>
              <input type="text" class="form-control" name="apellidoMaterno" id="apellidoMaterno" oninput="convertirMayusculas()" maxlength=50>
            </div>
          </div>
          <div class="col-md-3 ">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Sexo</label>
              <select class="form-select" name="sexo" id="sexo" required>
              <option selected disabled value=""></option>
                <option value="1">Masculino</option>
                <option value="2">Femenino</option>
              </select>
            </div>
          </div>
        </div>  

        <div class="row mb-3">
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Nombre Padre (COMPLETO)</label>
              <input type="text" class="form-control" name="nombrePadre" id="nombrePadre" oninput="convertirMayusculas(); validarTexto('nombrePadre','resultado4');" maxlength=100 required pattern="^[A-Za-zñÑ ]*$">
              <span id="resultado4" class="text-danger"></span>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label" >Nombre Madre (COMPLETO)</label>
              <input type="text" class="form-control" name="nombreMadre" id="nombreMadre" oninput="convertirMayusculas(); validarTexto('nombreMadre','resultado5');" maxlength=100 required pattern="^[A-Za-zñÑ ]*$">
              <span id="resultado5" class="text-danger"></span>
            </div>
          </div>
          <div class="col-md-3 ">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Estado Civil</label>
              <select class="form-select" name="estadoCivil" id="edocivil" required>
                <option selected disabled value=""></option>
                <option value="1">Soltero</option>
                <option value="2">Casado</option>
                <option value="3">Viudo</option>
                <option value="4">Divorciado</option>
                <option value="6">Unión libre</option>
                <option value="7">Separado de unión libre</option>
                <option value="8">Separado de un Matrimonio</option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Nombre conyuge</label>
              <input type="text" class="form-control" name="nombreCon" id="nombreConyuge" oninput="convertirMayusculas(); validarTexto('nombreConyuge','resultado7');" maxlength=100 required pattern="^[A-Za-zñÑ ]*$">
              <span id="resultado7" class="text-danger"></span>
            </div>
          </div>
        </div> 
        <div class="row mb-3">
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Edad</label>
              <input type="number" class="form-control" name="edad" id="edad" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="2" max="99" required>
            </div>
          </div>
        
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Nacionalidad</label>
              <select class="form-select" name="nacionalidad" id="nacionalidad" required>
                <option selected disabled value=""></option>
                <option value="1">MEXICANA POR NATALIDAD</option>
                <option value="2">EXTRANJERO NATURALIZADO</option>
                <option value="3">EXTRANJERA </option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Lugar de Nacimiento</label>
              <select class="form-select" name="lugarNa" id="luNacimiento" required>
                <option selected disabled value=""></option>
                <option value="1">AGUASCALIENTES</option>
                <option value="2">BAJA CALIFORNIA NORTE</option>
                <option value="3">BAJA CALIFORNIA SUR</option>
                <option value="4">CAMPECHE</option>
                <option value="5">COAHUILA</option>
                <option value="6">COLIMA</option>
                <option value="7">CHIAPAS</option>
                <option value="8">CHIHUAHUA</option>
                <option value="9">CIUDAD DE MÉXICO</option>
                <option value="10">DURANGO</option>
                <option value="11">GUANAJUATO</option>
                <option value="12">GUERRERO</option>
                <option value="13">HIDALGO</option>
                <option value="14">JALISCO</option>
                <option value="15">ESTADO DE MÉXICO</option>
                <option value="16">MICHOACAN</option>
                <option value="17">MORELOS</option>
                <option value="18">NAYARIT</option>
                <option value="19">NUEVO LEÓN</option>
                <option value="20">OAXACA</option>
                <option value="21">PUEBLA</option>
                <option value="22">QUERÉTARO</option>
                <option value="23">QUINTANA ROO</option>
                <option value="24">SAN LUIS POTOSI</option>
                <option value="25">SINALOA</option>
                <option value="26">SONORA</option>
                <option value="27">TABASCO</option>
                <option value="28">TAMAULIPAS</option>
                <option value="29">TLAXCALA</option>
                <option value="30">VERACRUZ</option>
                <option value="31">YUCATÁN</option>
                <option value="32">ZACATECAS</option>
                <option value="33">EXTRANJERO</option>
                <option value="34">EXTRANJERO NATURALIZADO</option>
              </select>
              </div>
          </div>
          <div class="col-md-3">
            <div>
              <label for="exampleFormControlInput1" class="form-label">Tiene alguna discapacidad</label>
              <select class="form-select" name="discapacidad" id="disca" required>
              <option selected disabled value=""></option>
                <option value="1">NINGUNA</option>
                <option value="2">SENSORIAL</option>
                <option value="3">DE LA COMUNICACIÓN</option>
                <option value="4">MOTRICES</option>
              </select>
            </div>
          </div>
          
        </div>
        
        <div class="row mb-3">
          <div class="col-md-3">
            <div>
              <label for="exampleFormControlInput1" class="form-label">Numero de empleado</label>
              <input type="number" class="form-control" name="numEmpleado" id="numEmpleado" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10">
            </div>
          </div>
          <div class="col-md-3">
            <div>
              <label for="exampleFormControlInput1" class="form-label">Numero de Control</label>
              <input type="text" class="form-control" name="numint" id="numint" oninput="convertirMayusculas(); verificarNumeroControl();" maxlength="6" pattern="^[A-Za-z0-9]{5,6}$" required>
              <span id="resultadoNumControl" class="text-danger"></span>
            </div>
          </div>
          <div class="col-md-3">
            <div>
              <label for="exampleFormControlInput1" class="form-label">Hablante de lengua nativa</label>
              <select class="form-select" name="hablanteLengua" id="lengua" required>
              <option selected disabled value=""></option>
                <option value="SI">Si</option>
                <option value="NO">No</option>
              </select>
            </div>
          </div>
        </div>

        <h2>Fotografia</h2>
        <hr>
        <div class="row mb-3">
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Cargar Fotografía</label>
              <p class="text-muted mb-0"><input type="file" accept=".jpg"onchange="validarTamañoArchivo(this)" class="input form-control-file" name="Foto" id="Foto" required></p>
              <span id="resultado11" class="text-danger"></span>
            </div>
          </div>
        </div>

        <h2>Domicilio</h2>
        <hr>
        <div class="row mb-3">
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Calle y Num</label>
              <input type="text" class="form-control" name="calle" id="calle" maxlength=100 oninput="convertirMayusculas()" required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Colonia</label>
              <input type="text" class="form-control" name="colonia" id="col" maxlength=100 oninput="convertirMayusculas()" required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Alcaldía/Municipio</label>
              <input type="text" class="form-control" name="alcal" id="alcal" maxlength=100 oninput="convertirMayusculas()" required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Estado</label>
              <select class="form-select" name="estado" id="estado" required>
                <option selected disabled value=""></option>
                <option value="AGUASCALIENTES">AGUASCALIENTES</option>
                <option value="BAJA CALIFORNIA NORTE">BAJA CALIFORNIA NORTE</option>
                <option value="BAJA CALIFORNIA SUR">BAJA CALIFORNIA SUR</option>
                <option value="CAMPECHE">CAMPECHE</option>
                <option value="COAHUILA">COAHUILA</option>
                <option value="COLIMA">COLIMA</option>
                <option value="CHIAPAS">CHIAPAS</option>
                <option value="CHIHUAHUA">CHIHUAHUA</option>
                <option value="CIUDAD DE MÉXICO">CIUDAD DE MÉXICO</option>
                <option value="DURANGO">DURANGO</option>
                <option value="GUANAJUATO">GUANAJUATO</option>
                <option value="GUERRERO">GUERRERO</option>
                <option value="HIDALGO">HIDALGO</option>
                <option value="JALISCO">JALISCO</option>
                <option value="ESTADO DE MÉXICO">ESTADO DE MÉXICO</option>
                <option value="MICHOACAN">MICHOACAN</option>
                <option value="MORELOS">MORELOS</option>
                <option value="NAYARIT">NAYARIT</option>
                <option value="NUEVO LEÓN">NUEVO LEÓN</option>
                <option value="OAXACA">OAXACA</option>
                <option value="PUEBLA">PUEBLA</option>
                <option value="QUERÉTARO">QUERÉTARO</option>
                <option value="QUINTANA ROO">QUINTANA ROO</option>
                <option value="SAN LUIS POTOSI">SAN LUIS POTOSI</option>
                <option value="SINALOA">SINALOA</option>
                <option value="SONORA">SONORA</option>
                <option value="TABASCO">TABASCO</option>
                <option value="TAMAULIPAS">TAMAULIPAS</option>
                <option value="TLAXCALA">TLAXCALA</option>
                <option value="VERACRUZ">VERACRUZ</option>
                <option value="YUCATÁN">YUCATÁN</option>
                <option value="ZACATECAS">ZACATECAS</option>
              </select>

            </div>
          </div>
        </div> 



        <h2>Contacto</h2>
        <hr>
        <div class="row mb-3">
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Telefono (EXT)</label>
              <input type="number" class="form-control" name="telOf" id="telof" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5" required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Telefono Celular</label>
              <input type="number" class="form-control" name="telCasa" id="telca" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" required>
            </div>
          </div>
        </div> 

        <h2>Datos laborales</h2>
        <hr>
        <div class="row mb-3">
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Numero de Contrato</label>
              <input type="number" class="form-control" name="numContrato"id="numCon" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="8">
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Turno</label>
              <select class="form-select" name="turno" id="turno" required>
              <option selected disabled value=""></option>
                <option value="TM">MATUTINO</option>
                <option value="TV">VESPERTINO</option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Función</label>
              <input type="text" class="form-control" name="funcion" id="fun" maxlength=20 oninput="convertirMayusculas()" required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Ubicación</label>
              <input type="text" class="form-control" name="ubicacion" id="ubicacion" maxlength=25 oninput="convertirMayusculas()" required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Adscripcion</label>
              <input type="text" class="form-control" name="ads" id="ads" maxlength=25 oninput="convertirMayusculas()" required>
            </div>
          </div>

          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Tipo</label>
                <select class="form-select" name="tipo" id="tipo" required>
                  <option selected disabled value=""></option>
                    <option value="A">PAAE</option>
                    <option value="D">DOCENTE</option>
                    <option value="T">TECNICO DOCENTE</option>
                </select>
            </div>
          </div>

          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Area de checado</label>
                <select class="form-select" name="acheca" id="acheca" required>
                  <option selected disabled value=""></option>
                    <option value="1">PREFECTURA 1</option>
                    <option value="2">PREFECTURA 2</option>
                    <option value="4">PREFECTURA 4</option>
                    <option value="5">PREFECTURA 5</option>
                    <option value="6">PREFECTURA 6</option>
                    <option value="7">PREFECTURA 7</option>
                </select>
            </div>
          </div>

          <!-- <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">ID de Funcion</label>
              <input type="text" class="form-control" name="idfun" id="idfun" maxlength=25 required>
            </div>
          </div> -->

        </div>

        <h2>Datos de Estudios</h2>
        <hr>
        <div class="row mb-3">
          <div class="col-md-3">
            <div class="mb-3">
              <label for="nivel" class="form-label">Nivel de Estudios</label>
              <select class="form-select" name="NIVEL" id="nivel" required>
                  <option selected disabled value=""></option>
                    <option value="LIC. PASANTE">LIC. PASANTE</option>
                    <option value="LIC. TITULADO">LIC. TITULADO</option>
                    <option value="MAESTRIA">MAESTRIA</option>
                    <option value="DOCTORADO">DOCTORADO</option>
                    <option value="SECUNDARIA">SECUNDARIA</option>
                    <option value="BACHILLERATO">BACHILLERATO</option>
                    <option value="ESP. O POSGRADO">ESP. O POSGRADO</option>
                    <option value="S/DOCUMENTOS">S/DOCUMENTOS</option>
                </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="otrosEstudios" class="form-label">Otros Estudios</label>
              <input type="text" class="form-control" name="OTRO_EST" id="otrosEstudios" maxlength=25 required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="numeroCedula" class="form-label">Número de Cédula</label>
              <input type="number" class="form-control" name="NUM_CEDULA" id="numeroCedula"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="8" required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="sigueEstudiando" class="form-label">¿Sigue Estudiando?</label>
              <select class="form-select" name="SIGUE_ESTUDIANDO" id="sigueEstudiando" required>
                  <option selected disabled value=""></option>
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
              </select>
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-3" id="ocultar1" style="display: none;">
            <div class="mb-3">
              <label for="queEstudia" class="form-label">¿Qué Estudia?</label>
              <input type="text" class="form-control" name="QUE_ESTUDIA" id="queEstudia" maxlength=25>
            </div>
          </div>
          <div class="col-md-3" id="ocultar2" style="display: none;">
            <div class="mb-3">
              <label for="dondeEstudia" class="form-label">¿Dónde Estudia?</label>
              <input type="text" class="form-control" name="DONDE_ESTUDIA" id="dondeEstudia" maxlength=25>
            </div>
          </div>
          <!-- <div class="col-md-3">
            <div class="mb-3">
              <label for="idHistorial" class="form-label">Id Historial</label>
              <input type="text" class="form-control" name="ID_HISTORIAL" id="idHistorial" maxlength=4 required>
            </div>
          </div> -->
          <div class="col-md-3">
            <div class="mb-3">
              <label for="titulado" class="form-label">Titulado</label>
              <select class="form-select" name="TITULADO_NOTITULADO" id="titulado" required>
                  <option selected disabled value=""></option>
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
              </select>
            </div>
          </div>
        </div>
        

        <h2>Datos adicionales</h2>
        <hr>
        <div class="row mb-3">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="exampleFormControlTextarea1" class="form-label">Observaciones</label>
              <textarea name="OBSER" class="form-control" id="exampleFormControlTextarea1" rows="3" oninput="convertirMayusculas()"></textarea>
            </div>
          </div>
          
        </div> 
          
        <div class="row mb-3">
          <div class="col-md-3 offset-md-10 justify-content-end">
            <button id="mostrarBoton" type="submit" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#confirmModal">Dar de Alta</button>
          </div>
        </div>
      </form>
    </div>
  
    

    <div id="formulario-opcion2" style="display: none;">
    <form  action="insertar_plaza.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
      <h3>Datos de la  plaza</h3>
      <HR>
      <div class="row mb-3">
        <div class="col-md-3">
          <div class="mb-3">
            <label for="NE" class="form-label" >Numero de Control</label>
            <input type="TEXT" class="form-control" name="NE" id="NE" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" required>
          </div>
        </div> 
        <div class="col-md-3">
          <div class="mb-3">
            <label for="CURPP" class="form-label">CURP</label>
            <input type="text" class="form-control" name="CURPP" id="CURPP" maxlength=18 oninput="convertirMayusculas(); verificarCurp1();" required pattern="^[A-Z]{4}\d{6}[HM][A-Z]{5}[A-Z0-9]{2}$" readonly>
            <span id="resultado1" class="text-danger"></span>
          </div>
        </div>
        <div class="col-md-3">
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label" >Clave de plaza</label>
            <input type="text" class="form-control" name="CLAV" id="CLAV" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); updateClavePresupuestal();" maxlength="30" required>
          </div>
        </div>
            <div class="col-md-3">
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">NP</label>
                <input type="text" class="form-control" name="NP" id="NP" required oninput="updateClavePresupuestal()">
              </div>
            </div>
          </div>


        <div class="row mb-3">
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Clave Presupuestal</label>
              <input type="text" class="form-control" name="CLAVE" id="CLAVE" readonly required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Movimiento</label>
              <input type="text" class="form-control" name="MOV" id="MOV" maxlength=30 required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label" >Fecha de inicio</label>
              <input type="date" class="form-control" name="FIN" id="FIN" required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label" >Fecha de termino</label>
              <input type="date" class="form-control" name="FTE" id="FTE" required>
            </div>
          </div>
        </div> 

        <div class="row mb-3">
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Fecha de activacion</label>
              <input type="date" class="form-control" name="FAC" id="FAC">
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Plaza historica</label>
              <input type="text" class="form-control" name="HIS" id="HIS" maxlength=30 oninput="convertirMayusculas()">
            </div>
          </div>
          <div class="col-md-3">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label" >Tipo de plaza</label>
              <select class="form-select" name="TP" id="TP" required>
                  <option selected disabled value=""></option>
                    <option value="A">ADMINISTRATIVO</option>
                    <option value="D">DOCENTE</option>
                    <option value="T">DOCENTE TÉCNICO</option>
              </select>
            </div>
          </div>
        </div> 
        <h3>FUP</h3>
        <HR>

        <label for="pdfDocumento">Subir PDF:</label>
        <input type="file" id="FUP" name="FUP" accept=".pdf" required>
        <HR>
        <div class="row mb-3">
          <div class="col-md-3 offset-md-10 justify-content-end">
            <button id="mostrarBoton" type="submit" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#confirmModal">Dar de Alta</button>
          </div>
        </div>
        
    </form>
    </div>
  </div>

  <script>
    function updateClavePresupuestal() {
      var clavePlaza = document.getElementById("CLAV").value;
      var np = document.getElementById("NP").value;
      var clavePresupuestal = '0.0/' + clavePlaza + '/' + np;
      document.getElementById("CLAVE").value = clavePresupuestal;
    }
  </script>

  <script>
        $(document).ready(function(){
            $("#NE").on("input", function(){
                var np = $(this).val().trim();

                if(np.length >= 3){
                    // Realizar la petición AJAX
                    $.ajax({
                        type: "POST",
                        url: "buscar_curp.php", // Ruta a tu script PHP que realizará la búsqueda en la base de datos
                        data: { NE: np },
                        success: function(response){
                            // Actualizar el campo CURP con la respuesta del servidor
                            $("#CURPP").val(response);
                        }
                    });
                }
            });
        });
    </script>


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
    document.getElementById("sigueEstudiando").addEventListener("change", function() {
      var elementOculto1 = document.getElementById("ocultar1");
      var elementOculto2 = document.getElementById("ocultar2");
      
      if(this.value === 'SI' ) {
        elementOculto1.style.display = "initial";
        elementOculto2.style.display = "initial";
      } else {
        elementOculto1.style.display = "none";
        elementOculto2.style.display = "none";
      }
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


</div>

<?php
     }else{include('login_fail.php');}
    ?>

<?php include_once './partials/footer_ipn.php'; ?>

</body>
</html>

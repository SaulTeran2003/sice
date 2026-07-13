<?php
require_once __DIR__ . '/utils/functions.php';
protect_route();
$logout = true;
require_once './conexion.php';
$connection = Conectarse();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SICAH | Menu Principal</title>
  <link rel="icon" href="img/logoSICAH.ico" type="image/x-icon">
  <link href="./css/bootstrap.min.css" rel="stylesheet" />
  <link href="./css/styles.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"
          defer></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://twemoji.maxcdn.com/v/latest/twemoji.min.js" crossorigin="anonymous"></script>
  <script defer src="./js/name whats.js"></script>
</head>
<body>

  <?php include_once './partials/header_ipn.php'; ?>
  <?php include_once './partials/header.php'; ?>

  <?php
  $tipo_usuario = '';
  $_SESSION['user']['TIPO_USUARIO'];
  $tipo_usuario = $_SESSION['user']['TIPO_USUARIO'];
  ;
  if (!empty($tipo_usuario)) {
    ?>
    <div id="loading-overlay" style="display: none;">
      <h5>Enviando mensajes por favor espere.</h5>
      <div id="loading-spinner"></div>
    </div>
    <div class="card-body sombra" id="plantillas" style="padding: 2em;">
      <h3 style="margin=auto;">Enviar mensaje de WhatsApp</h3>

      <!-- Formulario para enviar opciones y mensaje -->
      <form action="http://10.7.31.202:3000/sendMessage" method="POST" autocomplete="off">
        <div>
        <strong>Mensajes Masivos: </strong> <br>
          <label for="TecnicoDocente">Profesor Técnico</label>
          <input type="checkbox" id="TecnicoDocente" name="opciones[]" value="T"><br>

          <label for="Docente">Profesor</label>
          <input type="checkbox" id="Docente" name="opciones[]" value="D"><br>

          <label for="Administativo">PAAES</label>
          <input type="checkbox" id="Administrativo" name="opciones[]" value="A"><br>

          <label for="mostrarNombre"><strong>Mensaje Personal: </strong></label><br>

          <label id="nombreLabel" for="name" >Nombre:</label>
          <div id="input-container">
            <input type="text" 
            id='name'
            name="name[]" 
            list="name-list" 
            class="name-input"
            title="Ingrese un formato válido" 
            placeholder="Introduce el Nombre"
            autocomplete="off" 
            class='form-control'
            />
            <datalist id="name-list"></datalist><br>
          </div>
          <button type="button" onclick="duplicateInput()">+</button>
          <br>
        </div>

        <div>
          <label for="text">Mensaje:</label>
          <textarea type="text" id="text" class="form-control" style="height: 100px;" name="text" required></textarea><br>
          <div id="menuEmojis"></div>
          <!-- Botón para enviar el mensaje -->
          <button type="submit" name="enviar" class="btn btn-primary w-100">Enviar mensaje</button></br> <br>
          <button class='btn btn-secondary' type='button' onclick='cancelarEliminacion()'>Regresar</button>
        </div>
      </form>
    </div>

    <script>
let index = 0; // Variable global para mantener un índice único

function duplicateInput() {
  var container = document.getElementById('input-container');
  var index = container.children.length; // Obtener el número actual de inputs

  // Limitar la cantidad de inputs clonados a 10
  // if (index >= 30) {
  //   alert('Solo se pueden enviar 10 mensjaes simultaneos');
  //   return;
  // }

  // Crear un nuevo input y datalist
  var clonedInput = document.createElement('input');
  clonedInput.type = 'text';
  clonedInput.classList.add('name-input'); // Agregar la misma clase
  clonedInput.name = 'name[' + index + ']'; // Asignar un nombre único
  clonedInput.id = 'name-input-' + index; // Asignar un ID único al input
  clonedInput.placeholder = 'Introduce el Nombre';
  clonedInput.autocomplete = 'off';

  // Crear un nuevo datalist
  var clonedDatalist = document.createElement('datalist');
  clonedDatalist.id = 'name-list-' + index; // Asignar un ID único al datalist

  // Asociar el evento keyup para el nuevo input clonado
  clonedInput.addEventListener("keyup", function() {
    updateDatalist(clonedInput, clonedDatalist)();
  });

  // Agregar el datalist al input clonado
  clonedInput.setAttribute('list', clonedDatalist.id);

  // Agregar un botón para eliminar el input clonado
  var deleteButton = document.createElement('button');
  deleteButton.textContent = 'Eliminar';
  deleteButton.addEventListener('click', function() {
    container.removeChild(clonedInput);
    container.removeChild(clonedDatalist);
    container.removeChild(deleteButton);
  });

  // Agregar los nuevos elementos al contenedor
  container.appendChild(clonedInput);
  container.appendChild(clonedDatalist);
  container.appendChild(deleteButton);
}




function updateDatalist($inputName, $datalistName) {
  return async function () {
    let values = [];

    // Eliminar el contenido actual del datalist
    $datalistName.innerHTML = "";

    if ($inputName.value.length >= 4) {
      values = (await callApi("nombre", $inputName.value)) ?? [];

      values.forEach((value) => {
        $datalistName.insertAdjacentHTML(
          "beforeend",
          `<option value="${value.NOMBRE}">`
        );
      });
    }
  };
}

</script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
    var form = document.querySelector('form');
    twemoji.parse(document.body);

    form.addEventListener('submit', function (event) {
      event.preventDefault(); // Evitar que el formulario se envíe automáticamente

      // Mostrar pantalla de carga
      document.getElementById('loading-overlay').style.display = 'flex';

      

      // Tu lógica de validación existente
      var nameInputs = document.getElementsByClassName('name-input');
      var nameValues = Array.from(nameInputs).map(input => input.value.trim());
      var nameList = document.getElementById('name-list');
    // Verificar que todos los inputs tengan datos de datalist
      var allNamesValid = nameValues.every(function(nameValue, index) {
      var datalistId = 'name-list-' + index;
      var datalist = document.getElementById(datalistId);

      // Verificar si el valor ingresado está en la lista de opciones del datalist asociado
      return nameValue !== '' && isOptionInDatalist(nameValue, datalist);
    });

    // if (!allNamesValid) {
    //   alert('Nombres no reconocidos; ingresa nombres de las listas.');
    //   return;
    // }  
      // Verificar si el campo de nombre está vacío y si ninguna opción de opciones[] está seleccionada
      var opcionesInputs = document.querySelectorAll('input[name="opciones[]"]:checked');
      if (nameValues === '' && opcionesInputs.length === 0) {
        alert('Por favor, ingresa un nombre o selecciona al menos una opción.');
        return;
      }


      // Recopilar datos del formulario
      var formData = {
        name:  nameValues,
        opciones: Array.from(opcionesInputs).map(input => input.value),
        text: document.getElementById('text').value,
        // Otros datos que desees incluir...
      };
      console.log(formData);
      // Realizar la solicitud al servidor
      fetch('http://10.7.31.202:3000/sendMessage', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
      })
        .then(response => {
          if (!response.ok) {
            throw new Error('Error en la solicitud.');
          }
          return response.json();
        })
        .then(data => {
          if (data.status === 'enviando') {
            // Puedes mostrar un mensaje o realizar alguna acción específica mientras se están enviando los mensajes
            console.log('Enviando mensajes...');
          } else if (data.status === 'enviados') {
            // Muestra el mensaje de éxito al usuario usando alert o alguna otra forma
            alert(data.message);
            window.location.reload();
          } else {
            // Muestra un mensaje de error al usuario
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          // Muestra el mensaje de error al usuario usando alert
          alert('Error interno del servidor');
        })
        .finally(() => {
          // Ocultar pantalla de carga después de que la solicitud se complete
          document.getElementById('loading-overlay').style.display = 'none';
        });
    });

    function isOptionInDatalist(value, datalist) {
      var options = datalist ? Array.from(datalist.options).map(option => option.value) : [];
      return options.includes(value);
    }
  });
</script>

<script>
  function cancelarEliminacion() {
      // Utilizar JavaScript para retroceder en la historia del navegador
      window.history.back();
  }
</script>    
  <?php
} else {
  include('login_fail.php');
}
?>

<?php include_once './partials/footer_ipn.php'; ?>

</body>
</html>

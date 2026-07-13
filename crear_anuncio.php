<?php
  require_once __DIR__ . '/utils/functions.php';
  protect_route();
  $logout = true;
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous" defer></script>
</head>
<body>

  <?php include_once './partials/header_ipn.php'; ?>
<?php include_once './partials/header.php'; ?>

<?php
  $tipo_usuario='';
  $_SESSION['user']['TIPO_USUARIO'];
  $tipo_usuario=$_SESSION['user']['TIPO_USUARIO'];
  if(!empty($tipo_usuario)){

    require_once 'conexion.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $anuncio = $_POST['text'];
      $connection = Conectarse();

      if($_FILES["Foto"]["error"]==0){
        $permitidos=array("image/jpg");
        $file=$_FILES["Foto"]["name"];
        $file_type=strtolower(pathinfo($file,PATHINFO_EXTENSION));
        $size_image=204800;
        if($file_type === "jpg"){
            if($_FILES["Foto"]["size"]<$size_image){
            $nombre_unico = 'anuncio_' . uniqid() . '.jpg'; 
            $ruta='./imgadd/';
            $imgadd=$ruta.$nombre_unico;
            $resultado=@move_uploaded_file($_FILES["Foto"]["tmp_name"],$imgadd);
            if($resultado){
                ?>
                <script>window.alert('Imagen Cargada con éxito')</script>
                <?php
                  $query = "INSERT INTO Anuncios (anuncio, img_name) VALUES (:anuncio, :img_name)";
                  $statement = $connection->prepare($query);
                  $statement->bindParam(':anuncio', $anuncio, PDO::PARAM_STR);
                  $statement->bindParam(':img_name', $nombre_unico, PDO::PARAM_STR);
              
                    if ($statement->execute()) {
                      echo "
                        <script>
                          alert('Anuncio subido con éxito.');
                          window.location.href = 'anuncios.php';
                        </script>";
                    } else {
                      echo "<script>alert('Error al subir el anuncio.');</script>";
                    }
            }else{
                ?>
                <script>window.alert('No se pudo cargar la imagen')</script>
                <?php
            }
        }else{
            ?>
            <script>window.alert('Archivo Excede el limite de tamaño')</script>
            <?php 
        }}else{
            ?>
            <script>window.alert('Archivo NO permitido')</script>
            <?php
        }
    }else{
      $query = "INSERT INTO Anuncios (anuncio) VALUES (:anuncio)";
      $statement = $connection->prepare($query);
      $statement->bindParam(':anuncio', $anuncio, PDO::PARAM_STR);
      if ($statement->execute()) {
        echo "
          <script>
            alert('Anuncio subido con éxito.');
            window.location.href = 'anuncios.php';
          </script>";
      } else {
        echo "<script>alert('Error al subir el anuncio.');</script>";
      }
    }
  }
?>

  <div class="card-body sombra" id="plantillas">
    <h3>Crear Anuncio</h3><br>
    <form action="crear_anuncio.php" method="POST" autocomplete="off" enctype="multipart/form-data">
      <label for="text">Anuncio (máximo 255 caracteres):</label>
      <textarea id="text" class="form-control" style="height: 100px;" name="text" required maxlength="255"></textarea><br>
      <p>Caracteres restantes: <span id="caracteres_restantes">255</span></p>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Cargar Imagen</label>
        <p class="text-muted mb-0"><input type="file" accept=".jpg"onchange="validarTamañoArchivo(this)" class="input form-control-file" name="Foto" id="Foto"></p>
        <span id="resultado11" class="text-danger"></span>
      </div>
      <button type="submit" class="btn btn-primary w-100">Subir Anuncio</button></br>
      <button class='btn btn-secondary' type='button' onclick='cancelarEliminacion()'>Cancelar</button>
    </form>
  </div>

  <script>
    document.getElementById("text").addEventListener("input", function() {
    var maxCaracteres = 255;
    var caracteresUtilizados = this.value.length;
    var caracteresRestantes = maxCaracteres - caracteresUtilizados;
    document.getElementById("caracteres_restantes").textContent = caracteresRestantes;
    });

    function validarTamañoArchivo(input) {
          const maxFileSize = 5000 * 1024; // 200 KB en bytes
          const file = input.files[0];
          const flag =true;

          if (file && file.size > maxFileSize) {
            alert("El archivo es demasiado grande. El tamaño máximo permitido es 200KB, Porfavor seleccione otra fotografia");
            input.value = ""; //limpia la carga
          }
        }
  </script>
    <script>
  function cancelarEliminacion() {
      // Utilizar JavaScript para retroceder en la historia del navegador
      window.history.back();
  }
</script>
<?php
     }else{include('login_fail.php');}
?>

<?php include_once './partials/footer_ipn.php'; ?>

</body>
</html>
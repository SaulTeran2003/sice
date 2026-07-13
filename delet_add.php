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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
        crossorigin="anonymous" defer></script>
</head>
<body>

  <?php include_once './partials/header_ipn.php'; ?>
<?php include_once './partials/header.php'; ?>

<?php
  $tipo_usuario='';
  $_SESSION['user']['TIPO_USUARIO'];
  $tipo_usuario=$_SESSION['user']['TIPO_USUARIO'];;
  if(!empty($tipo_usuario)){

    if (isset($_GET['anuncio'])) {
      $anuncio = urldecode($_GET['anuncio']);
      if (isset($_POST['eliminar_anuncio'])) {
          require_once 'conexion.php';
          $connection = Conectarse();
          $query_img = "SELECT img_name FROM anuncios WHERE anuncio = ?";
          $statement_img = $connection->prepare($query_img);
          $statement_img->bindParam(1, $anuncio, PDO::PARAM_STR);
          $statement_img->execute();
          $img_result = $statement_img->fetch(PDO::FETCH_ASSOC);

          $query = "DELETE FROM anuncios WHERE anuncio = ?";
          $statement = $connection->prepare($query);
          $statement->bindParam(1, $anuncio, PDO::PARAM_STR);

          if ($statement->execute()) {
            $img_path = './imgadd/' . $img_result['img_name'];
            if (file_exists($img_path)) {
                unlink($img_path); // Borrar el archivo
            }
              echo "<script>alert('Anuncio eliminado con éxito.'); window.location.href = 'anuncios.php';</script>";
              exit;
          } else {
              echo "<script>alert('Error al eliminar el anuncio.');</script>";
          }
      } else {
          require_once 'conexion.php';
          $connection = Conectarse();
          $query = "SELECT anuncio, img_name FROM anuncios WHERE anuncio = ?";
          $statement = $connection->prepare($query);
          $statement->bindParam(1, $anuncio, PDO::PARAM_STR);
          $statement->execute();
          $result = $statement->fetch(PDO::FETCH_ASSOC);

          if ($result) {
              echo "<div class='card-body sombra' id='plantillas'>";
              echo "<h3>Anuncio a eliminar:</h3><br>";
              echo "<p>{$result['anuncio']}</p>";
              if (!empty($result['img_name'])) {
                echo "<img src='./imgadd/{$result['img_name']}' style='width: 320px; height: 220px;' /></br></br>";
              }else{
                echo "Sin Imagen <br/><br/>";
              }
                echo "<form method='POST'>";
              echo "<button class='btn btn-primary' type='submit' name='eliminar_anuncio'>Eliminar Anuncio</button>";
              echo "<button class='btn btn-secondary' type='button' onclick='cancelarEliminacion()'>Cancelar</button>";
              echo "</form>";
              echo "</div>";
          } else {
              echo "<div class='card-body sombra' id='plantillas'>";
              echo "<p>No se encontró información para el anuncio proporcionado.</p>";
              echo "</div>";
          }
      }
  } else {
      echo "<div class='card-body sombra' id='plantillas'>";
      echo "<p>Contenido del anuncio no proporcionado.</p>";
      echo "</div>";
      exit;
  }



     }else{include('login_fail.php');}
?>
  <script>
  function cancelarEliminacion() {
      // Utilizar JavaScript para retroceder en la historia del navegador
      window.history.back();
  }
</script>
<?php include_once './partials/footer_ipn.php'; ?>

</body>
</html>
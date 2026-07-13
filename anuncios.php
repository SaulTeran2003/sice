<?php
  require_once __DIR__ . '/utils/functions.php';
  protect_route();
  $logout = true;
?>

<!DOCTYPE html>
<html lang="en">

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
  $tipo_usuario=$_SESSION['user']['TIPO_USUARIO'];;
  if(!empty($tipo_usuario)){

    require_once 'conexion.php';
    $connection = Conectarse();
    $query = "SELECT * FROM anuncios";
    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "<div class='row justify-content-around align-items-start' style='height: 555px;'>";

    if (count($result) > 0) {
            echo "
                </br></br></br>
                <table border='1' style='padding: 20px;' id='anuncios'>";
            echo "<tr><th>Anuncio</th><th>Imagen</th><th>Eliminar</th></tr>";

            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . $row["anuncio"] . "</td>";
                if (!empty($row["img_name"])) {
                  echo "<td> <img src='./imgadd/" . $row["img_name"] . "' style='width: 100px; height: 70px;'/> </td>";
              } else {
                  echo "<td>Sin Imagen</td>";
              }
                echo "<td><a href='delet_add.php?anuncio=" . urlencode($row["anuncio"]) . "'>Eliminar</a></td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo " </br></br>
                    <h2 class='alert'>No hay anuncios creados.</h2>";
        }
    
    echo "
         </div>
         <div class='row justify-content-around align-items-start'>
          <a class='boton' style='text-align: center;' href='crear_anuncio.php'>Crear Anuncio</a><br/> <br/>
        </div>";


}else{include('login_fail.php');}
?>

<?php include_once './partials/footer_ipn.php'; ?>
</body>

</html>
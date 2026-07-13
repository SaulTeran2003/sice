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
//     echo '<table border="0" width="100%">';
// echo'</br>';
// echo'</br>';
// echo '<td align="center" colspan="4">';
//     echo'<strong><h2>Seleccione una opción</h2></strong> ';
// 	echo'</td>';
//     echo'</table>';
// echo'</br>';
// echo'</br>';
?>

<div class="col-md-auto text-center m-4">
  <h1>Comunicaciones</h1>
</div>
<div class="row justify-content-around align-items-start vh-60">
  <div class="card" style="width: 18rem; height: 410px" align="center">
    <img src="img/whatsapp.png" class="card-img-top" style="width: 400; height: 100;"/>
    <div class="card-body">
      <h5 class="card-title"></h5><br>
      <p class="card-text">Envia mensajes de WhatsApp a través de la interfaz.</p><br><br>
      <a href="wapp.php" class="btn btn-primary">Acceder</a>
    </div>
  </div>
  <div class="card" style="width: 18rem; height: 410px" align="center">
    <img src="img/anuncios.png" class="card-img-top" style="width: 400; height: 100;"/>
      <div class="card-body">
        <h5 class="card-title">Anuncios</h5>
        <p class="card-text">Gestion de Avisos para la seccion de Anuncios en WhatsApp.</p><br>
        <a href="anuncios.php" class="btn btn-primary">Acceder</a>
      </div>
  </div>
</div>
<br><br>
<?php
     }else{include('login_fail.php');}
?>

<?php include_once './partials/footer_ipn.php'; ?>
</body>

</html>
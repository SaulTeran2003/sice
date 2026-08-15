<?php
session_start();
$alert = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once 'conexion.php';
  $connection = Conectarse();

  $email = $_POST['email'];
  $pass = $_POST['password'];

  $getEmployeeQuery = "SELECT * FROM UsuariosSicah WHERE CORREO='$email';";
  $statement = $connection->prepare($getEmployeeQuery);
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);

  if (empty($result)) {
    $alert = "No existe el usuario con el correo $email";
    $email = '';
  } else {
    $is_auth = password_verify($pass, $result[0]['CONTRASENA']);
    if ($is_auth && $result[0]['ESTATUS'] === '1') {
      $_SESSION['user'] = $result[0];
      if ($result[0]['RESET'] === '0') {
        header('Location: /sicah-web/index.php');
      } else {
        header('Location: /sicah-web/recuperar_contrasena.php');
      }
    } else {
      $alert = "Contraseña incorrecta o usuario inactivo";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SICE | </title>
  <link rel="icon" href="img/logoSICAH.ico" type="image/x-icon">
  <link href="./css/bootstrap.min.css" rel="stylesheet" />
  <link href="./css/styles.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"
          defer></script>
</head>

<body class="my-login-page bg-primary">
<?php include_once './partials/header_ipn.php'; ?>

<section class="mt-5 mb-5">
  <div class="container h-100">
    <div class="row justify-content-md-center h-100">
      <div class="card-wrapper">
        <div class="card fat">
          <div class="card-body">
            <h4 class="card-title text-center"></h4>
            <form method="POST" class="my-login-validation">
              <div class="form-group my-3">
                <label for="email">Correo Electrónico</label>
                <input id="email" type="email" class="form-control" name="email" value="<?php echo $email ?? ''; ?>"
                       required autofocus>
              </div>

              <div class="form-group">
                <label for="password">Contraseña</label>
                <input id="password" type="password" class="form-control" name="password" required data-eye>
              </div>

              <div class="form-group mt-4 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary w-100">
                  Siguiente
                </button>
              </div>
              <div class="mt-4 text-end f-12">
                <a href="./recuperar_contrasena.php">Olvidé mi contraseña</a>
              </div>
            </form>
          </div>
        </div>

        <?php if (isset($alert)) : ?>
          <p class="text-center mt-5 alert alert-danger col-12 mx-auto">
            <?php echo $alert; ?>
          </p>
        <?php endif; ?>

        <div class="footer">
          Copyright &copy; <?php echo date("Y"); ?> &mdash; SICAH
        </div>
      </div>
    </div>
  </div>
</section>

<?php include_once './partials/footer_ipn.php'; ?>
</body>

</html>

/////////////////////////////////////////////////////
HEADEER_IPN.PHP 
<?php $path = isset($volver) ? '../' : ''; ?>

<div>
  <nav class="navbar m-0" role="navigation" id="barraGobmx2">
    <div class="container align-content-center">
      <a class="navbar-brand" style="padding-left: 8px;" href="https://www.gob.mx/">
        <img src="<?php echo $path; ?>img/logob.svg" height="29" alt="Página de inicio, Gobierno de México">
      </a>
      <div class="text-rigth barraGobmx-enlaces2 d-flex justify-content-between gap-3">
        <a href="https://www.gob.mx/curp/" title="CURP" class="nav-link">
          Consulta tu CURP
        </a>
        <a href="https://www.gob.mx/tramites" title="Trámites" class="nav-link">
          Trámites
        </a>
        <a href="https://www.gob.mx/gobierno" title="Gobierno" class="nav-link">
          Gobierno
        <a href="https://www.gob.mx/busqueda">
          <span class="sr-only nav-link">Búsqueda</span>
          <svg class="svg-inline--fa fa-search fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="search"
               role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
            <path fill="currentColor"
                  d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
          </svg><!-- <i class="fas fa-search"></i> -->
        </a>
      </div>
    </div>
  </nav>
</div>
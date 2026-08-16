<?php
session_start();
$alert = null;
$step = 1; // Paso 1 por defecto (pedir correo)
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once 'conexion.php';
  $connection = Conectarse();

  // Si viene del paso 1 (verificar correo)
  if (isset($_POST['action']) && $_POST['action'] === 'check_email') {
    $email = $_POST['email'];

    $getEmployeeQuery = "SELECT * FROM UsuariosSicah WHERE CORREO='$email';";
    $statement = $connection->prepare($getEmployeeQuery);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (empty($result)) {
      $alert = "No existe el usuario con el correo $email";
      $email = '';
      $step = 1;
    } else {
      if ($result[0]['ESTATUS'] === '1') {
        // El correo existe y está activo, pasamos al paso 2 (contraseña)
        $step = 2;
      } else {
        $alert = "El usuario se encuentra inactivo";
        $step = 1;
      }
    }
  }

  // Si viene del paso 2 (verificar contraseña e iniciar sesión)
  if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $step = 2; // Mantenemos el paso 2 si hay error

    $getEmployeeQuery = "SELECT * FROM UsuariosSicah WHERE CORREO='$email';";
    $statement = $connection->prepare($getEmployeeQuery);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
      $is_auth = password_verify($pass, $result[0]['CONTRASENA']);
      if ($is_auth) {
        $_SESSION['user'] = $result[0];
        if ($result[0]['RESET'] === '0') {
          header('Location: /sicah-web/index.php');
          exit;
        } else {
          header('Location: /sicah-web/recuperar_contrasena.php');
          exit;
        }
      } else {
        $alert = "Contraseña incorrecta";
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SICE | </title>
  <link rel="icon" href="img/ICO.ico" type="image/x-icon">
  <link href="./css/bootstrap.min.css" rel="stylesheet" />
  <link href="./css/styles.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"
          defer></script>
</head>

<body class="bg-primary">
<?php include_once './partials/header_ipn.php'; ?>

<section class="container d-flex justify-content-center align-items-center min-vh-100 my-5">
  <div class="login-wrapper">
    
    <!-- Tarjeta de Inicio de Sesión -->
    <div class="card border-0 shadow-lg login-card">
      <div class="card-body p-5 bg-white">
        
        <!-- Logotipo SICE -->
        <div class="mb-4">
          <img src="img/CARD.jpeg" alt="Logo SICE" class="login-logo">
        </div>

        <!-- Título -->
        <h2 class="fw-normal mb-4 login-title">Iniciar sesión</h2>

        <?php if ($step === 1) : ?>
          <!-- PASO 1: Ingresar Correo -->
          <form method="POST" class="my-login-validation">
            <input type="hidden" name="action" value="check_email">
            
            <div class="mb-3">
              <input id="email" type="email" class="form-control border-top-0 border-start-0 border-end-0 rounded-0 px-0 shadow-none login-input" 
                     name="email" value="<?php echo htmlspecialchars($email); ?>" 
                     placeholder="Correo electrónico, teléfono o Skype" 
                     required autofocus>
            </div>

            <div class="mb-4">
              <a href="./recuperar_contrasena.php" class="text-decoration-none login-link">¿No puede acceder a su cuenta?</a>
            </div>

            <div class="d-flex justify-content-end mt-5">
              <button type="submit" class="btn text-white px-4 py-2 rounded-0 login-btn">
                Siguiente
              </button>
            </div>
          </form>

        <?php else : ?>
          <!-- PASO 2: Ingresar Contraseña -->
          <form method="POST" class="my-login-validation">
            <input type="hidden" name="action" value="login">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
            
            <!-- Correo del usuario seleccionado -->
            <div class="mb-3 text-muted fw-semibold login-email-display">
              <i class="fa fa-arrow-left me-2 login-back-icon" onclick="window.location.href=window.location.pathname;"></i>
              <?php echo htmlspecialchars($email); ?>
            </div>

            <div class="mb-3">
              <input id="password" type="password" class="form-control border-top-0 border-start-0 border-end-0 rounded-0 px-0 shadow-none login-input" 
                     name="password" placeholder="Contraseña" 
                     required autofocus>
            </div>

            <div class="mb-4">
              <a href="./recuperar_contrasena.php" class="text-decoration-none login-link">¿Olvidó su contraseña?</a>
            </div>

            <div class="d-flex justify-content-end mt-5">
              <button type="submit" class="btn text-white px-4 py-2 rounded-0 login-btn">
                Iniciar sesión
              </button>
            </div>
          </form>
        <?php endif; ?>

      </div>

      <!-- Pie de tarjeta institucional -->
      <div class="card-footer border-0 py-3 px-5 text-muted login-card-footer">
        Sistema Integral de Comunicaciones y Electrónica
      </div>
    </div>

    <!-- Alerta de Error -->
    <?php if (isset($alert)) : ?>
      <div class="alert alert-danger text-center mt-3 rounded-0 shadow-sm login-alert" role="alert">
        <?php echo $alert; ?>
      </div>
    <?php endif; ?>

    <!-- Footer general -->
    <div class="text-center text-white mt-3 login-general-footer">
      Copyright &copy; <?php echo date("Y"); ?> &mdash; SICE
    </div>

  </div>
</section>

<?php include_once './partials/footer_ipn.php'; ?>
</body>

</html>
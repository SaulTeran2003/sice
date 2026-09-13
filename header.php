<header class="p-3 bg-primary text-white">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center">
      <a href="/sicexd/home.php" class="mb-2 mb-lg-0 text-white text-decoration-none" title="Sistema Integral de Comunicaciones y Electrónica">
        SICE
      </a>

      <a href="/sicexd/comunicaciones.php" class="mb-2 mb-lg-0 text-white text-decoration-none">
        Comunicaciones
      </a>

      <a href="/sicexd/altas_bajas.php" class="mb-2 mb-lg-0 text-white text-decoration-none">
        Altas y Bajas
      </a>

      <p class="m-0">
        Bienvenido <span class="text-uppercase"><?php echo $_SESSION['user']['NOMBRE']; ?></span>
        <?php if (!empty($_SESSION['user']['SICE_PREVIEW'])): ?>
          <span class="badge bg-warning text-dark ms-2">Vista previa</span>
        <?php endif; ?>
      </p>

      <div class="d-flex align-items-center">
        <?php if (isset($volver)): ?>
          <a href='/sicexd/consulta_personal.php' class='btn btn-outline-light me-2'>Volver</a>
         
        <?php endif; ?>

        <?php if (isset($logout)): ?>
          <a href="/sicexd/logout.php" class="btn btn-outline-light me-2">Cerrar sesión</a>
        <?php endif; ?>

        <?php if (!isset($logout)): ?>
          <a href='/sicexd/home.php' class='btn btn-outline-light me-2'>Menú Principal</a>
        <?php endif; ?>
      </div>
    </div>
</header>

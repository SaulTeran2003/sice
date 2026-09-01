<!-- Aquí se encuentra toda la informacion del header que es la parte de la barra de gobierno
guinda donde se encontrara tramites gobierno que nos mandara a su respecticva pagina.
 También se encontrara la informacion de la barra de gobierno donde estara calendario, tranparencia, 
 directorio, correo, etc.
 ENcontraran tambien para cambier el tamaño de las letras, y simbolos.
 Estara el apartado del menu gris para que se pueda abrir los respectivos usuarios de la pagina.-->

 <?php $path = isset($volver) ? '../' : ''; ?>

<!--///////////////////////////////////Barra guinda gobierno/////////////////////////// -->
<div>
  <nav class="navbar m-0" role="navigation" id="barraGobmx2">
    <div class="container align-content-center">
      <a class="navbar-brand" style="padding-left: 8px;" href="https://www.gob.mx/">
        <img src="<?php echo $path; ?>img/logob.svg" height="29" alt="Página de inicio, Gobierno de México">
      </a>
      <div class="text-rigth barraGobmx-enlaces2 d-flex justify-content-between gap-3">
        
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
 <!-- /////////////////////////////Barra blanca info politecnico ////////////////////////// -->
<div class="menu-superior  py-2">
  <div class="container">
    <nav class="nav justify-content-end gap-3 text-uppercase" style="font-size: 13px;">
      <a href="https://www.ipn.mx/directorio-telefonico.html" class="text-dark text-decoration-none">Directorio</a>
      <span>|</span>
      <a href="https://www.ipn.mx/correo-electronico.html" class="text-dark text-decoration-none">Correo</a>
      <span>|</span>
      <a href="https://www.ipn.mx/calendario-academico.html" class="text-dark text-decoration-none">Calendario</a>
      <span>|</span>
      <a href="https://www.ipn.mx/transparencia/" class="text-dark text-decoration-none">Transparencia</a>
      <span>|</span>
      <a href="https://www.ipn.mx/proteccion-datos-personales/" class="text-dark text-decoration-none">Protección de Datos</a>
    </nav>
  </div>
</div>
<!-- ////////////////Barra gris para el munu para abrir usuario correspondiente /////////////////////-->

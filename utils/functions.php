<?php

 

  function s($html): string
  {
    return htmlspecialchars($html, ENT_QUOTES, 'UTF-8');
  }

  function getAddress(array $result): string
  {
    return $result['DOMICILIO'] . ', ' . $result['COLONIA'] . ', ' . $result['DELEG'] . ', ' . $result['ENTIDAD'] . '.';
  }
  function getAddress1PDF(array $result): string
  {
    return $result['DOMICILIO'] . ', ' . $result['COLONIA'] . ', ' ;
  }
  function getAddress2PDF(array $result): string
  {
   return $result['DELEG'] . ', ' . $result['ENTIDAD'] . '.';
  }

  function displayNationality($nationality): string
  {
    if ($nationality === '01') return 'MEXICANA';
    if ($nationality === '02') return 'EXTRANJERA';
    if ($nationality === '03') return 'MEXICANA POR NATALIDAD';
    return 'MEXICANA POR NATALIDAD';
  }

  function displayGender($gender): string
  {
    if ($gender === '1') return 'MASCULINO';
    if ($gender === '2') return 'FEMENINO';
    return 'No Especificado';
  }

  function get_image_dir(string $image_name): string
  {
    $image_name = explode('.', $image_name)[0];
    $image_dir = '../fotosdb/' . $image_name . '.jpg';
    return check_if_image_exists($image_dir);
  }

  function check_if_image_exists(string $image_dir): string
  {
    if (file_exists($image_dir)) return $image_dir;
    return '../fotosdb/no-profile.webp';
  }

  function protect_route(): void
  {
    session_start();

    if (empty($_SESSION['user'])) {
      header('Location: /sicexd/');
      exit();
    }
  }

  function preview_mode_enabled(): bool
  {
    static $enabled = null;

    if ($enabled !== null) return $enabled;

    $remoteAddress = $_SERVER['REMOTE_ADDR'] ?? '';
    $isLocalRequest = in_array($remoteAddress, ['127.0.0.1', '::1', '::ffff:127.0.0.1'], true);
    $previewConfig = __DIR__ . '/../preview.local.php';

    if (!$isLocalRequest || !file_exists($previewConfig)) {
      $enabled = false;
      return $enabled;
    }

    $enabled = (require $previewConfig) === true;
    return $enabled;
  }

  function removeZero($cleanZero): string
  {
    return explode('.', $cleanZero)[0];
  }

  function getPhotoDir(string $name): string
  {
    return removeZero($name);
  }
  function can_see_modifica(): void{
    if($_SESSION["user"]["TIPO_USUARIO"]=="4"){
      header('Location: /sicexd/home.php');
      exit();
    }
  }


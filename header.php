<?php
session_start();

if(!isset($_SESSION['login']) || isset($_SESSION['login']) && !isset($_SESSION['login']['permitido']))
{
  //
  header('Location:index.php');

}

$host = "http://localhost/kardexadmin/";
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Colaboradores</title>
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
  <link href="<?= $host; ?>css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">

  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="<?= $host; ?>dashboard.php">SeminarioApp</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
      <div class="input-group">
        <input class="form-control" type="text" placeholder="Buscar cliente" aria-label="Search for..." aria-describedby="btnNavbarSearch" />
        <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
      </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i>
          <?= $_SESSION['login']["nombres"]; ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="#!">Configuracion</a></li>
          <li><a class="dropdown-item" href="#!">Cambiar contraseña</a></li>
          <li>
            <hr class="dropdown-divider" />
          </li>
          <li><a class="dropdown-item" href="<?= $host ?>/controllers/Colaborador.controller.php?operacion=destroy">Cerrar Sesion</a></li>
        </ul>
      </li>
    </ul>
  </nav>
  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <div class="sb-sidenav-menu-heading">Inicio</div>
            <a class="nav-link" href="<?= $host; ?>dashboard.php">
              <div class="sb-nav-link-icon"><i class="fa-solid fa-house"></i></div>
              Dashboard
            </a>

            <div class="sb-sidenav-menu-heading">Módulos</div>
            <a class="nav-link" href="<?= $host; ?>views/productos/">
              <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
              Productos
            </a>
            <a class="nav-link" href="<?= $host; ?>views/colaboradores/">
              <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
              Colaboradores
            </a>
            <a class="nav-link" href="<?= $host; ?>views/kardex/">
              <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
              Kardex
            </a>
          </div>
        </div>
        <div class="sb-sidenav-footer">
          <div class="small">Logged in as:</div>
          Start Bootstrap
        </div>
      </nav>
    </div>
    <div id="layoutSidenav_content">
      <main>
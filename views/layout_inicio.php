<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/build/css/app.css">
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin="" defer></script>
    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!-- JQUERY -->
    <script src="/build/js/jquery-3.6.1.min.js"></script>
    <!-- JAVASCRIPT -->
    <script src="/build/js/validaciones.js"></script>
    <script src="/build/js/inicio/functions.js"></script>
    <script src="/build/js/inicio/inicio.js"></script>
    <!-- LOGO -->
    <link rel="shortcut icon" href="/build/img/logo.ico" type="image/x-icon">
    <!-- TITULO -->
    <title>JG Studio | Expertos en Marketing Digital</title>
</head>
<body>
<nav class="navbar fixed-top navbar-expand-lg w-100">
    <div class="d-flex justify-content-sm-between w-100">
        <a class="navbar-brand" href="../index.html#inicio">
          <img src="build/img/logo-white.png" alt="JG Studio logo">
        </a>
        <div class="bgnav"></div>
        <div class="container-fluid d-flex align-items-center">
          <li id="btnPlanes" class="order-lg-last order-first">
            <a href="/login">Login</a>
          </li>
          <button class="navbar-toggler bg-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                <img src="build/img/logo.png" alt="">
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav flex-grow-1 pe-3 justify-content-lg-end">
                <li class="">
                    <a class="" href="/#inicio">Inicio</a>
                </li>
                <li class="">
                    <a class="" href="/#servicios">Servicios</a>
                </li>
                <li class="">
                    <a class="" href="/#portafolio">Portafolio</a>
                </li>
                <li class="">
                    <a class="" href="/#about">Sobre Nosotros</a>
                </li>
                <li class="">
                    <a class="" href="/#contacto">Contáctanos</a>
                </li>
            </div>
        </div>
        </div>
    </div>
</nav>
  <?php 
    echo $contenido;
  ?>
<footer class="">
    <section class="col-lg-3 col-12">
        <img src="build/img/logo-white.png" alt="logo JG Studio">
        <p>Creado, diseñado y desarrollado por Josbert Guedez Co-Fundador de JG Studio, Copyright © 2022, todos los derechos reservados para JG Studio.</p>
    </section>
    <section class="col-lg-3 col-6">
        <h1>Secciones</h1>
        <ul>
            <li><a href="/#inicio">Inicio</a></li>
            <li><a href="/#servicios">Servicios</a></li>
            <li><a href="/#portafolio">Portafolio</a></li>
            <li><a href="/#about">Sobre Nosotros</a></li>
            <li><a href="/#">Blog</a></li>
            <li><a href="/#contacto">Contáctanos</a></li>
            <li><a href="/login">LogIn</a></li>
        </ul>
    </section>
    <section class="col-lg-3 col-6">
        <h1>Contáctanos</h1>
        <ul>
            <li>
                <ul>
                    <li><a href="https://api.whatsapp.com/send?phone=584267799128&text=%C2%A1Hola!,%20Me%20gustar%C3%ADa%20saber%20mas%20sobre..." target="_blank"><i class="fa-brands fa-whatsapp"></i></a></li>
                    <li><a href="https://www.instagram.com/JG Studiove/" target="_blank"><i class="fa-brands fa-instagram"></i></a></li>
                    <li><a href="https://www.facebook.com/JG StudioVE/" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
                    <li><a href="/#formulario"><i class="fa-regular fa-envelope"></i></a></li>
                </ul>
            </li>
            <li><a href="/#citas">Agenda tu Video llamada</a></li>
            <li><a href="/#formulario">Enviar un mail</a></li>
        </ul>
    </section>
</footer>
</body>
<!-- BOOTSTRAP JAVASCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
<!-- FONT AWESOME -->
<script src="https://kit.fontawesome.com/d007e533c8.js" crossorigin="anonymous"></script>
<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Custom Javascript -->
<script src="/build/js/main.min.js"></script>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>JG Studio | Expertos en Marketing Digital</title>
  <!-- LOGO -->
  <link rel="shortcut icon" href="/build/img/logo.ico" type="image/x-icon">

  <!-- Bootstrap -->
  <link href="/build/external_imports/css/bootstrap.min.css" rel="stylesheet">
  <!-- BOOTSTRAP CSS (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <!-- NProgress -->
  <link href="/build/external_imports/css/nprogress.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link rel="stylesheet" href="/build/css/custom-gentella.css?25">
</head>
<body class="nav-md">
  <?php 
      include_once __DIR__ .'/templates/client-header.php';
  ?>
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="row">
      <?php 
        echo $contenido; 
      ?>
    </div>
  </div>
  <!-- /page content -->
  <!-- footer content -->
  <footer>
    <div class="pull-right">
      Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
    </div>
    <div class="clearfix"></div>
  </footer>
  <!-- /footer content -->
  </div>
</div>  
    <!-- jQuery -->
    <script src="/build/external_imports/js/jquery.min.js"></script>
    <!-- Bootstrap -->
   <script src="/build/external_imports/js/bootstrap.bundle.min.js"></script>
   <!-- BOOTSTRAP JAVASCRIPT (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <!-- FastClick -->
    <script src="/build/external_imports/js/fastclick.js"></script>
    <!-- NProgress -->
    <script src="/build/external_imports/js/nprogress.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/814f6eaa13.js" crossorigin="anonymous"></script>
    <!-- Custom Theme Scripts -->
    <script src="/build/js/gentella/custom.min.js"></script>
    <!-- Validaciones -->
    <script src="/build/js/validaciones.js"></script>
    <!-- Custom Javascript -->
    <script src="/build/js/main.min.js?25"></script>
</body>
</html>
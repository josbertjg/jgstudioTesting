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
  <!-- NProgress -->
  <link href="/build/external_imports/css/nprogress.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link rel="stylesheet" href="/build/css/custom-gentella.css?05">
</head>
<body class="nav-md">
  <?php 
      include_once __DIR__ .'/templates/admin-header.php';
  ?>
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Admin Dashboard</h3>
        </div>

        <div class="title_right">
          <div class="form-group pull-right">
            <h2>
              <?php 
                $iconName='';
                switch(strtolower($routeName)){
                case 'dashboard': $iconName='bars';
                break;
                case 'usuarios' : $iconName='user';
                break;
                case 'perfil' || 'detalle del usuario' : $iconName = 'id-card-clip';
                break;
              } 
              ?>
              <i class="fa-solid fa-<?php echo $iconName ?>"></i>
              <?php echo $routeName; ?>
            </h2>
          </div>
        </div>
      </div>

      <div class="row">
        <?php echo $contenido ?>
      </div>
    </div>
  </div>
  <!-- /page content -->
  <!-- footer content -->
  <footer>
    <div class="pull-right">
      JG Studio - Panel Administrador
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
    <!-- FastClick -->
    <script src="/build/external_imports/js/fastclick.js"></script>
    <!-- NProgress -->
    <script src="/build/external_imports/js/nprogress.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/814f6eaa13.js" crossorigin="anonymous"></script>
    <!-- Custom Theme Scripts -->
    <script src="/build/js/gentella/custom.min.js/05"></script>
    <!-- Validaciones -->
    <script src="/build/js/validaciones.js"></script>
    <!-- Custom Javascript -->
    <script src="/build/js/main.min.js?05"></script>
</body>
</html>
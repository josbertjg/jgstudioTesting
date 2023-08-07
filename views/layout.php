<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>JG Studio | Expertos en Marketing Digital</title>

  <!-- Bootstrap -->
  <link href="/build/external_imports/css/bootstrap.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="/build/external_imports/css/nprogress.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link rel="stylesheet" href="/build/css/custom-gentella.css">
</head>
<body class="nav-md">
  <?php 
      include_once __DIR__ .'/templates/client-header.php';
  ?>
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Panel del Cliente</h3>
        </div>

        <div class="title_right">
          <div class="col-md-5 col-sm-5 form-group pull-right top_search">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12  ">
          <div class="x_panel">
            <div class="x_title">
              <h2>Plain Page</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="#">Settings 1</a>
                      <a class="dropdown-item" href="#">Settings 2</a>
                    </div>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <?php 
                echo $contenido; 
              ?>
            </div>
          </div>
        </div>
      </div>
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
    <!-- FastClick -->
    <script src="/build/external_imports/js/fastclick.js"></script>
    <!-- NProgress -->
    <script src="/build/external_imports/js/nprogress.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/814f6eaa13.js" crossorigin="anonymous"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="/build/js/gentella/custom.min.js"></script>
</body>
</html>
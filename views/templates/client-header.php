<div class="container body">
  <div class="main_container">
    <div class="col-md-3 left_col">
      <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
          <a href="/dashboard" class="site_title">
            <img src="/build/img/logo-simple.png" alt="logo jg studio" class="logo-simple-sidebar">
            <span>JG Studio</span>
          </a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
          <div class="profile_pic">
            <img src="<?php echo $_SESSION['avatar'] ?? '/build/img/defaultUser.svg' ?>" alt="..." class="img-circle profile_img">
          </div>
          <div class="profile_info">
            <span>Welcome,</span>
            <h2><?php echo ucfirst($_SESSION['nombre']) ?></h2>
          </div>
          <div class="clearfix"></div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- /sidebar menu -->
        <?php 
          include_once __DIR__ .'/client-sidebar.php';
        ?>
        <!-- /sidebar menu -->
        
        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
          <a class="btn-footer" data-toggle="tooltip" data-placement="top" title="Settings">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
          </a>
          <a class="btn-footer" data-toggle="tooltip" data-placement="top" title="FullScreen">
            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
          </a>
          <a class="btn-footer" data-toggle="tooltip" data-placement="top" title="Lock">
            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
          </a>
          <a class="btn-footer" data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
          </a>
        </div>
        <!-- /menu footer buttons -->
      </div>
    </div>

    <!-- top navigation -->
    <div class="top_nav">
        <div class="nav_menu">
            <div class="nav toggle">
              <a id="menu_toggle">
                <span class="glyphicon glyphicon-th" aria-hidden="true"></span>
              </a>
            </div>
            <nav class="nav navbar-nav">
            <ul class=" navbar-right">
              <li class="nav-item dropdown open" style="padding-left: 15px;">
                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                  <img src="<?php echo $_SESSION['avatar'] ?? '/build/img/defaultUser.svg' ?>" alt=""><?php echo ucfirst($_SESSION['nombre']) ?></a>
                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item"  href="javascript:;"> Profile</a>
                    <a class="dropdown-item"  href="javascript:;">
                      <span class="badge bg-red pull-right">50%</span>
                      <span>Settings</span>
                    </a>
                <a class="dropdown-item"  href="javascript:;">Help</a>
                  <a class="dropdown-item"  href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                </div>
              </li>

              <li role="presentation" class="nav-item dropdown open">
                <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                  <i class="fa-solid fa-cart-shopping"></i>
                  <span class="badge bg-red">6</span>
                </a>
                <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                  <?php
                    $carrito = json_decode($_COOKIE['carrito']);
                    foreach($carrito as $producto):
                  ?>
                    <li class="nav-item">
                      <a class="dropdown-item">
                        <span class="image"><img src="<?php echo $_SESSION['avatar'] ?? '/build/img/diseño.png' ?>" alt="Profile Image" /></span>
                        <span>
                          <span><?php echo $producto->categoria->nombre ?></span>
                          <span class="time"><?php echo $producto->item_id ?></span>
                        </span>
                        <span class="message">
                          <?php 
                            foreach($producto->productos as $prod){
                              echo ' | '.$prod->cantidad_producto .' '. $prod->nombre_producto;
                            }
                          ?>
                        </span>
                      </a>
                    </li>
                  <?php endforeach; ?>
                  <li class="nav-item">
                    <div class="text-center">
                      <a class="dropdown-item">
                        <strong>Ver Carrito</strong>
                        <i class="fa-solid fa-cart-shopping"></i>
                      </a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    <!-- /top navigation -->

<div class="container body">
  <div class="main_container">
    <div class="col-md-3 left_col">
      <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
          <a href="/admin/dashboard" class="site_title">
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
          include_once __DIR__ .'/admin-sidebar.php';
        ?>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
          <a class="btn-footer" data-toggle="tooltip" data-placement="top" title="Configuracion" href="/admin/configuracion">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
          </a>
          <a class="btn-footer" data-toggle="tooltip" data-placement="top" title="Pagos" href="/admin/dashboard/pagos">
            <span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
          </a>
          <a class="btn-footer" data-toggle="tooltip" data-placement="top" title="Perfil" href="/admin/dashboard/users/userDetail?id=<?php echo currentUser_id()  ?>">
            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
          </a>
          <a class="btn-footer" data-toggle="tooltip" data-placement="top" title="Logout" href="/logout">
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
                  <a class="dropdown-item"  href="/admin/dashboard/users/userDetail?id=<?php echo currentUser_id()  ?>"> Profile</a>
                  <a class="dropdown-item"  href="javascript:;">Help</a>
                  <a class="dropdown-item"  href="/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                </div>
              </li>

              <li role="presentation" class="nav-item dropdown open">
                <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                <i class="fa-regular fa-envelope"></i>
                <?php 
                  $notifications = getNotifications();
                  if(count($notifications)>0){
                    ?>
                      <span class="badge bg-red"><?php echo count($notifications) ?></span>
                    <?php
                  }
                ?>
                </a>
                <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                  <?php
                    if(count($notifications)>0){
                      foreach($notifications as $notification):
                  ?>
                    <li class="nav-item">
                      <a class="dropdown-item" href="<?php
                        if(is_admin()) 
                          echo ($notification->nombre == 'Cotización') ? '/admin/dashboard/cotizaciones': '/admin/dashboard/pagos';
                        else if(is_empleado()){
                          echo '/admin/dashboard/myProjects';
                        }
                        ?>">
                        <span class="image"><img src="<?php echo $notification->imagen ?>" alt="Profile Image" /></span>
                        <span>
                          <span><?php echo $notification->nombre ?></span>
                          <span class="time">hace <?php echo $notification->fecha; ?></span>
                        </span>
                        <span class="message"> <?php echo $notification->mensaje ?> </span>
                      </a>
                    </li>
                  <?php 
                      endforeach;
                    }else{
                      ?>
                        <h2 style='text-align: center'>Tu buzón esta vacío</h2>
                      <?php
                    }
                  ?>
                </ul>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    <!-- /top navigation -->

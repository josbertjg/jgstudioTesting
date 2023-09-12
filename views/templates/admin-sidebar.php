<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <h3>General</h3>
    <ul class="nav side-menu">
      <?php if(is_admin()){ ?>
        <li><a href="/admin/dashboard/users"><i class="fa-solid fa-user"></i> Usuarios</a></li>
        <li><a href="/admin/productos"><i class="fa-solid fa-bell-concierge"></i> Productos</a></li>
        <li><a href="/admin/dashboard/cotizaciones"><i class="fa-solid fa-wallet"></i> Cotizaciones</a></li>
        <li><a><i class="fa fa-tasks"></i> Proyectos<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="/admin/dashboard/pendingProjects">Pendientes</a></li>
            <li><a href="/admin/dashboard/projects">Todos</a></li>
          </ul>
        </li>
        <li><a href="/admin/dashboard/pagos"><i class="fa fa-money"></i> Pagos</a></li>
        <li><a href="/admin/configuracion"><i class="glyphicon glyphicon-cog"></i> Configuración</a></li>
        <li><a><i class="fa-regular fa-edit"></i> Reportes<span class="fa fa-chevron-down"></span></a>
          <ul class="nav child_menu">
            <li><a href="/admin/dashboard/estadisticas">Estadísticas</a></li>
            <li><a href="/admin/dashboard/reportes">Reportes Generales</a></li>
          </ul>
        </li>
      <?php 
        }else if(is_empleado()){
          ?>
            <li><a href="/admin/dashboard/users/userDetail?id=<?php echo currentUser_id() ?>"><i class="fa-solid fa-user"></i> Perfil</a></li>
            <li><a href="/admin/dashboard/myProjects"><i class="fa-solid fa-tasks"></i> Mis Proyectos</a></li>
          <?php
        }
      ?>
    </ul>
  </div>
</div>
<!-- /sidebar menu -->
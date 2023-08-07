<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;

class AdminDashboardController {

  public static function adminDashboard(Router $router) {
   
    if(!is_admin_empleado()) {
      header('Location: /');
    };

    // Render a la vista 
    $router->render('admin/dashboard'
      // , 
      // [
      //     'titulo' => 'Iniciar Sesión',
      //     'alertas' => $alertas
      // ]
    );
  }

}
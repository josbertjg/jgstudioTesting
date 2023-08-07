<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;

class ClientDashboardController {

  public static function clientDashboard(Router $router) {
   
    if(!is_auth()) {
      header('Location: /');
    };

    // Render a la vista 
    $router->render('client/dashboard'
      // , 
      // [
      //     'titulo' => 'Iniciar Sesión',
      //     'alertas' => $alertas
      // ]
    );
  }

}
<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServiceController {

  //Vista del dashboard para admins y empleados
  public static function adminDashboard(Router $router) {

    if(!is_admin_empleado()) {
      header('Location: /');
    };

    // Render a la vista 
    $router->render('admin/dashboard', 
      [
          'routeName' => 'Dashboard',
          // 'alertas' => $alertas
      ]
    );
  }

  // Vista del CRUD para usuarios
  public static function service(Router $router) {

    if(!is_admin_empleado()) {
      header('Location: /');
    };

    $alertas = [];
    $servicio = new Servicio;

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $servicio->sincronizar($_POST);

      // debuguear($usuario);
      $alertas = $servicio->validar_insercion();

      if(empty($alertas)) {
        $existeServicio = Servicio::where('nombre', $servicio->nombre);

        if($existeServicio) {
          Servicio::setAlerta('error', 'Ya existe un usuario registrado con este correo');
          $alertas = Servicio::getAlertas();
        } else {
          $resultado =  $servicio->guardar();
        
          if($resultado) {
            Servicio::setAlerta('success', 'Usuario ingresado correctamente');
            $alertas = Servicio::getAlertas();
          }
        }
      }
    }

    // Render a la vista 
    $router->render('admin/services/services', 
      [
        'titulo' => 'Registrar servicio',
        'routeName' => 'Servicios',
        'alertas' => $alertas,
        'servicio' => Servicio::all()
      ]
    );
  }

  // Vista para el detalle del usuario
  public static function serviceDetail(Router $router) {

    if(!is_admin_empleado()) is_auth() ? header('location: /dashboard') : header('location: /');

    $id = $_GET['id'];
    
    if(!is_admin()) {
      if(currentUser_id() != $id){
        header('Location: /admin/dashboard');
      }
    };
    
    $alertas = [];
    $servicio = new Servicio;

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $servicio->sincronizar($_POST);

      //$alertas = $service->validar_edicion();

      if(empty($alertas)) {

        $existeServicio = Servicio::where('nombre', $servicio->nombre);

        if($existeServicio->id != $servicio->id) {
          Servicio::setAlerta('error', 'Ya existe un usuario registrado con este correo');
          $alertas = Servicio::getAlertas();
        }else{
          // Guardar los cambios
          $resultado =  $servicio->guardar();

          if($resultado) {
            Servicio::setAlerta('success', 'Cambios guardados correctamente');
            $alertas = Servicio::getAlertas();
          }
        }
      }
    }

    $servicio = Servicio::find($id);

    // Render a la vista 
    $router->render('admin/services/serviceDetail', 
      [
        'routeName' => currentUser_id() == $id ? 'Perfil' : 'Detalle del Usuario',
        'servicio' => $servicio,
        'alertas' => $alertas
      ]
    );
  }

}
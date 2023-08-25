<?php

namespace Controllers;

use Model\Usuario;
use Model\Producto;
use MVC\Router;

class AdminDashboardController {

  //Vista del dashboard para admins y empleados
  public static function adminDashboard(Router $router) {
   
    if(!is_admin_empleado()) {
      header('Location: /');
    };

    // Render a la vista 
    $router->render('admin/dashboard'
      , 
      [
          'routeName' => 'Dashboard',
          // 'alertas' => $alertas
      ]
    );
  }

  // Vista del CRUD para usuarios
  public static function users(Router $router) {
   
    if(!is_admin_empleado()) {
      header('Location: /');
    };

    $alertas = [];
    $usuario = new Usuario;

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      // debuguear($_POST);
      $usuario->sincronizar($_POST);

      // debuguear($usuario);
      $alertas = $usuario->validar_insercion();

      if(empty($alertas)) {
        $existeUsuario = Usuario::where('correo', $usuario->correo);

        if($existeUsuario) {
          Usuario::setAlerta('error', 'Ya existe un usuario registrado con este correo');
          $alertas = Usuario::getAlertas();
        } else {
          // Hashear el password
          // $usuario->hashPassword();

          // Eliminar password2
          // unset($usuario->password2);

          // Generar el Token
          // $usuario->crearToken();
          // Crear un nuevo usuario
          $resultado =  $usuario->guardar();
          
          // debuguear($resultado);

          // Enviar email
          // $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
          // $email->enviarConfirmacion();

          if($resultado) {
            Usuario::setAlerta('success', 'Usuario ingresado correctamente');
            $alertas = Usuario::getAlertas();
          }
        }
      }
    }

    // Render a la vista 
    $router->render('admin/users/users', 
      [
        'titulo' => 'Crear Usuario',
        'routeName' => 'Usuarios',
        'alertas' => $alertas,
        'users' => Usuario::all()
      ]
    );
  }

  // Vista para el detalle del usuario
  public static function userDetail(Router $router) {

    if(!is_admin_empleado()) is_auth() ? header('location: /dashboard') : header('location: /');

    $id = $_GET['id'];
    
    if(!is_admin()) {
      if(currentUser_id() != $id){
        header('Location: /admin/dashboard');
      }
    };
    
    $alertas = [];
    $usuario = new Usuario;

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $usuario->sincronizar($_POST);

      $alertas = $usuario->validar_edicion();

      if(empty($alertas)) {

        $existeUsuario = Usuario::where('correo', $usuario->correo);

        if($existeUsuario->id != $usuario->id) {
          Usuario::setAlerta('error', 'Ya existe un usuario registrado con este correo');
          $alertas = Usuario::getAlertas();
        }else{
          // Guardar los cambios
          $resultado =  $usuario->guardar();
          
          // Enviar email
          // $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
          // $email->enviarConfirmacion();
  
          if($resultado) {
            Usuario::setAlerta('success', 'Cambios guardados correctamente');
            $alertas = Usuario::getAlertas();
          }
        }
      }
    }

    $user = Usuario::find($id);

    // Render a la vista 
    $router->render('admin/users/userDetail', 
      [
        'routeName' => currentUser_id() == $id ? 'Perfil' : 'Detalle del Usuario',
        'user' => $user,
        'alertas' => $alertas
      ]
    );
  }

    // Vista del CRUD para usuarios
    public static function productos(Router $router) {

      if(!is_admin_empleado()) {
        header('Location: /');
      };
  
      $alertas = [];
      $producto = new Producto;
  
      if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $producto->sincronizar($_POST);
  
        // debuguear($usuario);
        $alertas = $producto->validar_insercion();
  
        if(empty($alertas)) {
          $existeproducto = Producto::where('nombre', $producto->nombre);
  
          if($existeproducto) {
            Producto::setAlerta('error', 'Ya existe un usuario registrado con este correo');
            $alertas = Producto::getAlertas();
          } else {
            $resultado =  $producto->guardar();
          
            if($resultado) {
              Producto::setAlerta('success', 'Usuario ingresado correctamente');
              $alertas = Producto::getAlertas();
            }
          }
        }
      }
  
      // Render a la vista 
      $router->render('admin/productos/productos', 
        [
          'titulo' => 'Registrar producto',
          'routeName' => 'productos',
          'alertas' => $alertas,
          'productos' => Producto::all()
        ]
      );
    }
  
    // Vista para el detalle del usuario
    public static function productoDetail(Router $router) {
  
      if(!is_admin_empleado()) is_auth() ? header('location: /dashboard') : header('location: /');
  
      $id = $_GET['id'];
      
      if(!is_admin()) {
        if(currentUser_id() != $id){
          header('Location: /admin/dashboard');
        }
      };
      
      $alertas = [];
      $producto = new Producto;
  
      if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $producto->sincronizar($_POST);
  
        //$alertas = $service->validar_edicion();
  
        if(empty($alertas)) {
  
          $existeproducto = Producto::where('nombre', $producto->nombre);
  
          if($existeproducto->id != $producto->id) {
            Producto::setAlerta('error', 'Ya existe un usuario registrado con este correo');
            $alertas = Producto::getAlertas();
          }else{
            // Guardar los cambios
            $resultado =  $producto->guardar();
  
            if($resultado) {
              Producto::setAlerta('success', 'Cambios guardados correctamente');
              $alertas = Producto::getAlertas();
            }
          }
        }
      }
  
      $producto = Producto::find($id);
  
      // Render a la vista 
      $router->render('admin/productos/productoDetail', 
        [
          'routeName' => currentUser_id() == $id ? 'Perfil' : 'Detalle del producto',
          'producto' => $producto,
          'alertas' => $alertas
        ]
      );
    }
}
<?php

namespace Controllers;

use Model\Usuario;
use Model\Categoria;
use Model\Producto;
use Model\Cotizacion;
use MVC\Router;
use Model\UploadImage;

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

          $resultado =  $usuario->guardar();
          
          //debuguear($resultado);

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
      //debuguear($usuario);

      $alertas = $usuario->validar_edicion();

      if(empty($alertas)) {

        $existeUsuario = Usuario::where('correo', $usuario->correo);

        //debuguear($existeUsuario);

        if($existeUsuario != null && $existeUsuario->id != $usuario->id) {
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
          }else{
              Usuario::setAlerta('error', 'Error al crear o actualizar el usuario');
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

  // Vista del CRUD para productos
  public static function productos(Router $router) {

    if(!is_admin_empleado()) {
      header('Location: /');
    };

    $alertas = [];
    $producto = new Producto;

    if($_SERVER['REQUEST_METHOD'] === 'POST' ) {
      $producto->sincronizar($_POST);

      if($producto){
        $alertas = $producto->validar_insercion();

        if(empty($alertas)) {

          $condiciones = array(
            "nombre" => $producto->nombre,
            "descripcion" => $producto->descripcion
          );

          $existeproducto = Producto::dinamicWhere($condiciones);
  
          //debuguear($existeproducto);

          if($existeproducto) {
            Producto::setAlerta('error', 'Ya existe un producto registrado con este correo');
            $alertas = Producto::getAlertas();
          } else {
            $resultado =  $producto->guardar();
            // debuguear($resultado);
            if($resultado) {
              Producto::setAlerta('success', 'Producto ingresado correctamente');
              $alertas = Producto::getAlertas();
            }
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

  // Vista para el detalle del productos
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

  public static function configuracionView(Router $router){

    if(!is_admin_empleado()) is_auth() ? header('location: /dashboard') : header('location: /');

    $id = $_GET['id'];
    
    if(!is_admin()) {
      if(currentUser_id() != $id){
        header('Location: /admin/dashboard');
      }
    };
    
    $router->render('admin/settings/indexSettings',[]);

  }
  
  public static function category(Router $router){

    if(!is_admin_empleado()) {
      header('Location: /');
    };

    $alertas = [];
    $category = new Categoria;
    $modelImage = 'Category';

    if($_SERVER['REQUEST_METHOD'] === 'POST' ) {

      $category->sincronizar($_POST);
      $file = $_FILES['file'];
      $filename = $file['name'];

      //debuguear($pathToSave);

      if($category){
        $alertas = $category->validar_insercion();

        if(empty($alertas)) {

          $condiciones = array(
            "nombre" => $category->nombre,
          );

          $existeproducto = Categoria::dinamicWhere($condiciones);
  
          //debuguear($existeproducto);

          if($existeproducto) {
            Categoria::setAlerta('error', 'Ya existe una cateoria registrada con el mismo nombre');
            $alertas = Categoria::getAlertas();
          } else {

            $pathToSave = uploadImage($_FILES,$modelImage);

            $category->imagen = $pathToSave; //. $filename;

            $resultado =  $category->guardar();
            //debuguear($category);

            if($resultado) {
              Categoria::setAlerta('success', 'Categoria registrada correctamente');
              $alertas = Categoria::getAlertas();
            }

            //debuguear(empty($file));

            // if(!empty($file)) {

            //   $targetPath = '../public/img/categories/';
            //   //debuguear($targetPath);

            //   if(!is_dir($targetPath)) {
            //     mkdir($targetPath, 0755, true);
            //   }

            //   $fileNameAux = $filename;
            //   $targetFile = $targetPath . basename($_FILES['file']['name']);
            //   $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            //   //debuguear($targetFile);

            //   $check = getimagesize($_FILES['file']['tmp_name']);

            //   if ($check !== false) {
            //     if (file_exists($targetFile)) {
            //         $filename = pathinfo($targetFile, PATHINFO_FILENAME);
            //         $extension = pathinfo($targetFile, PATHINFO_EXTENSION);
            //         $counter = 1;
            //         while (file_exists($targetFile)) {
            //             $newFilename = $filename . '_' . $counter . '.' . $extension;
            //             $fileNameAux = $newFilename;
            //             $targetFile = $targetPath . $newFilename;
            //             $counter++;
            //         }
            //     }

            //     if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            //         $alertas['success'][] = 'La imagen se ha subido correctamente.';

            //         $category->imagen = $fileNameAux;

            //         $resultado =  $category->guardar();
            //         //debuguear($category);

            //         if($resultado) {
            //           Categoria::setAlerta('success', 'Categoria registrada correctamente');
            //           $alertas = Categoria::getAlertas();
            //         }

            //         echo 'La imagen se ha subido correctamente.';
            //     } else {
            //         $alertas['error'][] = 'Hubo un error al subir la imagen.';
            //         echo 'Hubo un error al subir la imagen.';
            //     }
            //   } else {
            //       $alertas['error'][] = 'El archivo seleccionado no es una imagen válida.';
            //       echo 'El archivo seleccionado no es una imagen válida.';
            //   }
            // }
          }
        }
      }        
    }

    // Render a la vista 
    $router->render('admin/category/category', 
      [
        'titulo' => 'Registrar categorias',
        'routeName' => 'category',
        'alertas' => $alertas,
        'category' => Categoria::all()
      ]
    );
  }

  // Vista para las cotizaciones
  public static function cotizaciones(Router $router) {

    if(!is_admin()) {
      header('Location: /');
    };

    $alertas = [];
    $cotizacion = new Cotizacion();
    $idCotizacionWorked = null;

    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
      if($_POST['action']=='aceptarCotizacion'){

        $cotizacion->sincronizar($_POST);

        $alertas = $cotizacion->validarAprobacion();

        if(empty($alertas)){
          $resultado = $cotizacion->actualizar();
          if($resultado){
            Cotizacion::setAlerta('success', 'Cotizacion aprobada exitosamente.');
            $alertas = Cotizacion::getAlertas();
          }else{
            Cotizacion::setAlerta('error', 'Ocurrió un error intentar aprobar la cotizacion, intentalo mas tarde.');
            $alertas = Cotizacion::getAlertas();
          }
        }else $idCotizacionWorked = $cotizacion->id;
      }else if($_POST['action']=='rechazarCotizacion'){

        $cotizacion->sincronizar($_POST);

        $alertas = $cotizacion->validarRechazo();

        if(empty($alertas)){
          $resultado = $cotizacion->actualizar();
          if($resultado){
            Cotizacion::setAlerta('success', 'Cotizacion rechazada exitosamente.');
            $alertas = Cotizacion::getAlertas();
          }else{
            Cotizacion::setAlerta('error', 'Ocurrió un error intentar rechazar la cotizacion, intentalo mas tarde.');
            $alertas = Cotizacion::getAlertas();
          }
        }else $idCotizacionWorked = $cotizacion->id;
      }
    }

    $pendientes = Cotizacion::getPendientes();
    $completadas = Cotizacion::getCompletadas();

    $pendientesFormatted = [];
    $completadasFormatted = [];

    foreach($pendientes as $cotizacion){
      // Añadiendo el nombre y el correo del usuario al arreglo de cotizaciones pendientes
      $userCotizacion = Usuario::find($cotizacion->id_usuario);
      $cotizacion->nombre_usuario = $userCotizacion->nombre;
      $cotizacion->correo_usuario = $userCotizacion->correo;
      
      array_push($pendientesFormatted, $cotizacion);
    }

    foreach($completadas as $cotizacion){
      // Añadiendo el nombre y el correo del usuario al arreglo de cotizaciones completadas
      $userCotizacion = Usuario::find($cotizacion->id_usuario);
      $cotizacion->nombre_usuario = $userCotizacion->nombre;
      $cotizacion->correo_usuario = $userCotizacion->correo;
      
      array_push($completadasFormatted, $cotizacion);
    }
    

    // Render a la vista 
    $router->render('admin/cotizaciones/cotizaciones'
      , 
      [
          'routeName' => 'Cotizaciones',
          'alertas' => $alertas,
          'pendientes' => $pendientesFormatted,
          'completadas' => $completadasFormatted,
          'idCotizacionWorked' => $idCotizacionWorked
      ]
    );
  }
}
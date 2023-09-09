<?php

namespace Controllers;

use Model\Usuario;
use Model\Categoria;
use Model\Producto;
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
            Producto::setAlerta('error', 'Ya un producto registrado con este nombre');
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
              $category->imagen = $pathToSave;
              $resultado =  $category->guardar();
              //debuguear($category);

              if($resultado) {
                Categoria::setAlerta('success', 'Categoria registrada correctamente');
                $alertas = Categoria::getAlertas();
              }
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

    public static function deleteCategory(Router $router) {
      // Obtener el id del registro a eliminar de la URL
      $id = $_POST['id'];

      //debuguear($_POST['id']);

      if(!is_admin_empleado()) {
        header('Location: /');
      };
      
      $alertas = [];
      $category = new Categoria;

      $category->sincronizar($_POST);
  
      //debuguear($category);

      $category->id = $id;
      $category->estado = 0;

      $files = array (        
        "estado" => 0,
      );

      $condiciones = array(
        'files' => $files,
        "id" => $id
      );

      $categoryUpdated = Categoria::dinamicUpdate($condiciones);

      // Realizar la eliminación del registro (código necesario)

      // Redireccionar a la página de categorías después de eliminar el registro

      $router->render('admin/category/category', 
        [
          'titulo' => 'Registrar categorias',
          'routeName' => 'category',
          'alertas' => $alertas,
          'category' => Categoria::all()
        ]
      );
    }

    // Detalle de las categorías
    public static function categoryDetail(Router $router) {

      if(!is_admin_empleado()) is_auth() ? header('location: /dashboard') : header('location: /');
  
      $id = $_GET['id'];
    
      if(!is_admin()) {
        if(currentUser_id() != $id){
          header('Location: /admin/dashboard');
        }
      };
      
      $alertas = [];
      $categoria = new Categoria;
      $categoriaOld = Categoria::find($id);

  
      if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $categoria->sincronizar($_POST);
  
        //$alertas = $service->validar_edicion();
  
        if(empty($alertas)) {
  
          $existecategoria = Categoria::where('nombre', $categoria->nombre);
  
          //debuguear($existecategoria);

          if($existecategoria && $existecategoria->id != $categoria->id) {
            Categoria::setAlerta('error', 'Ya existe una categoría con el nombre ingresado');
            $alertas = Categoria::getAlertas();
          }else{
            // Guardar los cambios
            $categoria->imagen = $categoriaOld->imagen;
            $resultado =  $categoria->guardar();
  
            if($resultado) {
              Categoria::setAlerta('success', 'Cambios guardados correctamente');
              $alertas = Categoria::getAlertas();
            }
          }
        }
      }
  
      $categoria = Categoria::find($id);
  
      // Render a la vista 
      $router->render('admin/category/categoryDetail', 
        [
          'routeName' => currentUser_id() == $id ? 'Perfil' : 'Detalle de la categoría',
          'categoria' => $categoria,
          'alertas' => $alertas
        ]
      );
    }

    public static function bank(Router $router){

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
              $category->imagen = $pathToSave;
              $resultado =  $category->guardar();
              //debuguear($category);

              if($resultado) {
                Categoria::setAlerta('success', 'Categoria registrada correctamente');
                $alertas = Categoria::getAlertas();
              }
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

    public static function deleteBank(Router $router) {
      // Obtener el id del registro a eliminar de la URL
      $id = $_POST['id'];

      //debuguear($_POST['id']);

      if(!is_admin_empleado()) {
        header('Location: /');
      };
      
      $alertas = [];
      $category = new Categoria;

      $category->sincronizar($_POST);
  
      //debuguear($category);

      $category->id = $id;
      $category->estado = 0;

      $files = array (        
        "estado" => 0,
      );

      $condiciones = array(
        'files' => $files,
        "id" => $id
      );

      $categoryUpdated = Categoria::dinamicUpdate($condiciones);

      // Realizar la eliminación del registro (código necesario)

      // Redireccionar a la página de categorías después de eliminar el registro

      $router->render('admin/category/category', 
        [
          'titulo' => 'Registrar categorias',
          'routeName' => 'category',
          'alertas' => $alertas,
          'category' => Categoria::all()
        ]
      );
    }

    // Detalle de las categorías
    public static function bankDetail(Router $router) {

      if(!is_admin_empleado()) is_auth() ? header('location: /dashboard') : header('location: /');
  
      $id = $_GET['id'];
    
      if(!is_admin()) {
        if(currentUser_id() != $id){
          header('Location: /admin/dashboard');
        }
      };
      
      $alertas = [];
      $categoria = new Categoria;
      $categoriaOld = Categoria::find($id);

  
      if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $categoria->sincronizar($_POST);
  
        //$alertas = $service->validar_edicion();
  
        if(empty($alertas)) {
  
          $existecategoria = Categoria::where('nombre', $categoria->nombre);
  
          //debuguear($existecategoria);

          if($existecategoria && $existecategoria->id != $categoria->id) {
            Categoria::setAlerta('error', 'Ya existe una categoría con el nombre ingresado');
            $alertas = Categoria::getAlertas();
          }else{
            // Guardar los cambios
            $categoria->imagen = $categoriaOld->imagen;
            $resultado =  $categoria->guardar();
  
            if($resultado) {
              Categoria::setAlerta('success', 'Cambios guardados correctamente');
              $alertas = Categoria::getAlertas();
            }
          }
        }
      }
  
      $categoria = Categoria::find($id);
  
      // Render a la vista 
      $router->render('admin/category/categoryDetail', 
        [
          'routeName' => currentUser_id() == $id ? 'Perfil' : 'Detalle de la categoría',
          'categoria' => $categoria,
          'alertas' => $alertas
        ]
      );
    }
}
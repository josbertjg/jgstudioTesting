<?php

namespace Controllers;

use Model\Usuario;
use Model\Categoria;
use Model\Producto;
use Model\Banco;
use Model\Cotizacion;
use Model\Pago;
use Model\Contrato;
use Model\ContratoProducto;
use Model\Proyecto;
use Model\UsuarioProyecto;
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
    $modelImage = 'UserAvatar';

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $usuario->sincronizar($_POST);

      $alertas = $usuario->validar_edicion();

      if(empty($alertas)) {

        $existeUsuario = Usuario::where('correo', $usuario->correo);

        //debuguear($existeUsuario);

        if($existeUsuario != null && $existeUsuario->id != $usuario->id) {
          Usuario::setAlerta('error', 'Ya existe un usuario registrado con este correo');
          $alertas = Usuario::getAlertas();
        }else{

          $file = $_FILES['file'];
          $filename = $file['name'];

          if($file){
            $pathToSave = uploadImage($_FILES,$modelImage);
            $usuario->avatar = $pathToSave;
          }

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

 // Eliminación lógica de usuarios
 public static function deleteUser(Router $router) {
  // Obtener el id del registro a eliminar de la URL
  $id = $_POST['id'];

  //debuguear($_POST['id']);

  if(!is_admin_empleado()) {
    header('Location: /');
  };
  
  $alertas = [];
  $usuario = new Usuario;

  $usuario->sincronizar($_POST);

  //debuguear($usuario);

  $usuario->id = $id;
  $usuario->estado = 0;

  $files = array (        
    "estado" => 0,
  );

  $condiciones = array(
    'files' => $files,
    "id" => $id
  );

  $usuarioUpdated = Usuario::dinamicUpdate($condiciones);

  // Realizar la eliminación del registro (código necesario)

  // Redireccionar a la página de categorías después de eliminar el registro

  $router->render('admin/users/users', 
    [
      'titulo' => 'Crear Usuario',
      'routeName' => 'Usuarios',
      'alertas' => $alertas,
      'users' => Usuario::all()
    ]
  );
}

// Vista del CRUD para productos
public static function productos(Router $router) {

  //debuguear('productos');

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

        // debuguear($existeproducto);

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
  $productoOld = Producto::find($id);

  if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto->sincronizar($_POST);

    if(empty($alertas)) {

      $existeproducto = Producto::where('nombre', $producto->nombre);

      if($existeproducto && $existeproducto->id != $producto->id) {
        Producto::setAlerta('error', 'Ya está registrado un producto con este nombre');
        $alertas = Producto::getAlertas();
      }else{
        // Guardar los cambios
        $resultado =  $producto->guardar();

        //debuguear($resultado);

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

// Eliminación lógica de productos
public static function deleteProduct(Router $router) {
  // Obtener el id del registro a eliminar de la URL
  $id = $_POST['id'];

  //debuguear($_POST['id']);

  if(!is_admin_empleado()) {
    header('Location: /');
  };
  
  $alertas = [];
  $producto = new Producto;

  $producto->sincronizar($_POST);

  //debuguear($producto);

  $producto->id = $id;
  $producto->estado = 0;

  $files = array (        
    "estado" => 0,
  );

  $condiciones = array(
    'files' => $files,
    "id" => $id
  );

  $cproductoUpdated = Producto::dinamicUpdate($condiciones);

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

// llamado a la vista de configuraciones
public static function configuracionView(Router $router){

  if(!is_admin()) header('location: /');

 
  $router->render('admin/settings/indexSettings',[]);

}

// Registro de categorías
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

        $existeCategory = Categoria::dinamicWhere($condiciones);

        //debuguear($existeproducto);

        if($existeCategory) {
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

// Eliminación lógica Category
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
  $banco = new Banco;
  $bancoOld = Banco::find($id);


  if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $banco->sincronizar($_POST);

    //$alertas = $service->validar_edicion();

    if(empty($alertas)) {

      $existeBanco = Banco::where('nombre', $banco->nombre);

      //debuguear($existecategoria);

      if($existeBanco && $existeBanco->id != $banco->id) {
        Banco::setAlerta('error', 'Ya existe un banco con los datos ingresados');
        $alertas = Banco::getAlertas();
      }else{
        // Guardar los cambios
        $banco->imagen = $bancoOld->imagen;
        $resultado =  $banco->guardar();

        if($resultado) {
          Banco::setAlerta('success', 'Cambios guardados correctamente');
          $alertas = Banco::getAlertas();
        }
      }
    }
  }

  $banco = Banco::find($id);

  // Render a la vista 
  $router->render('admin/bank/bankDetail', 
    [
      'routeName' => currentUser_id() == $id ? 'Perfil' : 'Detalle del banco',
      'banco' => $banco,
      'alertas' => $alertas
    ]
  );
}

// Agregar banco
public static function bank(Router $router){

  if(!is_admin_empleado()) {
    header('Location: /');
  };

  $alertas = [];
  $banco = new Banco;
  $modelImage = 'Bank';

  if($_SERVER['REQUEST_METHOD'] === 'POST' ) {

    $banco->sincronizar($_POST);
    $file = $_FILES['file'];
    $filename = $file['name'];

    //debuguear($banco);

    if($banco){
      $alertas = $banco->validar_insercion();

      if(empty($alertas)) {

        $condiciones = array(
          "nombre" => $banco->nombre,
          "codigo" => $banco->codigo,
        );

        $existeBanco = Banco::dinamicWhere($condiciones);

        //debuguear($existeBanco);

        if($existeBanco) {
          Banco::setAlerta('error', 'Ya existe un banco registrado con los datos ingresados');
          $alertas = Banco::getAlertas();
        } else {

          $pathToSave = uploadImage($_FILES,$modelImage);
          $banco->imagen = $pathToSave;
          $resultado =  $banco->guardar();
          //debuguear($resultado);

          if($resultado) {
            Banco::setAlerta('success', 'Banco registrado correctamente');
            $alertas = Banco::getAlertas();
          }
        }
      }
    }        
  }

  // Render a la vista 
  $router->render('admin/bank/bank', 
    [
      'titulo' => 'Registrar banco',
      'routeName' => 'bank',
      'alertas' => $alertas,
      'banco' => Banco::all()
    ]
  );
}

// Eliminación lógica de Banco
public static function deleteBank(Router $router) {
  // Obtener el id del registro a eliminar de la URL
  $id = $_POST['id'];

  //debuguear($_POST['id']);

  if(!is_admin_empleado()) {
    header('Location: /');
  };
  
  $alertas = [];
  $banco = new Banco;

  $banco->sincronizar($_POST);

  //debuguear($category);

  $banco->id = $id;
  $banco->estado = 0;

  $files = array (        
    "estado" => 0,
  );

  $condiciones = array(
    'files' => $files,
    "id" => $id
  );

  $bancoUpdated = Banco::dinamicUpdate($condiciones);

  // Redireccionar a la página de bancos después de eliminar el registro
  $router->render('admin/bank/bank', 
    [
      'titulo' => 'Registrar banco',
      'routeName' => 'bank',
      'alertas' => $alertas,
      'banco' => Banco::all()
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

// llamado a la vista de pagos
public static function pagos(Router $router){
  if(!is_admin()) header('location: /');

  $alertas = [];

  if($_SERVER['REQUEST_METHOD'] === 'POST' ){
    
    if( $_POST['action'] == 'rechazar_pago' ){ // Logica para rechazar pagos
      $pago = Pago::find($_POST['id_pago']);
      $pago->rechazar();
      $resultado = $pago->guardar();
      if($resultado){

        $contrato = Contrato::find($pago->id_contrato);
        $contrato->rechazar();
        $resultadoContrato = $contrato->guardar();

        if($resultadoContrato){

          $proyectos = Proyecto::findAll('id_contrato',$pago->id_contrato);

          foreach($proyectos as $proyecto){
            $proyecto->rechazar();
            $proyecto->guardar();
          }

          Pago::setAlerta('success', 'Pago Rechazado exitosamente.');
          $alertas = Pago::getAlertas();
        }else{
          $pago->estado_pago = 1;
          $pago->guardar();
          Pago::setAlerta('error', 'Ocurrio un error al rechazar el pago (Entidad Contrato), intentalo mas tarde');
          $alertas = Pago::getAlertas();
        }

      }else{
        Pago::setAlerta('error', 'Ocurrio un error al rechazar el pago, intentalo mas tarde.');
        $alertas = Pago::getAlertas();
      }
    }else if( $_POST['action'] == 'aprobar_pago' ){ // Logica para aprobar pagos

      $pago = Pago::find($_POST['id_pago']);
      $pago->aprobar();
      $resultado = $pago->guardar();

      if($resultado){

        $contrato = Contrato::find($pago->id_contrato);
        $contrato->aprobar();
        $resultadoContrato = $contrato->guardar();

        if($resultadoContrato){

          $proyectos = Proyecto::findAll('id_contrato',$pago->id_contrato);

          foreach($proyectos as $proyecto){
            $proyecto->setPorHacer();
            $proyecto->guardar();
          }

          Pago::setAlerta('success', 'Pago Aprobado exitosamente.');
          $alertas = Pago::getAlertas();
        }else{
          $pago->estado_pago = 1;
          $pago->guardar();
          Pago::setAlerta('error', 'Ocurrio un error al aprobar el pago (Entidad Contrato), intentalo mas tarde');
          $alertas = Pago::getAlertas();
        }

      }else{
        Pago::setAlerta('error', 'Ocurrio un error al aprobar el pago, intentalo mas tarde.');
        $alertas = Pago::getAlertas();
      }

    }
  }

  $pendientes = Pago::getPendientes();

  // Añadiendo la informacion del usuario a cada pago
  foreach($pendientes as $i=>$pago){
    $pendientes[$i]->usuario = Usuario::find($pago->id_usuario);
  }

  $router->render('admin/pagos/pagos',[
    'alertas' => $alertas,
    'pagos' => $pendientes
  ]);

}

// llamado a la vista de proyectos
public static function proyectos(Router $router){
  if(!is_admin()) header('location: /');

  $alertas = [];

  $proyectos = Proyecto::all();

  foreach($proyectos as $i=>$proyecto){
    $proyectos[$i]->categoria = Categoria::find($proyecto->id_categoria);
    $proyectos[$i]->estado = $proyecto->getEstadoProyecto();
  }
 
  $router->render('admin/proyectos/proyectos',[
    'alertas' => $alertas,
    'proyectos' => $proyectos,
  ]);

}

// llamado a la vista de proyectos
public static function pendingProyectos(Router $router){
  if(!is_admin()) header('location: /');

  $alertas = [];

  if($_SERVER['REQUEST_METHOD'] === 'POST' ){
    $usuario_proyecto = new UsuarioProyecto();
    $usuario_proyecto->id_proyecto = $_POST['id_proyecto'];
    $usuario_proyecto->id_usuario = $_POST['id_empleado'];
    $resultado = $usuario_proyecto->guardar();

    if($resultado["resultado"]){

      $proyecto = Proyecto::find($_POST['id_proyecto']);
      $proyecto->setEnCurso();

      $resultadoProyecto = $proyecto->guardar();

      if($resultadoProyecto){
        Proyecto::setAlerta('success', 'Empleado Asignado exitosamente, el proyecto ya esta en curso.');
        $alertas = Proyecto::getAlertas();
      }else{
        Proyecto::setAlerta('error', 'Ocurrio un error al asignar al empleado (Entidad Proyecto).');
        $alertas = Proyecto::getAlertas();
      }

    }else{
      Proyecto::setAlerta('error', 'Ocurrio un error al asignar al empleado (Entidad Usuario Proyecto).');
      $alertas = Proyecto::getAlertas();
    }
  }

  $proyectos = Proyecto::getPorHacer();
  $empleados = [];

  if(!empty($proyectos)){
    foreach($proyectos as $i=>$proyecto){
      $usuariosProyecto = UsuarioProyecto::findAll('id_proyecto',$proyecto->id);
      $productosProyecto = ContratoProducto::findAll('id_proyecto',$proyecto->id);
      $proyectos[$i]->productos = [];
  
      if(!empty($usuariosProyecto)){
        $proyectos[$i]->usuarios = $usuariosProyecto;
      }
      if(!empty($productosProyecto)){
        foreach($productosProyecto as $producto){
          $productoToProyecto = Producto::find($producto->id_producto);
          array_push($proyectos[$i]->productos,$productoToProyecto);
        }
      }
      $proyectos[$i]->categoria = Categoria::find($proyecto->id_categoria);
      $proyectos[$i]->contrato = Contrato::find($proyecto->id_contrato);
      $proyectos[$i]->contrato->usuario = Usuario::find($proyectos[$i]->contrato->id_usuario);
    }
  
    $empleados = Usuario::getEmpleados();
    
    foreach($empleados as $i=>$empleado){
      $empleados[$i]->rol = showRol($empleado->id_rol);
    }
  }
  
  // debuguear(showRol(2));

  $router->render('admin/proyectos/proyectosPendientes',[
    'alertas' => $alertas,
    'proyectos' => $proyectos,
    'empleados' => $empleados
  ]);

}
}
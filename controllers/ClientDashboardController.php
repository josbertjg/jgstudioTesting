<?php

namespace Controllers;

use Model\Usuario;
use Model\Producto;
use Model\Categoria;
use Model\Cotizacion;
use Model\Pago;
use Model\Contrato;
use Model\ContratoProducto;
use Model\Proyecto;
use MVC\Router;

class ClientDashboardController {

  public static function clientDashboard(Router $router) {
   
    if(!is_auth()) {
      header('Location: /');
    };

    $alertas = [];
    $servicios = [];

    foreach(Categoria::all() as $categoria){
      $productos = Producto::findAll('id_categoria',$categoria->id);
      $objeto = (object)[];
      $objeto->categoria = $categoria;
      $objeto->productos = $productos;
      array_push($servicios,$objeto);
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

      if(empty($_POST['action'])){ // Añadir items al carrito
        $carrito = getCarrito();
        
        $firstProducto = json_decode($_POST[array_key_first($_POST)]);
        $categoria = (object)[];
        $categoria->id = $firstProducto->id_categoria;
        $categoria->nombre = $firstProducto->nombre_categoria;
        $categoria->imagen = $firstProducto->imagen_categoria;
  
        $itemRepetido=false;
        foreach($carrito as $item){
          if($item->item_id == $firstProducto->item_id){ 
            $itemRepetido = true;
            // debuguear($itemRepetido);
            break;
          }
        }
  
        if(!$itemRepetido){
          $objetoCarrito = (object)[];
          $objetoCarrito->item_id = $firstProducto->item_id;
          $objetoCarrito->categoria = $categoria;
          $objetoCarrito->isCotizacion = false;
          $objetoCarrito->productos = [];
    
          foreach($_POST as $producto){
            $prod = json_decode($producto);
            if($prod->cantidad_producto>0){
              unset($prod->id_categoria);
              unset($prod->nombre_categoria);
              unset($prod->item_id);
              array_push($objetoCarrito->productos,$prod);
            }
          }
    
          if(count($objetoCarrito->productos)>0){
            array_push($carrito,$objetoCarrito);
            //mandar alerta exitosa
          }else {
            //mandar una alerta de que debe añadir al menos un producto de la categoria seleccionada
          }
          setCarrito($carrito);
        }
      }else if($_POST['action'] == 'cotizacion'){ // Cotizacion
        $cotizacion = new Cotizacion;
        $cotizacion->sincronizar($_POST);
        $alertas = $cotizacion->validate_insert_byClient();

        if(empty($alertas)){
          $resultado = $cotizacion->guardar();

          if($resultado) {
            Usuario::setAlerta('success', 'Solicitud de cotizacion enviada, sera revisada por uno de nuestros administradores, podrás ver la respuesta en el panel "Mis Cotizaciones"');
            $alertas = Usuario::getAlertas();
          }else{
              Usuario::setAlerta('error', 'Error al enviar la cotización, intentalo mas tarde...');
              $alertas = Usuario::getAlertas();
          }
        }
      }
    }

    // Render a la vista 
    $router->render('client/dashboard', 
      [
        'alertas' => $alertas,
        'servicios' => $servicios
      ]
    );
  }
  
  // Vista para el detalle del cliente
  public static function clientProfile(Router $router) {

    // Si el usuario no es un cliente, se le redirige a la página de inicio o de registro
    if(!is_cliente()) {
      header('location: /');
    }
    $id = currentUser_id() ;
    $client = new Usuario;
    $modelImage = 'UserAvatar';

    //$clientLoged = Usuario::find($id);
    $alertas = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $client->sincronizar($_POST);

      //debuguear($client);

      $alertas = $client->validar_edicion();

      if(empty($alertas)) {

        $existeUsuario = Usuario::where('correo', $client->correo);

        if($existeUsuario->id != $client->id) {
          Usuario::setAlerta('error', 'Ya existe un usuario registrado con este correo');
          $alertas = Usuario::getAlertas();
        }else{

          $file = $_FILES['file'];
          $filename = $file['name'];

          if($file){
            $pathToSave = uploadImage($_FILES,$modelImage);
            $client->avatar = $pathToSave;
          }

          // Guardar los cambios
          $resultado =  $client->guardar();
        

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
    
    $client = Usuario::find($id);

    // Render a la vista 
    $router->render('client/profile', 
      [
        'routeName' => 'Perfil',
        'client' => $client,
        'alertas' => $alertas
      ]
    );
  }
  
  // Carrito de compra
  public static function miCarrito(Router $router) {
    if(!is_cliente()) {
      header('location: /');
    }
    
    $alertas = [];
    $carrito = getCarrito();
    $allCategorias = Categoria::all();
    $allProductos = Producto::all();
    $acum = 0;
    $userWereRegistering = false;
    $userHasBeenRegistered = false;


    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      if($_POST['action']){
        switch($_POST['action']){
          // POST Para Eliminar un articulo del carrito
          case 'delete_item_carrito': deleteItemCarrito($_POST['item_id']);
          break;
          // POST Para Culminar el registro
          case 'culminar_registro': 
            $cliente = new Usuario;
            $cliente->sincronizar($_POST);
            $alertas = $cliente->validar_edicion();

            if(empty($alertas)){
              
              $resultado =  $cliente->guardar();

              if($resultado) {
                Usuario::setAlerta('success', 'Tus datos se han guardado correctamente.');
                $alertas = Usuario::getAlertas();
                $userHasBeenRegistered = true;
              }
            }else $userWereRegistering = true;
          break;
          // POST Para realizar pago
          case 'realizar_pago':

            $carritoToProducto = json_decode($_POST['carrito']);
            $pago = new Pago();
            if($_POST['id_tipo_pago'] < 3){
              $pago->comprobante = $_FILES['file'];
            }
            $pago->id_usuario = currentUser_id();
            $pago->sincronizar($_POST);

            if($_POST['id_tipo_pago'] < 3){
              $alertas = $pago->validar_transferencia();
            }
           
            if(empty($alertas)){

              //Registrando un nuevo contrato
              $contrato = new Contrato();
              $contrato->id_usuario = currentUser_Id();
              $contrato->estado = 1;
              $contrato->monto = $pago->monto;
              $contrato->monto_total = $pago->monto;

              // Creando el Contrato
              $resultado = $contrato->guardar();

              if(!$resultado["resultado"]){
                Pago::setAlerta('error', 'Ocurrio un error (Entidad Contrato), intentalo mas tarde.');
                $alertas = Pago::getAlertas();
              }else{
                $idContrato = $resultado["id"];
                $errorContrato = false;

                // Creando cada Contrato Producto y Creando cada Proyecto
                foreach($carritoToProducto as $productoItem){

                  // debuguear($productoItem);

                  $proyecto = new Proyecto();
                  $proyecto->id_contrato = $idContrato;
                  $proyecto->id_categoria = $productoItem->categoria->id;
                  $proyecto->id_usuario = currentUser_Id();
                  $proyecto->nombre = $productoItem->categoria->nombre.' '.uniqid();

                  if($productoItem->isCotizacion){
                    $proyecto->detalles = '<strong>Solicitud: </strong> '.$productoItem->solicitud.'. <br><strong>Respuesta: </strong>'.$productoItem->respuesta;
                  }

                  $resultadoProyecto = $proyecto->registrar_proyecto();

                  if($resultadoProyecto["resultado"]){
                    $idProyecto = $resultadoProyecto["id"];

                    // Revisando si el producto a guardar en el contrato es una cotizacion o no
                    if(!$productoItem->isCotizacion){ // Si no es una cotizacion, entonces
                      foreach($productoItem->productos as $producto){
                        $contratoProducto = new ContratoProducto();
  
                        $contratoProducto->id_contrato = $idContrato;
                        $contratoProducto->id_categoria = $productoItem->categoria->id;
                        $contratoProducto->id_producto = $producto->id;
                        $contratoProducto->id_proyecto = $idProyecto;
                        $contratoProducto->precio_unitario = $producto->precio_unitario;
                        $contratoProducto->cantidad = $producto->cantidad_producto;
                        $contratoProducto->precio_total = $producto->precio_unitario * $producto->cantidad_producto;
    
                        $resultadoProducto = $contratoProducto->registrar_contratoProducto();
                        if(!$resultadoProducto["resultado"]){
                          $errorContrato = true;
                          ContratoProducto::eliminarAll('id_contrato',$idContrato);
                          Proyecto::eliminarAll('id_contrato',$idContrato);
                          break;
                        }
                      }
                    }else{ // Si es una cotizacion, entonces
                      $contratoProducto = new ContratoProducto();

                      
                      $contratoProducto->id_contrato = $idContrato;
                      $contratoProducto->id_categoria = $productoItem->categoria->id;
                      $contratoProducto->id_producto = $productoItem->producto->id;
                      $contratoProducto->id_proyecto = $idProyecto;
                      $contratoProducto->precio_unitario = $productoItem->monto_final;
                      $contratoProducto->cantidad = 1;
                      $contratoProducto->precio_total = $productoItem->monto_final;
 
                      $resultadoProducto = $contratoProducto->registrar_contratoProducto();
                      if(!$resultadoProducto["resultado"]){
                        $errorContrato = true;
                        ContratoProducto::eliminarAll('id_contrato',$idContrato);
                        Proyecto::eliminarAll('id_contrato',$idContrato);
                        break;
                      }
                    }


                  }else{
                    $errorContrato = true;
                    ContratoProducto::eliminarAll('id_contrato',$idContrato);
                    Proyecto::eliminarAll('id_contrato',$idContrato);
                    Pago::setAlerta('error', 'Ocurrio un error (Entidad Proyecto), al procesar el ingreso del pago, intentalo más tarde.');
                    $alertas = Pago::getAlertas();
                  }
                  
                  if($errorContrato){
                    Contrato::eliminarById($idContrato);
                    Pago::setAlerta('error', 'Ocurrio un error (Entidad ContratoProducto), al procesar el ingreso del pago, intentalo más tarde.');
                    $alertas = Pago::getAlertas();
                    break;
                  }
                }

                if(!$errorContrato){
                  $pago->id_contrato = $idContrato;
                  $pago->comprobante = uploadImage($_FILES, 'Pago');
                  $resultadoPago = $pago->registrar_pago();

                  if($resultadoPago["resultado"]){
                    Pago::setAlerta('success', 'Pago registrado, espera a que un administrador lo revise.');
                    $alertas = Pago::getAlertas();
                  }else{
                    Pago::setAlerta('error', 'Ha ocurrido un error al registrar el pago (Entidad Pago), intentalo mas tarde.');
                    $alertas = Pago::getAlertas();
                  }
                }
              }

            }
          break;
        }
      }
    }

    $carritoToSend = [];
    $carrito = getCarrito();
    // Armando la info del carrito para mandar al front
    foreach($carrito as $itemCarrito){
      $acum = 0;
      $objetoItemCarritoToSend = (object)[];

      $objetoItemCarritoToSend->isCotizacion = $itemCarrito->isCotizacion;

      if(!$objetoItemCarritoToSend->isCotizacion){
        $objetoItemCarritoToSend->item_id = $itemCarrito->item_id;
        
        // Recorriendo las categorias para guardar la encontrada
        foreach($allCategorias as $category){
          if($category->id == $itemCarrito->categoria->id){
            $objetoItemCarritoToSend->categoria = $category;
            break;
          }
        }
  
        // Recorriendo los productos para guardar los encontrados
        $objetoItemCarritoToSend->productos = [];
        foreach($itemCarrito->productos as $productoCarrito){
          foreach($allProductos as $producto){
            if($productoCarrito->id_producto == $producto->id){
              $producto->cantidad_producto = $productoCarrito->cantidad_producto;
              $acum += $producto->precio_unitario * $producto->cantidad_producto;
              array_push($objetoItemCarritoToSend->productos,$producto);
            }
          }
        }
        $objetoItemCarritoToSend->total = $acum;
      }else{
        $objetoItemCarritoToSend = $itemCarrito;
      }
      array_push($carritoToSend,$objetoItemCarritoToSend);
    }

    // Buscando al usuario para verificar si puede comprar o no
    $currentUser = Usuario::find(currentUser_id());

    // Render a la vista 
    $router->render('client/carrito/miCarrito', 
      [
        'titulo' => 'Carrito',
        'alertas' => $alertas,
        'carrito' => $carritoToSend,
        'user' => $currentUser,
        'userCanBuy' => $currentUser->userCanBuy(),
        'userWereRegistering' => $userWereRegistering,
        'userHasBeenRegistered' => $userHasBeenRegistered
      ]
    );
  }

  // Cotizaciones
  public static function cotizaciones(Router $router) {
   
    if(!is_cliente()) {
      header('Location: /');
    };

    $alertas = [];
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      if(isset($_POST['action']) && $_POST['action'] == 'addToCarrito'){
        $carrito = getCarrito();
        
        $objetoCarrito = (object)[];
        $objetoCarrito->isCotizacion = true;
        $objetoCarrito->solicitud = $_POST['solicitud'];
        $objetoCarrito->respuesta = $_POST['respuesta'];
        $objetoCarrito->monto_final = $_POST['monto_final'];
        $objetoCarrito->categoria = Categoria::where('nombre','Cotizacion');
        $objetoCarrito->producto = Producto::where('id_categoria',$objetoCarrito->categoria->id);
        $objetoCarrito->item_id = $_POST['item_id'];

        // debuguear($objetoCarrito);
       
        array_push($carrito,$objetoCarrito);
                
        setCarrito($carrito);

        Cotizacion::setAlerta('success', '¡Cotizacion añadida al Carrito!');
        
      }else if(isset($_POST['action']) && $_POST['action'] == 'deleteCotizacion'){
        $resultado = Cotizacion::eliminarById($_POST['id']);
        if($resultado){
          Cotizacion::setAlerta('success', '¡Cotización eliminada exitosamente!');
        }else{
          Cotizacion::setAlerta('error', 'Ocurrio un error al intentar borrar la cotización, intentalo mas tarde.');
        }
      }
    }
    
    $alertas = Cotizacion::getAlertas();

    // Render a la vista 
    $router->render('client/cotizaciones/misCotizaciones', 
      [
        'alertas' => $alertas,
        'cotizaciones' => Cotizacion::findAll('id_usuario', currentUser_id())
      ]
    );
  }

  // Vista para los servicios comprados por el cliente
  public static function servicios(Router $router) {

    if(!is_cliente()) {
      header('location: /');
    }

    $alertas = [];

    $proyectos = Proyecto::findAll('id_usuario', currentUser_Id());

    foreach($proyectos as $i=>$proyecto){
      $proyectos[$i]->categoria = Categoria::find($proyecto->id_categoria);
      $proyectos[$i]->estado = $proyecto->getEstadoProyecto();
      $proyectos[$i]->usuario = Usuario::find($proyecto->id_usuario);
    }

    // Render a la vista 
    $router->render('client/servicios/servicios', 
      [
        'routeName' => 'Perfil',
        'alertas' => $alertas,
        'proyectos' => $proyectos
      ]
    );
  }

}
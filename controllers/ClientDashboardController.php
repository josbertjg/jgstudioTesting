<?php

namespace Controllers;

use Model\Usuario;
use Model\Producto;
use Model\Categoria;
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
      $carrito = getCarrito();
      
      $firstProducto = json_decode($_POST[array_key_first($_POST)]);
      $categoria = (object)[];
      $categoria->id = $firstProducto->id_categoria;
      $categoria->nombre = $firstProducto->nombre_categoria;

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
        // setcookie('carrito',json_encode());
        // header('location: /dashboard');
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

  public static function miCarrito(Router $router) {
    if(!is_cliente()) {
      header('location: /');
    }
    
    $alertas = [];
    $carrito = getCarrito();
    $carritoToSend = [];
    $allCategorias = Categoria::all();
    $allProductos = Producto::all();
    $acum = 0;
    $userWereRegistering = false;
    $userHasBeenRegistered = false;

    // Armando la info del carrito para mandar al front
    foreach($carrito as $itemCarrito){
      $acum = 0;
      $objetoItemCarritoToSend = (object)[];
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
      array_push($carritoToSend,$objetoItemCarritoToSend);
    }

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
            /* ANGI esta variable "$_POST['carrito']" contiene lo que estas recibiendo del carrito de compra, debes hacerle el json_decode para trabajar con ella, aca esta todo, incluidos precios, pero para asegurarnos podrias recorrer este arreglo y actualizar los precios de los productos,
             aqui tienes un ejemplo de como te va a llegar la respuesta, un array de objetos:
             array(1) {
              [0]=>
              object(stdClass)#33 (4) {
                ["item_id"]=>
                string(13) "64f2871b1e025"
                ["categoria"]=>
                object(stdClass)#32 (3) {
                  ["id"]=>
                  string(1) "3"
                  ["nombre"]=>
                  string(14) "Redes Sociales"
                  ["estado"]=>
                  string(1) "1"
                }
                ["productos"]=>
                array(1) {
                  [0]=>
                  object(stdClass)#30 (10) {
                    ["id"]=>
                    string(1) "4"
                    ["nombre"]=>
                    string(20) "Gestion de Instagram"
                    ["descripcion"]=>
                    string(56) "Gestion de instagram, publicacion, estrategias, hashtags"
                    ["id_categoria"]=>
                    string(1) "3"
                    ["precio_unitario"]=>
                    string(5) "80.00"
                    ["estado"]=>
                    string(1) "1"
                    ["fecha_creacion"]=>
                    string(19) "2023-08-24 16:32:48"
                    ["fecha_modificacion"]=>
                    string(19) "0000-00-00 00:00:00"
                    ["cantidad_maxima"]=>
                    string(1) "1"
                    ["cantidad_producto"]=>
                    int(1)
                  }
                }
                ["total"]=>
                int(80)
              }
            }
            */
            json_decode($_POST['carrito']);
            //Aqui en esta parte del codigo es donde debemos registrar el pago y registrar el contrato y contrato item, ya cuando el administrador
            //Confirme el pago el status del contrato debe cambiar
            //El administrador debe tener una seccion de pagos en su sidebar (revisa views/templates/admin-sidebar.php)
            //Y por supuesto debe ver todos los pagos que aun estan pendientes
          break;
        }
      }
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

}
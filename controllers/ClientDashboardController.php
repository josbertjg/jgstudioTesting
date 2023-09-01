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
      $carrito = [];
      if(empty($_COOKIE['carrito'])){
        setcookie('carrito',json_encode($carrito));
      }else{
        $carrito = json_decode($_COOKIE['carrito']);
      }

      
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
        setcookie('carrito',json_encode($carrito));
        header('location: /dashboard');
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

}
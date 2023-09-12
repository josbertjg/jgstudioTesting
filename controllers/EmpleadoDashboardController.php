<?php

namespace Controllers;

use Model\Usuario;
use Model\Categoria;
use Model\Producto;
use Model\Contrato;
use Model\ContratoProducto;
use Model\Proyecto;
use Model\UsuarioProyecto;
use MVC\Router;
use Model\UploadImage;

class EmpleadoDashboardController {

// Vista de los proyectos del empleado
public static function misProyectos(Router $router) {

  if(!is_empleado()) {
    header('Location: /');
  };

  $alertas = [];

  if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $proyecto = Proyecto::find($_POST['id_proyecto']);
    $proyecto->finalizar();
    $resultado = $proyecto->guardar();
    if($resultado){
      Proyecto::setAlerta('success', 'Proyecto Culminado Exitosamente.');
      $alertas = Proyecto::getAlertas();
    }else{
      Proyecto::setAlerta('error', 'Ocurrio un error al intentar culminar el proyecto, intentalo mas tarde..');
      $alertas = Proyecto::getAlertas();
    }
  }

  $usuarios = UsuarioProyecto::findAll('id_usuario',currentUser_Id());

  $proyectos = [];

  if(!empty($usuarios)){

    foreach($usuarios as $usuario){
      $proyectos = array_merge($proyectos, Proyecto::getProyectosToEmpleado($usuario->id_proyecto));
    }
  
    if(!empty($proyectos)){
      foreach($proyectos as $i=>$proyecto){
        $usuariosProyecto = UsuarioProyecto::findAll('id_proyecto',$proyecto->id);
        $productosProyecto = ContratoProducto::findAll('id_proyecto',$proyecto->id);

        $proyectos[$i]->estado = $proyecto->getEstadoProyecto();
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
    
    }
  }

  // Render a la vista 
  $router->render('empleado/proyectos/proyectos', 
    [
      'alertas' => $alertas,
      'proyectos' => $proyectos,
    ]
  );
}
}

?>
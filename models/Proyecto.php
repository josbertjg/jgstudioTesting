<?php

namespace Model;

class Proyecto extends ActiveRecord {
  protected static $tabla = 'proyecto';
  protected static $columnasDB = ['id', 'id_estado_proyecto', 'id_contrato','id_categoria','id_usuario', 'nombre', 'detalles','fecha'];
  
  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->id_estado_proyecto = $args['id_estado_proyecto'] ?? 1;
    $this->id_contrato = $args['id_contrato'] ?? null;
    $this->id_categoria = $args['id_categoria'] ?? null;
    $this->id_usuario = $args['id_usuario'] ?? null;
    $this->nombre = $args['nombre'] ?? '';
    $this->detalles = $args['detalles'] ?? '';
    $this->fecha = $args['fecha'] ?? date('Y-m-d H:i:s');
  }

  // Registrar un proyecto en la bd
  public function registrar_proyecto(){
    // Sanitizar los datos
    $atributos = $this->sanitizarAtributos();
    
    // Insertar en la base de datos
    $query = " INSERT INTO " . static::$tabla . " ( ";
    $query .= join(', ', array_keys($atributos));
    $query .= " ) VALUES ('"; 
    $query .= join("', '", array_values($atributos));
    $query .= "') ";

    //debuguear($query); // Descomentar si no te funciona algo

    // Resultado de la consulta
    $resultado = self::$db->query($query);

    //debuguear($resultado); // Descomentar para ver el resultado obtenido 
    return [
        'resultado' =>  $resultado,
        'id' => self::$db->insert_id
    ];
  }
  // Rechazar proyecto
  public function rechazar(){
    $this->id_estado_proyecto = 3;
  }
  // Cambiar a por hacer
  public function setPorHacer(){
    $this->id_estado_proyecto = 4;
  }
  // Cambiar a en curso
  public function setEnCurso(){
    $this->id_estado_proyecto = 5;
  }
  // Cambiar a finalizado
  public function finalizar(){
    $this->id_estado_proyecto = 9;
  }
  // Obteniendo los proyectos que estan por hacer
  public static function getPorHacer(){
    return self::findAll('id_estado_proyecto', 4);
  }
  // Obteniendo los proyectos que estan por hacer
  public function getEstadoProyecto(){
    switch($this->id_estado_proyecto){
      case 1: return 'Registrado';
      case 3: return 'Rechazado';
      case 4: return 'Por Hacer';
      case 5: return 'En Curso';
      case 9: return 'Finalizado';
      default: return 'Otro';
    }
  }
  // Obteniendo los proyecto para los empleados
  public static function getProyectosToEmpleado($id){
    $query = "SELECT * FROM " . static::$tabla . " WHERE id = '${id}' AND id_estado_proyecto = '5'";
    return self::consultarSQL($query);
}
}
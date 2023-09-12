<?php

namespace Model;

class ContratoProducto extends ActiveRecord {
  protected static $tabla = 'contrato_producto';
  protected static $columnasDB = ['id','id_contrato','id_producto','id_proyecto','precio_unitario','cantidad','precio_total','id_categoria'];
  
  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->id_contrato = $args['id_contrato'] ?? 1;
    $this->id_producto = $args['id_producto'] ?? '';
    $this->id_proyecto = $args['id_proyecto'] ?? '';
    $this->precio_unitario = $args['precio_unitario'] ?? '';
    $this->cantidad = $args['cantidad'] ?? '';
    $this->precio_total = $args['precio_total'] ?? '';
    $this->id_categoria = $args['id_categoria'] ?? 0;
  }

  // Guardando el Contrato Producto
  public function registrar_contratoProducto(){
    // Sanitizar los datos
    $atributos = $this->sanitizarAtributos();
    
    // Insertar en la base de datos
    $query = " INSERT INTO " . static::$tabla . " ( ";
    $query .= join(', ', array_keys($atributos));
    $query .= " ) VALUES ('"; 
    $query .= join("', '", array_values($atributos));
    $query .= "') ";

    // debuguear($query); // Descomentar si no te funciona algo

    // Resultado de la consulta
    $resultado = self::$db->query($query);

    //debuguear($resultado); // Descomentar para ver el resultado obtenido 
    return [
      'resultado' =>  $resultado,
      'id' => self::$db->insert_id
    ];
  }
}
<?php

namespace Model;

class ContratoProducto extends ActiveRecord {
    protected static $tabla = 'contrato_producto';
    protected static $columnasDB = ['id','id_contrato','precio_unitario','cantidad','precio_total','detalles','id_categoria'];
    
    public function __construct($args = [])
    {
      $this->id = $args['id'] ?? null;
      $this->id_contrato = $args['id_contrato'] ?? 1;
      $this->precio_unitario = $args['precio_unitario'] ?? '';
      $this->cantidad = $args['cantidad'] ?? '';
      $this->precio_total = $args['precio_total'] ?? '';
      $this->detalles = $args['detalles'] ?? '';
      $this->id_categoria = $args['id_categoria'] ?? 0;
    }

    // Validación para categorias nuevas
    public function validar_cuenta() {
      if(!trim($this->nombre)) {
        self::$alertas['error'][] = 'El nombre de la categoría es Obligatorio';
      }
      return self::$alertas;
    }
}
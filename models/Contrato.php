<?php

namespace Model;

class Contrato extends ActiveRecord {
    protected static $tabla = 'contrato';
    protected static $columnasDB = ['id', 'id_usuario', 'estado','fecha_inicio','fecha_compra','fecha_culminacion','cantidad_cuota','monto','monto_total','decontado','id_cupon'];
    
    public function __construct($args = [])
    {
      $this->id = $args['id'] ?? null;
      $this->id_usuario = $args['id_usuario'] ?? null;
      $this->estado = $args['estado'] ?? 1;
      $this->fecha_inicio = $args['fecha_inicio'] ?? date('Y-m-d H:i:s');
      $this->fecha_compra = $args['fecha_compra'] ?? date('Y-m-d H:i:s');
      $this->fecha_culminacion = $args['fecha_culminacion'] ?? date('Y-m-d H:i:s');
      $this->cantidad_cuota = $args['cantidad_cuota'] ?? 0;
      $this->monto = $args['monto'] ?? 1;
      $this->monto_total = $args['monto_total'] ?? '';
      $this->decontado = $args['decontado'] ?? '';
      $this->id_cupon = $args['id_cupon'] ?? 1;
    }

  // Validación para categorias nuevas
  public function validar_cuenta() {
    if(!trim($this->nombre)) {
      self::$alertas['error'][] = 'El nombre de la categoría es Obligatorio';
    }
    return self::$alertas;
  }
  // Aprobar un pago
  public function aprobar(){
    $this->estado = 2;
  }

  // Rechazar un pago
  public function rechazar(){
    $this->estado = 3;
  }
}
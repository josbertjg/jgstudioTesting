<?php

namespace Model;

class UsuarioProyecto extends ActiveRecord {
  protected static $tabla = 'usuario_proyecto';
  protected static $columnasDB = ['id', 'id_usuario', 'id_proyecto'];
  
  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->id_usuario = $args['id_usuario'] ?? null;
    $this->id_proyecto = $args['id_proyecto'] ?? null;
  }

}
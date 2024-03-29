<?php

namespace Model;

class Categoria extends ActiveRecord {
    protected static $tabla = 'categoria';
    protected static $columnasDB = ['id', 'nombre', 'estado','imagen'];
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->estado = $args['estado'] ?? 1;
        $this->imagen = $args['imagen'] ?? '';
        //TODO AGREGAR EN DB
        //$this->fecha_modif = $args['fecha_modif'] ?? '';
        //$this->fecha_creacion = $args['fecha_creacion'] ?? '';
    }

    // Validación para categorias nuevas
    public function validar_cuenta() {
        if(!trim($this->nombre)) {
            self::$alertas['error'][] = 'El nombre de la categoría es Obligatorio';
        }
        return self::$alertas;
    }

    //TODO VALIDAR QUE NO SE DUPLIQUE EL NOMBRE
    // Validación para registro de categorías (solo admin)
    public function validar_insercion() {
        if(!trim($this->nombre)) {
            self::$alertas['error'][] = 'El nombre de la categoría es Obligatorio';
        }
        return self::$alertas;
    }

    //TODO VALIDAR QUE NO SE DUPLIQUE EL NOMBRE
    // Validación para editar
    public function validar_edicion() {
        if(!trim($this->nombre)) {
            self::$alertas['error'][] = 'El nombre de la categoría es Obligatorio';
        }
        return self::$alertas;
    }
}
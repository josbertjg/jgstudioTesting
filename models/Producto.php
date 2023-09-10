<?php

namespace Model;

class Producto extends ActiveRecord {
    protected static $tabla = 'producto';
    protected static $columnasDB = ['id','nombre','descripcion','id_categoria','precio_unitario','estado','fecha_creacion','fecha_modificacion','cantidad_maxima'];
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->id_categoria = $args['id_categoria'] ?? '';
        $this->precio_unitario = $args['precio_unitario'] ?? '';
        $this->estado = $args['estado'] ?? 1;
        $this->fecha_creacion = $args['fecha_creacion'] ?? date('Y-m-d H:i:s');
        $this->fecha_modificacion = $args['fecha_modificacion'] ?? date('Y-m-d H:i:s');
        $this->cantidad_maxima = $args['cantidad_maxima'] ?? 0;
    }

    // Validación para productos nuevos
    public function validar_servicio() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre del servicio es obligatorio';
        }
        if(!$this->descripcion) {
            self::$alertas['error'][] = 'La descripcion del servicio es obligatoria';
        }
        if(!$this->id_categoria) {
            self::$alertas['error'][] = 'La categoría es obligatoria';
        }
        if(!$this->precio_unitario) {
            self::$alertas['error'][] = 'El precio unitario es obligatorio';
        }
        if(strlen($this->clave) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    // Validación para la edicion de productos
    public function validar_edicion() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre del servicio es obligatorio';
        }
        if(!$this->descripcion) {
            self::$alertas['error'][] = 'La descripcion del servicio es obligatoria';
        }
        if(!$this->id_categoria) {
            self::$alertas['error'][] = 'La categoría es obligatoria';
        }
        if(!$this->precio_unitario) {
            self::$alertas['error'][] = 'El precio unitario es obligatorio';
        }
        if(strlen($this->clave) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }
    }

    // Validación para registro de productos por parte del admin
    public function validar_insercion() {

        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->descripcion) {
            self::$alertas['error'][] = 'La descripcion es Obligatorio';
        }
        if(!$this->id_categoria) {
            self::$alertas['error'][] = 'La categoria es Obligatorio';
        }
        if(!$this->precio_unitario) {
            self::$alertas['error'][] = 'El precio unitario es obligatorio';
        }
        return self::$alertas;
    }    

}
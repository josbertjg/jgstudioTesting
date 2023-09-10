<?php

namespace Model;

class Banco extends ActiveRecord {
    protected static $tabla = 'banco';
    protected static $columnasDB = ['id', 'nombre', 'estado','imagen','codigo'];
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->estado = $args['estado'] ?? 1;
        $this->imagen = $args['imagen'] ?? '';
        $this->codigo = $args['codigo'] ?? '';

        //TODO AGREGAR EN DB
        //$this->fecha_modif = $args['fecha_modif'] ?? '';
        //$this->fecha_creacion = $args['fecha_creacion'] ?? '';
    }

    // Validación para categorias nuevas
    public function validar_cuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre del banco es obligatorio';
        }
        if(!$this->codigo) {
            self::$alertas['error'][] = 'El código del banco es obligatorio';
        }
        return self::$alertas;
    }

    //TODO VALIDAR QUE NO SE DUPLIQUE EL NOMBRE
    // Validación para registro de categorías (solo admin)
    public function validar_insercion() {

        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre del banco es obligatorio';
        }
        if(!$this->codigo) {
            self::$alertas['error'][] = 'El código del banco es obligatorio';
        }
        return self::$alertas;
    }

    //TODO VALIDAR QUE NO SE DUPLIQUE EL NOMBRE
    // Validación para editar
    public function validar_edicion() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre del banco es obligatorio';
        }
        if(!$this->codigo) {
            self::$alertas['error'][] = 'El código del banco es obligatorio';
        }
        return self::$alertas;
    }
}
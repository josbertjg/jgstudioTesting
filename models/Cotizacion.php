<?php

namespace Model;

class Cotizacion extends ActiveRecord {
    protected static $tabla = 'cotizacion';
    protected static $columnasDB = ['id', 'id_usuario','estado','monto_final','decontado','id_cupon','solicitud','respuesta','fecha'];
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_usuario = $args['id_usuario'] ?? null;
        $this->estado = $args['estado'] ?? 1;
        $this->monto_final = $args['monto_final'] ?? 0;
        $this->decontado = $args['decontado'] ?? 0;
        $this->id_cupon = $args['id_cupon'] ?? null;
        $this->solicitud = $args['solicitud'] ?? '';
        $this->respuesta = $args['respuesta'] ?? '';
        $this->fecha = $args['fecha'] ?? date('Y-m-d H:i:s');
    }

    // Validar el envio de la cotizacion por parte del cliente
    public function validate_insert_byClient() {
        if(!trim($this->solicitud)) {
            self::$alertas['error'][] = 'El mensaje es obligatorio.';
        }
        return self::$alertas;
    }
    // Validando la aprobacion de la cotizacion
    public function validarAprobacion(){
        if(!trim($this->respuesta)) {
            self::$alertas['error'][] = 'La respuesta es obligatoria.';
        }
        if(!trim($this->monto_final)) {
            self::$alertas['error'][] = 'El monto es obligatorio.';
        }
        if(!$this->monto_final>0) {
            self::$alertas['error'][] = 'El monto debe ser mayor a 0.';
        }
        return self::$alertas;
    }
    // Validando el rechazo de la cotizacion
    public function validarRechazo(){
        if(!trim($this->respuesta)) {
            self::$alertas['error'][] = 'El motivo es obligatorio.';
        }
        return self::$alertas;
    }
    // Obteniendo las cotizaciones que estan pendientes
    public static function getPendientes(){
        return self::findAll('estado', 1);
    }
    // Obteniendo las cotizaciones que han sido completadas
    public static function getCompletadas(){
        $query = "SELECT * FROM " . static::$tabla . " WHERE estado >= '2'";
        return self::consultarSQL($query);
    }
}
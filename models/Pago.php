<?php

namespace Model;

class Pago extends ActiveRecord {
  protected static $tabla = 'pago';
  protected static $columnasDB = ['id', 'id_contrato', 'id_banco','referencia','fecha_pago','fecha_actualizacion','monto','estado_pago','correo','numero_documento','comprobante','id_tipo_pago'];
  
  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->id_contrato = $args['id_contrato'] ?? null;
    $this->id_banco = $args['id_banco'] ?? 1;
    $this->referencia = $args['referencia'] ?? '';
    $this->fecha_pago = $args['fecha_pago'] ?? date('Y-m-d H:i:s');
    $this->fecha_actualizacion = $args['fecha_actualzacion'] ?? date('Y-m-d H:i:s');
    $this->monto = $args['monto'] ?? 0;
    $this->estado_pago = $args['estado_pago'] ?? 1;
    $this->correo = $args['correo'] ?? '';
    $this->numero_documento = $args['numero_documento'] ?? '';
    $this->comprobante = $args['comprobante'] ?? '';
    $this->id_tipo_pago = $args['id_tipo_pago'] ?? 1;
  }

  // Validación para categorias nuevas
  public function validar_transferencia() {
    if(!trim($this->referencia)) {
      self::$alertas['error'][] = 'Debe insertar el número de referencia.';
    }
    if(!trim($this->numero_documento)) {
      self::$alertas['error'][] = 'Debe ingresar el número de documento usado en la transferencia.';
    }
    if(!$this->comprobante) {
      self::$alertas['error'][] = 'Debe añadir un comprobante de pago (Imagen)';
    }
    return self::$alertas;
  }

  public function registrar_pago(){
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
}
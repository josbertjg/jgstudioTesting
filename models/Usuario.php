<?php

namespace Model;

class Usuario extends ActiveRecord {
    protected static $tabla = 'usuario';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'alias', 'avatar', 'direccion', 'telefono_celular', 'telefono_fijo','correo', 'clave','numero_documento', 'id_tipo_documento','id_pais', 'id_estado','id_ciudad', 'id_rol','estado', 'fecha_modif','fecha_creacion'];
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->alias = $args['alias'] ?? '';
        $this->avatar = $args['avatar'] ?? '';
        $this->direccion = $args['direccion'] ?? '';
        $this->telefono_celular = $args['telefono_celular'] ?? '';
        $this->telefono_fijo = $args['telefono_fijo'] ?? '';
        $this->correo = $args['correo'] ?? '';
        $this->clave = $args['clave'] ?? '';
        $this->numero_documento = $args['numero_documento'] ?? 1;
        $this->id_tipo_documento = $args['id_tipo_documento'] ?? 1;
        $this->id_pais = $args['id_pais'] ?? 1;
        $this->id_estado = $args['id_estado'] ?? 1;
        $this->id_ciudad = $args['id_ciudad'] ?? 1;
        $this->id_rol = $args['id_rol'] ?? 5;
        $this->estado = $args['estado'] ?? 1;
        $this->fecha_modif = $args['fecha_modif'] ?? '';
        $this->fecha_creacion = $args['fecha_creacion'] ?? '';
    }

    // Validar el Login de Usuarios
    public function validarLogin() {
        if(!$this->correo) {
            self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
        }
        if(!filter_var($this->correo, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        if(!$this->clave) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        return self::$alertas;
    }

    // Validación para cuentas nuevas
    public function validar_cuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido es Obligatorio';
        }
        if(!$this->correo) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if(!filter_var($this->correo, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        if(!$this->clave) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        if(strlen($this->clave) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    //Validando que el usuario pueda comprar o no
    public function userCanBuy(): bool {

        if(!$this->direccion) {
            return false;
        }
        if(!$this->telefono_celular) {
            return false;
        }
        if(!$this->telefono_fijo) {
            return false;
        }
        if(!$this->numero_documento) {
            return false;
        }
        if(!$this->id_tipo_documento) {
            return false;
        }
        if(!$this->id_pais) {
            return false;
        }
        if(!$this->id_estado) {
            return false;
        }
        if(!$this->id_ciudad) {
            return false;
        }

        return true;
    }

    // Validación para registro de usuarios por parte del admin
    public function validar_insercion() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido es Obligatorio';
        }
        if(!$this->correo) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if(!filter_var($this->correo, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        if(!$this->clave) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        if(strlen($this->clave) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        if(!$this->numero_documento) {
            self::$alertas['error'][] = 'El Número de documento no puede estar vacío';
        }
        if(strlen($this->numero_documento) < 6) {
            self::$alertas['error'][] = 'El número de documento no puede contener menos de 6 dígitos';
        }
        if(!$this->direccion) {
            self::$alertas['error'][] = 'La dirección no puede estar vacía';
        }
        if(!$this->id_pais) {
            self::$alertas['error'][] = 'El país no puede estar vacío';
        }
        return self::$alertas;
    }

    // Validación para la edicion de usuarios
    public function validar_edicion() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido es Obligatorio';
        }
        if(isset($this->correo) && !filter_var($this->correo, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        if(!$this->clave) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        if(strlen($this->clave) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        if(!$this->numero_documento) {
            self::$alertas['error'][] = 'El Número de documento no puede estar vacío';
        }
        if(strlen($this->numero_documento) < 6) {
            self::$alertas['error'][] = 'El número de documento no puede contener menos de 6 dígitos';
        }
        if(!$this->direccion) {
            self::$alertas['error'][] = 'La dirección no puede estar vacía';
        }
        if(!$this->telefono_celular) {
            self::$alertas['error'][] = 'El telefono celular no puede estar vacío';
        }
        if(!$this->telefono_fijo) {
            self::$alertas['error'][] = 'El telefono fijo no puede estar vacío';
        }
        if(!$this->id_pais) {
            self::$alertas['error'][] = 'El país no puede estar vacío';
        }
        if(!$this->id_estado) {
            self::$alertas['error'][] = 'El estado no puede estar vacío';
        }
        if(!$this->id_ciudad) {
            self::$alertas['error'][] = 'La ciudad no puede estar vacía';
        }

        return self::$alertas;
    }

    // Valida un email
    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        return self::$alertas;
    }

    // Valida el Password 
    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    public function nuevo_password() : array {
        if(!$this->password_actual) {
            self::$alertas['error'][] = 'El Password Actual no puede ir vacio';
        }
        if(!$this->password_nuevo) {
            self::$alertas['error'][] = 'El Password Nuevo no puede ir vacio';
        }
        if(strlen($this->password_nuevo) < 6) {
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    // Comprobar el password
    public function comprobar_password() : bool {
        return password_verify($this->password_actual, $this->password );
    }

    // Hashea el password
    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generar un Token
    public function crearToken() : void {
        $this->token = uniqid();
    }
}
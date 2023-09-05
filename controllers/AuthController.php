<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class AuthController {
    public static function inicio(Router $router) {
        $router->render('inicio/index', [
            'titulo' => 'Web & Marketing',
            'descripcion' => 'Estudiamos tu nicho y desarrollamos una estrategia de Marketing Digital para crear <b>Posicionamiento</b> a tu imagen y marca, impulsando a la vez tus <b>Ventas</b> y transformando a tus visitantes en tus mejores <b>Clientes.</b>',
            'hasLogin' => true,
            'hasContact' => true,
            'hasSignin' => false
        ]);
    }

    public static function login(Router $router) {
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarLogin();
            
            if(empty($alertas)) {
                // Verificar que el usuario exista
                $usuario = Usuario::where('correo', $usuario->correo);
                if(!$usuario) {
                    Usuario::setAlerta('error', 'El Usuario No Existe en la base de datos');
                } else {
                    // El Usuario existe
                    // $test = password_verify($_POST['clave'], $usuario->clave);
                    // debuguear($_POST['clave']);
                    
                    if( $_POST['clave'] == $usuario->clave ) {
                        // Iniciar la sesión
                        session_start();    
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['apellido'] = $usuario->apellido;
                        $_SESSION['correo'] = $usuario->correo;
                        $_SESSION['id_rol'] = $usuario->id_rol;

                        // cosa a utilizar para usar el boton de redireccion
                        // Redireccion
                        if($usuario->id_rol == 1 || $usuario->id_rol == 2) {
                            header('Location: /admin/dashboard');
                        } else {
                            header('Location: /dashboard');
                        }
                        
                    } else {
                        Usuario::setAlerta('error', 'Password Incorrecto');
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();
        
        // Render a la vista 
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alertas,
            'descripcion' => 'Inicia sesion para conocer todos nuestros <b>Precios</b> y <b>Paquetes</b>, además de que tambien podrás comprar los <b>Productos</b> y <b>Servicios</b> que necesites.',
            'hasLogin' => false,
            'hasContact' => true,
            'hasSignin' => true
        ]);
    }

    public static function logout() {        
        session_start();
        $_SESSION = [];
        header('Location: /');
    }
       
    

    public static function signin(Router $router) {

        $alertas = [];
        $usuario = new Usuario;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);

            // debuguear($usuario);
            $alertas = $usuario->validar_cuenta();

            if(empty($alertas)) {
                $existeUsuario = Usuario::where('correo', $usuario->correo);

                if($existeUsuario) {
                    Usuario::setAlerta('error', 'El Usuario ya esta registrado');
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el password
                    // $usuario->hashPassword();

                    // Eliminar password2
                    // unset($usuario->password2);

                    // Generar el Token
                    // $usuario->crearToken();
                    // Crear un nuevo usuario
                    $resultado =  $usuario->guardar();
                    
                    // debuguear($resultado);

                    // Enviar email
                    // $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    // $email->enviarConfirmacion();
                    


                    if($resultado) {
                        header('Location: /login');
                    }
                }
            }
        }

        // Render a la vista
        $router->render('auth/signin', [
            'titulo' => 'Registrate',
            'usuario' => $usuario, 
            'alertas' => $alertas,
            'descripcion' => 'Registrate y empieza a disfrutar de los <b>Beneficios</b> de nuestros servicios, no pierdas el <b>Tiempo</b> y has que tu imagen sea visible, <b>Profesional</b> y agradable en internet.',
            'hasLogin' => true,
            'hasContact' => true,
            'hasSignin' => false
        ]);
    }

    public static function olvide(Router $router) {
        $alertas = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if(empty($alertas)) {
                // Buscar el usuario
                $usuario = Usuario::where('email', $usuario->email);

                if($usuario && $usuario->confirmado) {

                    // Generar un nuevo token
                    $usuario->crearToken();
                    unset($usuario->password2);

                    // Actualizar el usuario
                    $usuario->guardar();

                    // Enviar el email
                    $email = new Email( $usuario->email, $usuario->nombre, $usuario->token );
                    $email->enviarInstrucciones();


                    // Imprimir la alerta
                    // Usuario::setAlerta('exito', 'Hemos enviado las instrucciones a tu email');

                    $alertas['exito'][] = 'Hemos enviado las instrucciones a tu email';
                } else {
                 
                    // Usuario::setAlerta('error', 'El Usuario no existe o no esta confirmado');

                    $alertas['error'][] = 'El Usuario no existe o no esta confirmado';
                }
            }
        }

        // Muestra la vista
        $router->render('auth/olvide', [
            'titulo' => 'Olvide mi Password',
            'alertas' => $alertas
        ]);
    }

    public static function reestablecer(Router $router) {

        $token = s($_GET['token']);

        $token_valido = true;

        if(!$token) header('Location: /');

        // Identificar el usuario con este token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token No Válido, intenta de nuevo');
            $token_valido = false;
        }


        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Añadir el nuevo password
            $usuario->sincronizar($_POST);

            // Validar el password
            $alertas = $usuario->validarPassword();

            if(empty($alertas)) {
                // Hashear el nuevo password
                $usuario->hashPassword();

                // Eliminar el Token
                $usuario->token = null;

                // Guardar el usuario en la BD
                $resultado = $usuario->guardar();

                // Redireccionar
                if($resultado) {
                    header('Location: /login');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        
        // Muestra la vista
        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer Password',
            'alertas' => $alertas,
            'token_valido' => $token_valido
        ]);
    }

    public static function mensaje(Router $router) {

        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta Creada Exitosamente'
        ]);
    }

    public static function confirmar(Router $router) {
        
        $token = s($_GET['token']);

        if(!$token) header('Location: /');

        // Encontrar al usuario con este token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            // No se encontró un usuario con ese token
            Usuario::setAlerta('error', 'Token No Válido,  la cuenta no se confirmo');
        } else {
            // Confirmar la cuenta
            $usuario->confirmado = 1;
            $usuario->token = '';
            unset($usuario->password2);
            
            // Guardar en la BD
            $usuario->guardar();

            Usuario::setAlerta('exito', 'Cuenta Comprobada exitosamente');
        }

     

        $router->render('auth/confirmar', [
            'titulo' => 'Confirma tu cuenta DevWebcamp',
            'alertas' => Usuario::getAlertas()
        ]);
    }
}
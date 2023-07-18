<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AuthController;

$router = new Router();

// Inicio
$router->get('/', [AuthController::class, 'inicio']);
// $router->post('/', [AuthController::class, 'login']);
// Login
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
// $router->post('/logout', [AuthController::class, 'logout']);

// Crear Cuenta
// $router->get('/registro', [AuthController::class, 'registro']);
// $router->post('/registro', [AuthController::class, 'registro']);

$router->comprobarRutas();
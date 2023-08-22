<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AuthController;
use Controllers\AdminDashboardController;
use Controllers\ClientDashboardController;

$router = new Router();

// Inicio
$router->get('/', [AuthController::class, 'inicio']);
// Login
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
// Registro de cliente
$router->get('/signin', [AuthController::class, 'signin']);
$router->post('/signin', [AuthController::class, 'signin']);
// Dashboard del admin/empleado
$router->get('/admin/dashboard', [AdminDashboardController::class, 'adminDashboard']);
$router->post('/admin/dashboard', [AdminDashboardController::class, 'adminDashboard']);
// CRUD de Usuarios
$router->get('/admin/dashboard/users', [AdminDashboardController::class, 'users']);
$router->post('/admin/dashboard/users', [AdminDashboardController::class, 'users']);
// Detalle del Usuario
$router->get('/admin/dashboard/users/userDetail', [AdminDashboardController::class, 'userDetail']);
$router->post('/admin/dashboard/users/userDetail', [AdminDashboardController::class, 'UserDetail']);
// Dashboard del cliente
$router->get('/dashboard', [ClientDashboardController::class, 'clientDashboard']);
$router->post('/dashboard', [ClientDashboardController::class, 'clientDashboard']);
// CRUD de Servicios
$router->get('/admin/dashboard/services', [ServiceController::class, 'service']);
$router->post('/admin/dashboard/services', [ServiceController::class, 'service']);
// Detalle del servicio
$router->get('/admin/dashboard/services/serviceDetail', [ServiceController::class, 'serviceDetail']);
$router->post('/admin/dashboard/services/serviceDetail', [ServiceController::class, 'serviceDetail']);

$router->comprobarRutas();
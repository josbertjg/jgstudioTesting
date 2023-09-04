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
// Logout
$router->get('/logout', [AuthController::class, 'logout']);
$router->post('/logout', [AuthController::class, 'logout']);

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
$router->post('/admin/dashboard/users/userDetail', [AdminDashboardController::class, 'userDetail']);
// Dashboard del cliente
$router->get('/dashboard', [ClientDashboardController::class, 'clientDashboard']);
$router->post('/dashboard', [ClientDashboardController::class, 'clientDashboard']);
// Detalle del Usuario cliente
$router->get('/client/profile', [ClientDashboardController::class, 'clientProfile']);
$router->post('/client/profile', [ClientDashboardController::class, 'clientProfile']);
// Carrito
$router->get('/dashboard/miCarrito', [ClientDashboardController::class, 'miCarrito']);
$router->post('/dashboard/miCarrito', [ClientDashboardController::class, 'miCarrito']);
// CRUD de Servicios
$router->get('/admin/productos', [AdminDashboardController::class, 'productos']);
$router->post('/admin/productos', [AdminDashboardController::class, 'productos']);
// Detalle del servicio
$router->get('/admin/productos/productoDetail', [AdminDashboardController::class, 'productoDetail']);
$router->post('/admin/productos/productoDetail', [AdminDashboardController::class, 'productoDetail']);
// Lista donfiguración
$router->get('/admin/configuracion', [AdminDashboardController::class, 'configuracionView']);
// Categorias
$router->get('/admin/category', [AdminDashboardController::class, 'category']);
$router->post('/admin/category', [AdminDashboardController::class, 'category']);


$router->comprobarRutas();
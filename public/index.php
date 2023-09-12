<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AuthController;
use Controllers\AdminDashboardController;
use Controllers\ClientDashboardController;
use Controllers\EmpleadoDashboardController;

$router = new Router();

/* AUTH */

// Inicio
$router->get('/', [AuthController::class, 'inicio']);
// Login
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
// Logout
$router->get('/logout', [AuthController::class, 'logout']);
$router->post('/logout', [AuthController::class, 'logout']);

/* ADMIN */

// Registro de cliente
$router->get('/signin', [AuthController::class, 'signin']);
$router->post('/signin', [AuthController::class, 'signin']);
// Dashboard del admin/empleado
$router->get('/admin/dashboard', [AdminDashboardController::class, 'adminDashboard']);
$router->post('/admin/dashboard', [AdminDashboardController::class, 'adminDashboard']);
// CRUD de Usuarios
$router->get('/admin/dashboard/users', [AdminDashboardController::class, 'users']);
$router->post('/admin/dashboard/users', [AdminDashboardController::class, 'users']);
$router->post('/admin/dashboard/userList', [AdminDashboardController::class, 'deleteUser']);
// Detalle del Usuario
$router->get('/admin/dashboard/users/userDetail', [AdminDashboardController::class, 'userDetail']);
$router->post('/admin/dashboard/users/userDetail', [AdminDashboardController::class, 'userDetail']);
// CRUD de Cotizaciones
$router->get('/admin/dashboard/cotizaciones', [AdminDashboardController::class, 'cotizaciones']);
$router->post('/admin/dashboard/cotizaciones', [AdminDashboardController::class, 'cotizaciones']);
// CRUD de Servicios
$router->get('/admin/productos', [AdminDashboardController::class, 'productos']);
$router->post('/admin/productos', [AdminDashboardController::class, 'productos']);
// Detalle del servicio
$router->get('/admin/productos/productoDetail', [AdminDashboardController::class, 'productoDetail']);
$router->post('/admin/productos/productoDetail', [AdminDashboardController::class, 'productoDetail']);
$router->post('/admin/productsList', [AdminDashboardController::class, 'deleteProduct']);
// Lista configuración
$router->get('/admin/configuracion', [AdminDashboardController::class, 'configuracionView']);
// Categorias
$router->get('/admin/category', [AdminDashboardController::class, 'category']);
$router->post('/admin/category', [AdminDashboardController::class, 'category']);
$router->post('/admin/delete', [AdminDashboardController::class, 'deleteCategory']);
// Pagos
$router->get('/admin/dashboard/pagos', [AdminDashboardController::class, 'pagos']);
$router->post('/admin/dashboard/pagos', [AdminDashboardController::class, 'pagos']);
// Proyectos
$router->get('/admin/dashboard/projects', [AdminDashboardController::class, 'proyectos']);
$router->post('/admin/dashboard/projects', [AdminDashboardController::class, 'proyectos']);
// Proyectos Pendientes
$router->get('/admin/dashboard/pendingProjects', [AdminDashboardController::class, 'pendingProyectos']);
$router->post('/admin/dashboard/pendingProjects', [AdminDashboardController::class, 'pendingProyectos']);
// Detalle de las categorias
$router->get('/admin/category/categoryDetail', [AdminDashboardController::class, 'categoryDetail']);
$router->post('/admin/category/categoryDetail', [AdminDashboardController::class, 'categoryDetail']);
// Bancos
$router->get('/admin/banco', [AdminDashboardController::class, 'bank']);
$router->post('/admin/banco', [AdminDashboardController::class, 'bank']);
$router->post('/admin/bancos', [AdminDashboardController::class, 'deleteBank']);
// Detalle de las Bancos
$router->get('/admin/banco/bancoDetalle', [AdminDashboardController::class, 'bankDetail']);
$router->post('/admin/banco/bancoDetalle', [AdminDashboardController::class, 'bankDetail']);

/* EMPLEADO */

// Mis proyectos
$router->get('/admin/dashboard/myProjects', [EmpleadoDashboardController::class, 'misProyectos']);
$router->post('/admin/dashboard/myProjects', [EmpleadoDashboardController::class, 'misProyectos']);

/* CLIENTE */

// Dashboard del cliente
$router->get('/dashboard', [ClientDashboardController::class, 'clientDashboard']);
$router->post('/dashboard', [ClientDashboardController::class, 'clientDashboard']);
// Detalle del Usuario cliente
$router->get('/client/profile', [ClientDashboardController::class, 'clientProfile']);
$router->post('/client/profile', [ClientDashboardController::class, 'clientProfile']);
// Carrito
$router->get('/dashboard/miCarrito', [ClientDashboardController::class, 'miCarrito']);
$router->post('/dashboard/miCarrito', [ClientDashboardController::class, 'miCarrito']);
// Mis Cotizaciones
$router->get('/dashboard/misCotizaciones', [ClientDashboardController::class, 'cotizaciones']);
$router->post('/dashboard/misCotizaciones', [ClientDashboardController::class, 'cotizaciones']);
// Servicios comprados
$router->get('/dashboard/myServices', [ClientDashboardController::class, 'servicios']);
$router->post('/dashboard/myServices', [ClientDashboardController::class, 'servicios']);

$router->comprobarRutas();
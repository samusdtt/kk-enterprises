<?php
declare(strict_types=1);

// Authentication
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

// Dashboard landing
$router->get('/', [DashboardController::class, 'index']);

// Client routes
$router->get('/client/order', [OrderController::class, 'createForm']);
$router->post('/client/order', [OrderController::class, 'createPost']);
$router->get('/client/orders', [OrderController::class, 'history']);
$router->get('/client/invoice', [OrderController::class, 'invoice']);

$router->get('/client/cart', [CartController::class, 'view']);
$router->post('/client/cart/add', [CartController::class, 'add']);
$router->post('/client/cart/update', [CartController::class, 'update']);
$router->post('/client/cart/remove', [CartController::class, 'remove']);

$router->get('/client/profile', [ProfileController::class, 'showClient']);
$router->post('/client/profile', [ProfileController::class, 'updateClient']);
$router->post('/client/change-password', [ProfileController::class, 'changePassword']);

// Staff routes
$router->get('/staff/present-orders', [StaffController::class, 'presentOrders']);
$router->post('/staff/mark-delivered', [StaffController::class, 'markDelivered']);
$router->post('/staff/request-paid', [StaffController::class, 'requestPaid']);
$router->get('/staff/weekly', [StaffController::class, 'weekly']);
$router->get('/staff/profile', [StaffController::class, 'profile']);
$router->post('/staff/profile', [StaffController::class, 'updateProfile']);

// Admin routes
$router->get('/admin/daily-orders', [AdminController::class, 'dailyOrders']);
$router->post('/admin/order-status', [AdminController::class, 'updateOrderStatus']);
$router->get('/admin/clients', [AdminController::class, 'clients']);
$router->get('/admin/client', [AdminController::class, 'clientDetail']);
$router->get('/admin/staff-alignment', [AdminController::class, 'staffAlignment']);
$router->post('/admin/assign-staff', [AdminController::class, 'assignStaff']);
$router->post('/admin/login-hours', [AdminController::class, 'setLoginHoursVisibility']);
$router->get('/admin/accounts', [AdminController::class, 'accounts']);
$router->post('/admin/accounts', [AdminController::class, 'saveAccount']);
$router->get('/admin/jars', [AdminController::class, 'jars']);
$router->post('/admin/jars', [AdminController::class, 'saveJars']);


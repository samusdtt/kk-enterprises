<?php
declare(strict_types=1);

session_start();

// Simple PSR-4 like autoloader for core, controllers, models
spl_autoload_register(function (string $class): void {
    $class = str_replace('\\', '/', $class);
    $paths = [
        __DIR__ . '/../core/' . $class . '.php',
        __DIR__ . '/../controllers/' . $class . '.php',
        __DIR__ . '/../models/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Load database config (creates Database class)
require_once __DIR__ . '/../config/database.php';

// Initialize Router and load app routes
$router = new Router();
require_once __DIR__ . '/../routes.php';

// Dispatch current request
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

// Ensure base path handling if app is not at domain root
$basePath = rtrim(str_replace('index.php', '', $_SERVER['SCRIPT_NAME']), '/');
if ($basePath !== '' && $basePath !== '/') {
    $uri = '/' . ltrim(substr($uri, strlen($basePath)), '/');
}

try {
    $router->dispatch($method, $uri);
} catch (Throwable $e) {
    http_response_code(500);
    echo '<pre style="padding:16px">Application error: ' . htmlspecialchars($e->getMessage()) . "\n\n" . htmlspecialchars($e->getTraceAsString()) . '</pre>';
}


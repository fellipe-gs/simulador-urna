<?php
declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

// Autoload simples (namespace App\ -> app/)
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) return;
    $file = BASE_PATH . '/app/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (is_file($file)) require $file;
});

App\Core\Env::load(BASE_PATH . '/.env');

session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
session_start();

$router = new App\Core\Router();
require BASE_PATH . '/routes/web.php';
$router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

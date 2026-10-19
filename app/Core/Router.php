<?php
namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, string $handler): void  { $this->routes['GET'][$path]  = $handler; }
    public function post(string $path, string $handler): void { $this->routes['POST'][$path] = $handler; }

    public function dispatch(string $method, string $path): void
    {
        $path = rtrim($path, '/') ?: '/';
        $handler = $this->routes[$method][$path] ?? null;
        if (!$handler) {
            http_response_code(404);
            echo 'Página não encontrada.';
            return;
        }
        [$controller, $action] = explode('@', $handler);
        $class = "App\\Controllers\\$controller";
        (new $class())->$action();
    }
}

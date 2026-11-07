<?php
declare(strict_types=1);
namespace BamBam;
class Router{
    private array $routes=[];
    public function add(string $method, string $path, callable $handler):void{
        $formattedPath='/' . rtrim($path, '/');
        $this->routes[strtoupper($method)][$formattedPath]=$handler;
    }
    public function dispatch(string $method, string $uri):void{
        // 1. Extraer el path de la URL recibida
        $path=parse_url($uri, PHP_URL_PATH) ?? '/';
        // 2. Detectar y remover la subcarpeta base (ej. /DAMG/Clientes/BamBam/vrs7.0/public)
        $scriptDir=str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        if($scriptDir !== '/' && str_starts_with($path, $scriptDir)){
            $path=substr($path, strlen($scriptDir));
        }
        // 3. Normalizar el path y buscar la ruta correspondiente
        $path='/' . rtrim($path, '/');
        $method=strtoupper($method);
        // 4. Buscar hendler para la ruta exacta o fallback a 404
        $handler=$this->routes[$method][$path] ?? $this->routes[$method]['/404'] ?? null;

        if($handler === null){
            http_response_code(404);
            echo "404 - Página no encontrada";
            echo '<p>No existe handeler para la ruta: <code>' . htmlspecialchars($path) . '</code></p>';
            return;
        }
        call_user_func($handler);
    }
}
?>
<?php
namespace App;

use App\Alert;

class Router
{
    private $routes;
    private $path;
    private $routeArgs;

    public function __construct()
    {
        $this->routes = (require __DIR__ . '/../Config/routes.php')[strtolower($_SERVER['REQUEST_METHOD'])];
        $this->path = trim($_SERVER['REQUEST_URI'], '/');
        $this->routeArgs = '';
    }

    public function findController(): array
    {
        foreach ($this->routes as $route => $controllerAndAction) {
            $route = trim($route, '/');
            $routeNames = [];
            if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) {
                $routeNames = $matches[1];
            }
            $routeRegex = "~^" . preg_replace_callback('/\{\w+(:([^}]+))?}/', fn($m) => isset($m[2]) ? "({$m[2]})" : '(\w+)', $route) . "$~";
            if (preg_match_all($routeRegex, $this->path, $valueMatches)) {
                $values = [];
                for ($i = 1; $i < count($valueMatches); $i++) {
                    $values[] = $valueMatches[$i][0];
                }
                $this->routeArgs = array_combine($routeNames, $values);
                return $controllerAndAction;
            }
        }
        Alert::setMsg($this->path . ' resource was not found!');
        return [\App\View::class, 'renderHtml'];
    }

    public function run(): void
    {
        $controllerAndAction = $this->findController();
        $controllerName = $controllerAndAction[0];
        $controllerAction = $controllerAndAction[1];
        var_dump($controllerName);
        var_dump($controllerAction);
        $controller = new $controllerName();
        $controller->$controllerAction($this->routeArgs);
    }

}
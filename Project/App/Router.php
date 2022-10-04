<?php
namespace App;

use App\Alert;
use App\Response;

class Router
{
    private array $routes;
    private string $path;
    private array $routeArgs;
    private Response $response;

    public function __construct()
    {
        $this->routes = (require __DIR__ . '/../Config/routes.php')[strtolower($_SERVER['REQUEST_METHOD'])];
        $this->path = trim($_SERVER['REQUEST_URI'], '/');
        $this->response = new Response();
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
        $controller = new $controllerName();
        $controller->$controllerAction($this->routeArgs);
    }

    public function exitWithError(string $msg)
    {
        $this->response->redirect(__DIR__ . '/../Views/404.php');
        echo '<p>' . $msg . '</p>';
    }

}
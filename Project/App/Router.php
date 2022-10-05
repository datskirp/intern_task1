<?php
namespace App;

use App\Alert;
use App\Response;
use App\View;

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

    public function run(): void
    {
        $routeFound = false;
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
                $routeFound = true;
                $this->routeArgs = array_combine($routeNames, $values);
                $controllerName = $controllerAndAction[0];
                $controllerAction = $controllerAndAction[1];
                $controller = new $controllerName();
                $controller->$controllerAction($this->routeArgs);
            }
        }
        if (!$routeFound) {
            $this->response->redirect('/404');
            $this->exitWithError(['Url: ' . $this->path . ' you entered is not found!']);
        }

    }

    public function exitWithError(array $msg = [])
    {
        $this->response->statusCode(404);
        $view = new View(__DIR__ . '/../Views');
        $view->renderHtml('404.php', ['msg' => $msg[0]]);
    }

}
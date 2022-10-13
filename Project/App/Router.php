<?php

namespace App;

class Router
{
    private array $routes;
    private array $requestArgs;
    private Request $request;
    private string $path;

    public function __construct()
    {
        $this->request = new Request();
        $this->routes = (require __DIR__ . '/../Config/routes.php')[$this->request->getMethod()];
        $this->path = trim($this->request->getUri(), '/');
    }

    public function getCallback(): array|false
    {
        foreach ($this->routes as $route => $controllerAndAction) {
            $route = trim($route, '/');
            $routeParams = [];
            if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) {
                $routeParams = $matches[1];
            }
            $routeRegex = '~^' . preg_replace_callback('/\{\w+(:([^}]+))?}/', fn ($m) => isset($m[2]) ? "({$m[2]})" : '(\w+)', $route) . '$~';
            if (preg_match_all($routeRegex, $this->path, $valueMatches)) {
                $values = [];
                for ($i = 1; $i < count($valueMatches); $i++) {
                    $values[] = $valueMatches[$i][0];
                }
                $this->requestArgs = array_combine($routeParams, $values);

                return $controllerAndAction;
            }
        }

        return false;
    }

    public function run(): void
    {
        $callback = $this->getCallback();
        if ($callback !== false) {
            $controllerName = $callback[0];
            $action = $callback[1];
            $controller = new $controllerName();
            $controller->$action($this->requestArgs);
        //TODO return view or response object
        } else {
            $this->exitWithError('This url is not found! - ' . $this->path);
        }
    }



    public function exitWithError(string $msg = ''): void
    {
        $view = new View(__DIR__ . '/../Views');
        $view->renderHtml('404.php', ['msg' => $msg]);
    }
}

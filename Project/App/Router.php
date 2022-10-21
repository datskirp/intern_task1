<?php

namespace App;

class Router
{
    private array $routes;
    private array $requestArgs;
    private $request;
    private string $path;

    public function __construct(Request $request, $routes)
    {
        $this->request = $request;
        $this->routes = $routes[$this->request->getMethod()];
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

                return [$controllerAndAction[0], $controllerAndAction[1], $this->requestArgs];
            }
        }

        return false;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}

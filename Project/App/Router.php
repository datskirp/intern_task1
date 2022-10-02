<?php
namespace App;

class Router
{
    private function getRoute(): string
    {
        return trim($_SERVER['REQUEST_URI'],'/' );
    }
    private function getController(): ?array
    {
        $routes = require __DIR__ . '/../Config/routes.php';
        foreach ($routes as $pattern => $controllerAndAction) {
            preg_match($pattern, $this->getRoute(), $matches);
            if (!empty($matches)) {
                return [
                    'controller' => $controllerAndAction[0],
                    'action' => $controllerAndAction[1],
                    'args' => $matches[1] ?? '',
                ];
            }
        }
        return null;
    }

    public function runController(): void
    {
        $handler = $this->getController();
        if (!is_null($handler)) {
            $controller = new $handler['controller']();
            $action = $handler['action'];
            $args = $handler['args'];
            $args ? $controller->$action($args) : $controller->$action();
        }
        else {
            echo "Page is not found";
        }
    }
}
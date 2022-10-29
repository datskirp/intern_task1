<?php

namespace App;

class App
{
    public function run(): string
    {
        $container = require ROOT . '/App/Container.php';

        $router = $container->get(Router::class);
        $middleware = $container->get(\App\Services\Middleware::class);
        $callback = $router->getCallback();
        if ($callback) {
            // middleware check
            if (!empty($callback['middleware'])) {
                foreach ($callback['middleware'] as $method) {
                    $result = $middleware->$method();
                    if ($result !== true) {
                        return $result;
                    }
                }
            }
            if ($router->request->boolPost()) {
                $callback[2] = $router->request->getData();
            }

            return $container->call([$callback[0], $callback[1]], [$callback[2]]);
        }

        if (preg_match('~^api/v1.*$~', $router->getPath())) {
            $response = new Response();

            return $response->sendError(404);
        }

        return $container->call([View::class, 'renderError'], [404, 'The page you are looking for is not found']);
    }
}

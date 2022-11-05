<?php

namespace App;

use App\Services\Session;
use App\Services\Middleware\Pipeline;

class App
{
    public function run(): string
    {
        $container = require ROOT . '/App/Container.php';
        $session = $container->get(Session::class);
        $router = $container->get(Router::class);

        $callback = $router->getCallback();
        if ($callback) {

            if ($callback['middlewares']) {
                $middlewareObjects = [];
                foreach ($callback['middlewares'] as $middleware) {
                    $middlewareObjects[] = $container->get($middleware);
                }
                //creating middleware handler object
                $pipeline = new Pipeline($middlewareObjects);
                //apply some actions if middleware check didn't pass
                if (!$pipeline->handle($session)) {
                    if ($session->errorView) {
                        return $session->errorView;
                    }

                }

            }

            if ($router->request->boolPost()) {
                $callback[2] = $router->request->getData($callback[2]);
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

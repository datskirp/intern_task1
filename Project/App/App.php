<?php

namespace App;

class App
{
    public function run()
    {
        $container = require ROOT . '/App/Container.php';

        $router = $container->get(Router::class);
        $callback = $router->getCallback();
        if ($callback) {
            echo $container->call([$callback[0], $callback[1]], [$callback[2]]);
        } else {
            if (preg_match('~^api/v1.*$~', $router->getPath())) {
                $response = new Response();
                echo $response->sendError(404);
            } else {
                echo $container->call([View::class, 'renderError'], [404, 'The page you are looking for is not found']);
            }
        }
    }
}

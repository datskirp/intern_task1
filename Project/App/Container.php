<?php

use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions(ROOT . '/Config/container.php');
$container = $containerBuilder->build();

return $container;

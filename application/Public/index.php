<?php
require('../Core/Autoload.php');
require('../Config/Routes/Routes.php');

define('ROOT', '..'.DIRECTORY_SEPARATOR);

$autoLoader = new \Core\AutoLoad();
$autoLoader->register();

$kernel = new \Core\Kernel();

$request = $kernel->init($routes);

$response = $kernel->buildResponse($request);
$response->send();
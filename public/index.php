<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;

# ----------------------------------------------------------------------- #
# SETTINGS-RELATED

$routes = require_once dirname(__DIR__) . '/config/routes.php';

/** @var \Psr\Container\ContainerInterface $diContainer */
$diContainer = require_once dirname(__DIR__) . '/config/dependencies.php';

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

# ----------------------------------------------------------------------- #
# SESSION-RELATED

session_start();

$originalInfo = false;

if (isset($_SESSION['logged'])) {
    $originalInfo = $_SESSION['logged'];
    unset($_SESSION['logged']);
}

session_regenerate_id();

$_SESSION['logged'] = $originalInfo;

if ($_SESSION['logged'] === false and $pathInfo !== '/login') {
    header('Location: /login');
    return;
}

# ----------------------------------------------------------------------- #
# CONTROLLER INSTANTIATION

$controllerClass = $routes["$httpMethod|$pathInfo"] ?? $routes["fallback"];

$controller = $diContainer->get($controllerClass);

# ----------------------------------------------------------------------- #
# REQUEST INSTANTIATION

$psr17Factory = new Psr17Factory();

$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$request = $creator->fromGlobals();

# ----------------------------------------------------------------------- #
# RESPONSE INSTANTIATION AND SETTING

/** @var JayRods/AluraMvc/Controller/RequestHandlerInterface $controller */
$response = $controller->handle($request);

foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();

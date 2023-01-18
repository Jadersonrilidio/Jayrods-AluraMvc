<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Jayrods\AluraMvc\Repository\RepositoryFactory;

$dbPath = dirname(__DIR__) . '/database/database.sqlite';

$pdo = new PDO("sqlite:" . $dbPath);

$repositoryFactory = new RepositoryFactory($pdo);

$routes = require_once dirname(__DIR__) . '/config/routes.php';

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

session_start();

$originalInfo = false;

if (isset($_SESSION['logged'])) {
    $originalInfo = $_SESSION['logged'];
    unset($_SESSION['logged']);
}

session_regenerate_id();

$_SESSION['logged'] = $originalInfo;

// var_dump(session_id(), $originalInfo, $_SESSION, $_SESSION['logged']); exit;

if ($_SESSION['logged'] === false and $pathInfo !== '/login') {
    header('Location: /login');
    return;
}

$controllerClass = $routes["$httpMethod|$pathInfo"] ?? $routes["fallback"];

$controller = new $controllerClass($repositoryFactory);
$controller->processRequisition();

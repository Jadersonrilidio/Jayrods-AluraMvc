<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Jayrods\AluraMvc\Repository\VideoRepository;

$dbPath = __DIR__ . '/../database/database.sqlite';

$pdo = new PDO("sqlite:" . $dbPath);

$videoRepository = new VideoRepository($pdo);

$routes = require_once __DIR__ . '/../config/routes.php';

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$controllerClass = $routes["$httpMethod|$pathInfo"] ?? $routes["fallback"];

$controller = new $controllerClass($videoRepository);
$controller->processRequisition();

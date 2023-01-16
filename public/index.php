<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Jayrods\AluraMvc\Repository\VideoRepository;
use Jayrods\AluraMvc\Controller\{VideoController, NewVideoController, UpdateVideoController, DeleteVideoController, Error404Controller, FormVideoController};

$dbPath = __DIR__ . '/../database/database.sqlite';

$pdo = new PDO("sqlite:" . $dbPath);

$videoRepository = new VideoRepository($pdo);

if (!array_key_exists('PATH_INFO', $_SERVER) || $_SERVER['PATH_INFO'] === '/') {

    $controller = new VideoController($videoRepository);
} elseif ($_SERVER['PATH_INFO'] === '/novo-video') {

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $controller = new FormVideoController($videoRepository);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $controller = new NewVideoController($videoRepository);
    }
} elseif ($_SERVER['PATH_INFO'] === '/editar-video') {

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $controller = new FormVideoController($videoRepository);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $controller = new UpdateVideoController($videoRepository);
    }
} elseif ($_SERVER['PATH_INFO'] === '/delete-video') {

    $controller = new DeleteVideoController($videoRepository);
} else {

    $controller = new Error404Controller($videoRepository);
}

$controller->processRequisition();

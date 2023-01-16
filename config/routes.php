<?php

declare(strict_types=1);

return [
    'GET|/' => \Jayrods\AluraMvc\Controller\VideoController::class,
    'GET|/novo-video' => \Jayrods\AluraMvc\Controller\FormVideoController::class,
    'POST|/novo-video' => \Jayrods\AluraMvc\Controller\NewVideoController::class,
    'GET|/editar-video' => \Jayrods\AluraMvc\Controller\FormVideoController::class,
    'POST|/editar-video' => \Jayrods\AluraMvc\Controller\UpdateVideoController::class,
    'GET|/delete-video' => \Jayrods\AluraMvc\Controller\DeleteVideoController::class,
    'fallback' => \Jayrods\AluraMvc\Controller\Error404Controller::class
];

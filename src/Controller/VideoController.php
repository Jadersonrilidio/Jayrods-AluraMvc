<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\Controller;
use Jayrods\AluraMvc\Repository\VideoRepository;

class VideoController implements Controller
{
    private VideoRepository $videoRepository;

    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function processRequisition(): void
    {
        $videoslist = $this->videoRepository->all();

        require_once __DIR__ . '/../../resources/views/video-list.php';
    }
}

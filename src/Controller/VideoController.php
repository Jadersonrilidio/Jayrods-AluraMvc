<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\Controller;
use Jayrods\AluraMvc\Repository\RepositoryFactory;
use Jayrods\AluraMvc\Repository\VideoRepository;

class VideoController implements Controller
{
    private VideoRepository $videoRepository;

    public function __construct(RepositoryFactory $repositoryFactory)
    {
        $this->videoRepository = $repositoryFactory->create('Video');
    }

    public function processRequisition(): void
    {
        $videoslist = $this->videoRepository->all();

        require_once dirname(dirname(__DIR__)) . '/resources/views/video-list.php';
    }
}

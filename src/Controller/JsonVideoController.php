<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\Controller;
use Jayrods\AluraMvc\Repository\RepositoryFactory;
use Jayrods\AluraMvc\Repository\VideoRepository;

class JsonVideoController implements Controller
{
    private VideoRepository $videoRepository;

    public function __construct(RepositoryFactory $repositoryFactory)
    {
        $this->videoRepository = $repositoryFactory->create('Video');
    }

    public function processRequisition(): void
    {
        $videosList = array_map(function ($video): array {
            return array(
                'id'    => $video->id(),
                'url'   => $video->url(),
                'title' => $video->title(),
                'image' => $video->filePath() ? '/img/uploads/' . $video->filePath() : null

            );
        }, $this->videoRepository->all());

        header('Content-Type: application/json');
        http_response_code(200);

        echo json_encode($videosList);
    }
}

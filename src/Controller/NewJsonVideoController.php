<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\Controller;
use Jayrods\AluraMvc\Repository\RepositoryFactory;
use Jayrods\AluraMvc\Repository\VideoRepository;
use Jayrods\AluraMvc\Entity\Video;

class NewJsonVideoController implements Controller
{
    private VideoRepository $videoRepository;

    public function __construct(RepositoryFactory $repositoryFactory)
    {
        $this->videoRepository = $repositoryFactory->create('Video');
    }

    public function processRequisition(): void
    {
        $request = file_get_contents('php://input');

        $videoData = json_decode($request, true);

        $video = new Video(null, $videoData['url'], $videoData['title']);

        if (array_key_exists('image', $videoData) and $videoData['image'] !== null) {
            $video->setFilePath($videoData['image']);
        }

        $this->videoRepository->add($video);

        header('Content-Type: application/json');
        http_response_code(201);

        echo json_encode(['message' => 'Video was successfuly created.']);
    }
}

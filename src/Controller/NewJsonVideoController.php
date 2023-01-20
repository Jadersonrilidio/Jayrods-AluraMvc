<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\RequestHandlerInterface;
use Jayrods\AluraMvc\Repository\RepositoryFactory;
use Jayrods\AluraMvc\Repository\VideoRepository;
use Jayrods\AluraMvc\Entity\Video;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;

class NewJsonVideoController implements RequestHandlerInterface
{
    private VideoRepository $videoRepository;

    public function __construct(RepositoryFactory $repositoryFactory)
    {
        $this->videoRepository = $repositoryFactory->create('Video');
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $jsonContent = $request->getBody()->getContents();

        $videoData = json_decode($jsonContent, true);
        // $videoData = $request->getParsedBody(); // more abstractive method, easier to use

        $video = new Video(null, $videoData['url'], $videoData['title']);

        if (array_key_exists('image', $videoData) and $videoData['image'] !== null) {
            $video->setFilePath($videoData['image']);
        }

        $this->videoRepository->add($video);

        return new Response(
            201,
            ['Content-Type' => 'application/json'],
            json_encode(['message' => 'Video was successfuly created.'])
        );
    }
}

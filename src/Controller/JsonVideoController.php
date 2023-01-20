<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\RequestHandlerInterface;
use Jayrods\AluraMvc\Repository\RepositoryFactory;
use Jayrods\AluraMvc\Repository\VideoRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;

class JsonVideoController implements RequestHandlerInterface
{
    private VideoRepository $videoRepository;

    public function __construct(RepositoryFactory $repositoryFactory)
    {
        $this->videoRepository = $repositoryFactory->create('Video');
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $videosList = array_map(function ($video): array {
            return array(
                'id'    => $video->id(),
                'url'   => $video->url(),
                'title' => $video->title(),
                'image' => $video->filePath() ? '/img/uploads/' . $video->filePath() : null

            );
        }, $this->videoRepository->all());

        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode($videosList)
        );
    }
}

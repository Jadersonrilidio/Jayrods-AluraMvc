<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\RequestHandlerInterface;
use Jayrods\AluraMvc\Repository\RepositoryFactory;
use Jayrods\AluraMvc\Repository\VideoRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;
use League\Plates\Engine;

class VideoController implements RequestHandlerInterface
{
    /**
     * 
     */
    private VideoRepository $videoRepository;

    /**
     * 
     */
    private Engine $templates;

    /**
     * 
     */
    public function __construct(RepositoryFactory $repositoryFactory, Engine $templates)
    {
        $this->videoRepository = $repositoryFactory->create('Video');
        $this->templates = $templates;
    }

    /**
     * 
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $videoList = $this->videoRepository->all();


        return new Response(
            200,
            [],
            $this->templates->render('video-list', ['videoList' => $videoList])
        );
    }
}

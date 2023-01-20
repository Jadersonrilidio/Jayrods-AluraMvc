<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\RequestHandlerInterface;
use Jayrods\AluraMvc\Entity\Video;
use Jayrods\AluraMvc\Repository\VideoRepository;
use Jayrods\AluraMvc\Repository\RepositoryFactory;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Nyholm\Psr7\Response;
use League\Plates\Engine;

class FormVideoController implements RequestHandlerInterface
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
        $queryParams = $request->getQueryParams();

        $id = filter_var($queryParams['id'] ?? null, FILTER_VALIDATE_INT);

        $video = new Video(null, '', '');

        if ($id !== false and $id !== null) {
            $video = $this->videoRepository->find($id);
        }

        return new Response(
            200,
            [],
            $this->templates->render('video-form', ['video' => $video])
        );
    }
}

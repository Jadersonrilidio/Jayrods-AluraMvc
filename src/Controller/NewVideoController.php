<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\RequestHandlerInterface;
use Jayrods\AluraMvc\Entity\Video;
use Jayrods\AluraMvc\Repository\VideoRepository;
use Jayrods\AluraMvc\Repository\RepositoryFactory;
use Jayrods\AluraMvc\Controller\Traits\HandleFile;
use Jayrods\AluraMvc\Controller\Traits\FlashMessage;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;

class NewVideoController implements RequestHandlerInterface
{
    use HandleFile,
        FlashMessage;

    /**
     * 
     */
    private VideoRepository $videoRepository;

    /**
     * 
     */
    public function __construct(RepositoryFactory $repositoryFactory)
    {
        $this->videoRepository = $repositoryFactory->create('Video');
    }

    /**
     * 
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $postVars = $request->getParsedBody();

        $url = filter_var($postVars['url'], FILTER_VALIDATE_URL);
        if ($url === false) {
            $this->addErrorMessage('Error: Could not create video. Invalid url');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $title = filter_var($postVars['title']);
        if ($title === false) {
            $this->addErrorMessage('Error: Could not create video. Invalid title');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $video = new Video(null, $url, $title);

        $this->handleFile($video, $request);

        $result = $this->videoRepository->add($video);

        if ($result) {
            $this->addSuccessMessage('New video created');
            return new Response(201, [
                'Location' => '/'
            ]);
        } else {
            $this->addErrorMessage('Error: Could not create video');
            return new Response(302, [
                'Location' => '/'
            ]);
        }
    }
}

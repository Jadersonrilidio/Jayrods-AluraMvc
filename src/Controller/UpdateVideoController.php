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

class UpdateVideoController implements RequestHandlerInterface
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
        $queryParams = $request->getQueryParams();
        $postVars = $request->getParsedBody();

        $url = filter_var($postVars['url'], FILTER_VALIDATE_URL);
        if ($url === false) {
            $this->addErrorMessage('Error: Could not update video. Invalid url');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $title = filter_var($postVars['title']);
        if ($title === false) {
            $this->addErrorMessage('Error: Could not update video. Invalid title');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        if ($id === false or $id === null) {
            $this->addErrorMessage('Error: Could not update video. Video not found');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $video = new Video($id, $url, $title);

        $this->handleFile($video, $request);

        $result = $this->videoRepository->update($video);

        if ($result) {
            $this->addSuccessMessage('Video updated');
            return new Response(200, [
                'Location' => '/'
            ]);
        } else {
            $this->addErrorMessage('Error: Could not update video.');
            return new Response(302, [
                'Location' => '/'
            ]);
        }
    }
}

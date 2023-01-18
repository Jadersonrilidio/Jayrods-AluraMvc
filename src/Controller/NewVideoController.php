<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\Controller;
use Jayrods\AluraMvc\Entity\Video;
use Jayrods\AluraMvc\Repository\VideoRepository;
use Jayrods\AluraMvc\Repository\RepositoryFactory;
use Jayrods\AluraMvc\Controller\Traits\HandleFile;

class NewVideoController implements Controller
{
    use HandleFile;

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
    public function processRequisition(): void
    {
        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if ($url === false) {
            header('Location: /?success=0');
            return;
        }

        $title = filter_input(INPUT_POST, 'title');
        if ($title === false) {
            header('Location: /?success=0');
            return;
        }

        $video = new Video(null, $url, $title);

        $this->handleFile($video);

        $result = $this->videoRepository->add($video);

        $result ? header('Location: /?success=1') : header('Location: /?success=0');
    }
}

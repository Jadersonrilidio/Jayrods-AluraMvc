<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\Controller;
use Jayrods\AluraMvc\Entity\Video;
use Jayrods\AluraMvc\Repository\VideoRepository;

class NewVideoController implements Controller
{
    /**
     * 
     */
    private VideoRepository $videoRepository;

    /**
     * 
     */
    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
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

        $result = $this->videoRepository
            ->add(new Video(null, $url, $title));

        $result ? header('Location: /?success=1') : header('Location: /?success=0');
    }
}

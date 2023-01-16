<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\Controller;
use Jayrods\AluraMvc\Entity\Video;
use Jayrods\AluraMvc\Repository\VideoRepository;

class UpdateVideoController implements Controller
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

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if ($id === false or $id === null) {
            header('Location: /?success=0');
            return;
        }

        $result = $this->videoRepository
            ->update(new Video($id, $url, $title));

        $result ? header('Location: /?success=1') : header('Location: /?success=0');
    }
}

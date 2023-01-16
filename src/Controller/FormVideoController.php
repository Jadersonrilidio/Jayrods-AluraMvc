<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\Controller;
use Jayrods\AluraMvc\Entity\Video;
use Jayrods\AluraMvc\Repository\VideoRepository;

class FormVideoController implements Controller
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
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        $video = new Video(null, '', '');

        if ($id !== false and $id !== null) {
            $video = $this->videoRepository->find($id);
        }

        require_once __DIR__ . '/../../resources/views/video-form.php';
    }
}

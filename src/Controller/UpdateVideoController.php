<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\Controller;
use Jayrods\AluraMvc\Entity\Video;
use Jayrods\AluraMvc\Repository\VideoRepository;
use Jayrods\AluraMvc\Repository\RepositoryFactory;
use Jayrods\AluraMvc\Controller\Traits\HandleFile;

class UpdateVideoController implements Controller
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

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if ($id === false or $id === null) {
            header('Location: /?success=0');
            return;
        }

        $video = new Video($id, $url, $title);

        $this->handleFile($video);

        $result = $this->videoRepository->update($video);

        $result ? header('Location: /?success=1') : header('Location: /?success=0');
    }

    /**
     * 
     */
    private function handleImage(Video &$video, $image): void
    {
        $tmp_name = $_FILES['image']['tmp_name'];
        $path = dirname(dirname(__DIR__)) . '/public/img/uploads/';
        $name = uniqid('upload_');
        $ext = '.jpg';

        move_uploaded_file(
            $tmp_name,
            $path . $name . $ext
        );

        $video->setFilePath($name);
    }
}

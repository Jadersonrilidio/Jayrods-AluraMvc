<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\Controller;
use Jayrods\AluraMvc\Repository\VideoRepository;
use Jayrods\AluraMvc\Repository\RepositoryFactory;

class DeleteImageController implements Controller
{
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
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === false or $id === null) {
            header('Location: /?success=0');
            return;
        }

        $result = $this->videoRepository
            ->removeImage($id);

        $result ? header('Location: /?success=1') : header('Location: /?success=0');
    }
}

<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\Controller;
use Jayrods\AluraMvc\Repository\RepositoryFactory;
use Jayrods\AluraMvc\Repository\UserRepository;

class LogoutController implements Controller
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * 
     */
    public function __construct(RepositoryFactory $repositoryFactory)
    {
        $this->userRepository = $repositoryFactory->create('User');
    }

    /**
     * 
     */
    public function processRequisition(): void
    {
        // session_destroy();
        $_SESSION['logged'] = false;

        unset($_SESSION['logged']);

        header('Location: /login');
    }
}

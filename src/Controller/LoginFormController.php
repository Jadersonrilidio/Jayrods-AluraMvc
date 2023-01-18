<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\Controller;
use Jayrods\AluraMvc\Repository\RepositoryFactory;
use Jayrods\AluraMvc\Repository\UserRepository;

class LoginFormController implements Controller
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
        if (($_SESSION['logged'] ?? false) === true) {
            header('Location: /');
            return;
        }
        require_once dirname(dirname(__DIR__)) . '/resources/views/login.php';
    }
}

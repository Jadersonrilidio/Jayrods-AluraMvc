<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\RequestHandlerInterface;
use Jayrods\AluraMvc\Repository\RepositoryFactory;
use Jayrods\AluraMvc\Repository\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;
use Jayrods\AluraMvc\Controller\Traits\FlashMessage;

class LogoutController implements RequestHandlerInterface
{
    use FlashMessage;

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
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $_SESSION['logged'] = false;

        unset($_SESSION['logged']);

        $this->addSuccessMessage("You're logged out!");
        return new Response(200, [
            'Location' => '/login'
        ]);
    }
}

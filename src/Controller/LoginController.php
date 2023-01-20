<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\RequestHandlerInterface;
use Jayrods\AluraMvc\Controller\Traits\FlashMessage;
use Jayrods\AluraMvc\Repository\UserRepository;
use Jayrods\AluraMvc\Repository\RepositoryFactory;
use Jayrods\AluraMvc\Entity\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;

class LoginController implements RequestHandlerInterface
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
        $postVars = $request->getParsedBody();

        $email = filter_var($postVars['email'], FILTER_VALIDATE_EMAIL);
        $password = filter_var($postVars['password']);

        $user = $this->userRepository->findByEmail($email) ?? new User(null, '', '');

        $validation = password_verify($password, $user->password() ?? '');

        if ($validation and password_needs_rehash($user->password(), PASSWORD_ARGON2ID)) {
            $this->userRepository->passwordRehash($user->id(), $password);
        }

        if ($validation) {
            $this->addSuccessMessage("You're logged in!");
            $_SESSION['logged'] = true;
            return new Response(200, [
                'Location' => '/'
            ]);
        } else {
            $this->addErrorMessage('Error: Invalid login or password');
            return new Response(302, [
                'Location' => '/login'
            ]);
        }
    }
}

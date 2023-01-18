<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\Controller;
use Jayrods\AluraMvc\Repository\UserRepository;
use Jayrods\AluraMvc\Repository\RepositoryFactory;

class LoginController implements Controller
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
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        $user = $this->userRepository->findByEmail($email);

        $validation = password_verify($password, $user->password() ?? '');

        if ($validation and password_needs_rehash($user->password(), PASSWORD_DEFAULT)) {
            $this->userRepository->passwordRehash($user->id(), $password);
        }

        if ($validation) {
            $_SESSION['logged'] = true;
            header('Location: /');
            return;
        } else {
            header('Location: /login?success=0');
        }
    }
}

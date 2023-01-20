<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;
use League\Plates\Engine;

class LoginFormController implements RequestHandlerInterface
{
    /**
     * @var League\Plates\Engine
     */
    private Engine $templates;

    /**
     * 
     */
    public function __construct(Engine $templates)
    {
        $this->templates = $templates;
    }

    /**
     * 
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (($_SESSION['logged'] ?? false) === true) {
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        return new Response(200, [], $this->templates->render('login'));
    }
}

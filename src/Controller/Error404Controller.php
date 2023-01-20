<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;
use League\Plates\Engine;

class Error404Controller implements RequestHandlerInterface
{
    /**
     * 
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
        return new Response(404, [], $this->templates->render('not-found'));
    }
}

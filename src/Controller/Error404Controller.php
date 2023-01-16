<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\Controller;

class Error404Controller implements Controller
{
    /**
     * 
     */
    public function processRequisition(): void
    {
        http_response_code(404);

        require_once __DIR__ . '/../../inicio.php'; ?>

        <main class="container">
            <p style="color:black; font-size:3em; text-align:center">
                <b>404</b>
                <br>
                <br>
                NOT FOUND
            </p>
        </main>

        <?php require_once __DIR__ . '/../../fim.php';
    }
}

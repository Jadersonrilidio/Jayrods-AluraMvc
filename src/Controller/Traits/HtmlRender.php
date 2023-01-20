<?php

namespace Jayrods\AluraMvc\Controller\Traits;

trait HtmlRender
{
    /**
     * 
     */
    private $templatePath = __DIR__ . '/../../../resources/views/';

    /**
     * 
     */
    private $templateExtension = '.php';

    /**
     * 
     */
    private function renderTemplate(string $templateName, array $context = array()): ?string
    {
        extract($context);

        ob_start();

        require_once $this->templatePath . $templateName . $this->templateExtension;

        return ob_get_clean();
    }
}
<?php

namespace Jayrods\AluraMvc\Controller\Traits;

trait FlashMessage
{
    /**
     * 
     */
    private function addErrorMessage(string $errorMessage): void
    {
        $_SESSION['error_message'] = $errorMessage;
    }

    /**
     * 
     */
    private function addSuccessMessage(string $successMessage): void
    {
        $_SESSION['success_message'] = $successMessage;
    }
}
<?php

namespace Jayrods\AluraMvc\Controller\Traits;

use finfo as FileInfo;
use Jayrods\AluraMvc\Entity\Video;

trait HandleFile
{
    /**
     * 
     * @param  Video  &$video
     * 
     * @return bool
     */
    public function handleFile(Video &$video): bool
    {
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $mimeType = (new FileInfo(FILEINFO_MIME_TYPE))->file($_FILES['image']['tmp_name']);

            if (preg_match('/^image\/[a-z]+$/', $mimeType)) {
                $path = dirname(dirname(dirname(__DIR__))) . '/public/img/uploads/';
                $ext = (explode('/', $mimeType))[1];
                $name = uniqid('upload_');

                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    $path . "$name.$ext"
                );

                $video->setFilePath("$name.$ext");

                return true;
            }
        }

        return false;
    }
}

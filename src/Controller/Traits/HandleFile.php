<?php

namespace Jayrods\AluraMvc\Controller\Traits;

use finfo as FileInfo;
use Jayrods\AluraMvc\Entity\Video;
use Psr\Http\Message\ServerRequestInterface;

trait HandleFile
{
    /**
     * 
     * @param  Video  &$video
     * 
     * @return bool
     */
    private function handleFile(Video &$video, ServerRequestInterface $request): bool
    {
        $files = $request->getUploadedFiles();

        /** @var UploadedFileInterface $uploadedFile */
        $uploadedImage = $files['image'];

        if ($uploadedImage->getError() === UPLOAD_ERR_OK) {
            $tmpFile = $uploadedImage->getStream()->getMetadata('uri');
            $mimeType = (new FileInfo(FILEINFO_MIME_TYPE))->file($tmpFile);

            if (preg_match('/^image\/[a-z]+$/', $mimeType)) {
                $path = dirname(dirname(dirname(__DIR__))) . '/public/img/uploads/';
                $ext = (explode('/', $mimeType))[1];
                $safeFileName = uniqid('upload_') . $ext;

                $uploadedImage->moveTo($path . $safeFileName);

                $video->setFilePath($safeFileName);

                return true;
            }
        }

        return false;
    }
}

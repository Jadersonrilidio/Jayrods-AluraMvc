<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\Controller;
use Jayrods\AluraMvc\Repository\VideoRepository;

class VideoController implements Controller
{
    private VideoRepository $videoRepository;

    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function processRequisition(): void
    {
        $videoslist = $this->videoRepository->all();

        require_once __DIR__ . '/../../inicio.php'; ?>

        <ul class="videos__container" alt="videos alura">
            <?php foreach ($videoslist as $video) : ?>
                <li class="videos__item">
                    <iframe width="100%" height="72%" src="<?= $video->url(); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <div class="descricao-video">
                        <img src="./img/logo.png" alt="logo canal alura">
                        <h3><?= $video->title(); ?></h3>
                        <div class="acoes-video">
                            <a href="/editar-video?id=<?= $video->id(); ?>">Editar</a>
                            <a href="/delete-video?id=<?= $video->id(); ?>">Excluir</a>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php require_once __DIR__ . '/../../fim.php';
    }
}

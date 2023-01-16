<?php

namespace Jayrods\AluraMvc\Controller;

use Jayrods\AluraMvc\Controller\Controller;
use Jayrods\AluraMvc\Entity\Video;
use Jayrods\AluraMvc\Repository\VideoRepository;

class NewVideoController implements Controller
{
    /**
     * 
     */
    private VideoRepository $videoRepository;

    /**
     * 
     */
    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    /**
     * 
     */
    public function processRequisition(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        $video = new Video(null, '', '');
        
        if ($id !== false and $id !== null) {
            $video = $this->videoRepository->get($id);
        }

        require_once __DIR__ . '/../../inicio.php'; ?>

        <main class="container">
            <form class="container__formulario" method="POST" action="<?php ($video->id() !== null) ? "/editar-video?id=" . $video->id() : '/novo-video'; ?>">
                <h2 class="formulario__titulo">Edite seu vídeo</h2>
                <div class="formulario__campo">
                    <label class="campo__etiqueta" for="url">Link embed</label>
                    <input name="url" class="campo__escrita" required placeholder="Por exemplo: https://www.youtube.com/embed/FAY1K2aUg5g" id='url' value="<?= $video->url() ?? ''; ?>" />
                </div>
                <div class="formulario__campo">
                    <label class="campo__etiqueta" for="titulo">Titulo do vídeo</label>
                    <input name="title" class="campo__escrita" required placeholder="Neste campo, dê o nome do vídeo" id='title' value="<?= $video->title() ?? ''; ?>" />
                </div>
                <input type="hidden" name="id" value="<?= $video->id() ?? ''; ?>" />
                <input class="formulario__botao" type="submit" value="Enviar" />
            </form>
        </main>

        <?php require_once __DIR__ . '/../../fim.php';
    }

    /**
     * 
     */
    public function addVideo(): void
    {
        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        $title = filter_input(INPUT_POST, 'title');

        if ($url === false) {
            header('Location: /?success=0');
            exit;
        }

        $video = new Video(null, $url, $title);

        $result = $this->videoRepository->add($video);

        $result ? header('Location: /?success=1') : header('Location: /?success=0');
    }
}

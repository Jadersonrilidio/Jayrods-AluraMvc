<?php $this->layout('layout'); ?>

<main class="container">

    <form class="container__formulario" method="POST" enctype="multipart/form-data">

        <h2 class="formulario__titulo">Edite seu vídeo</h2>

        <div class="formulario__campo">
            <label class="campo__etiqueta" for="url">Link embed</label>
            <input name="url" class="campo__escrita" required placeholder="Por exemplo: https://www.youtube.com/embed/FAY1K2aUg5g" id='url' value="<?= $video->url() ?? ''; ?>" />
        </div>

        <div class="formulario__campo">
            <label class="campo__etiqueta" for="title">Titulo do vídeo</label>
            <input name="title" class="campo__escrita" required placeholder="Neste campo, dê o nome do vídeo" id='title' value="<?= $video->title() ?? ''; ?>" />
        </div>

        <div class="formulario__campo">
            <label class="campo__etiqueta" for="image">Upload vídeo</label>
            <input type="file" accept="image/*" name="image" class="campo__escrita" id='image'>
        </div>

        <input type="hidden" name="id" value="<?= $video->id() ?? ''; ?>" />

        <input class="formulario__botao" type="submit" value="Enviar" />

    </form>

</main>

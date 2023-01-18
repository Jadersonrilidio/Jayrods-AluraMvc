<?php require_once __DIR__ . '/inicio.php'; ?>

<ul class="videos__container" alt="videos alura">

    <?php foreach ($videoslist as $video) : ?>
        <li class="videos__item">
            <?php if ($video->filePath() !== null) : ?>
                <a href="<?= $video->url(); ?>">
                    <img src="<?= '/img/uploads/' . $video->filePath(); ?>" alt="image-file" width="100%" height="72%">
                </a>
            <?php else : ?>
                <iframe width="100%" height="72%" src="<?= $video->url(); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <?php endif; ?>

            <div class="descricao-video">
                <img src="./img/logo.png" alt="logo canal alura">
                <h3><?= $video->title(); ?></h3>
                <div class="acoes-video">
                    <a href="/editar-video?id=<?= $video->id(); ?>">Editar</a>
                    <a href="/delete-video?id=<?= $video->id(); ?>">Excluir</a>
                    <a href="/delete-image?id=<?= $video->id(); ?>">Excluir Imagem</a>
                </div>
            </div>

        </li>
    <?php endforeach; ?>



</ul>

<?php require_once __DIR__ . '/fim.php';

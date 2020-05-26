<?php require $_SERVER['DOCUMENT_ROOT'] . "/header.php";
$competition = getDataForGalleryById($_GET['id']); // Запрос к бд по конкретному соревнованию
?>

<section class="gallery">
    <div class="container">

        <div class="row">
            <div class="col">
                <a href="/gallery.php"><h2>Фотогалерея</h2></a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h4><?= $competition->name; ?></h4>
            </div>
        </div>

        <div class="row">
            <?php
                $handle = opendir(dirname(realpath(__FILE__)).$competition->url);
                while ($file = readdir($handle)): ?>
                    <?php if (preg_match("/.[.](jpg|jpeg|png|gif)$/ui", $file)):?>
                        <div class="col-md-6 col-xl-4 justify-content-center d-flex">
                            <a data-fancybox="gallery" href="<?= $competition->url.'/big/'.$file; ?>">
                                <figure class="gallery__figure">
                                    <img class="gallery__img" src="<?= $competition->url.'/'.$file; ?>" alt="Фотография">
                                </figure>
                            </a>
                        </div>
                    <?php endif;?>
                <?php endwhile;
                closedir($handle);
            ?>
        </div>
    </div>
</section>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; ?>

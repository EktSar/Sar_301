<?php require $_SERVER['DOCUMENT_ROOT'] . "/header.php";
$comp = getDataForGallery(); // Запрос к бд
?>

<section class="gallery">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2>Фотогалерея</h2>
            </div>
        </div>

        <?php if (!empty($comp)):
            for ($i = 0; $i < count($comp); $i++):

                // Разделение фотоальбомов по годам
                if ($i === 0): ?>
                    <div class="row">
                        <div class="col-lg-12 text-center"><h4><?= date("Y", strtotime($comp[$i]->date)); ?></h4></div>
                    </div>
                    <div class="row">
                <?php elseif (substr($comp[$i - 1]->date, 0 ,4) != substr($comp[$i]->date, 0 ,4)): ?>
                    <div class="row">
                        <div class="col-lg-12 text-center"><h4><?= date("Y", strtotime($comp[$i]->date)); ?></h4></div>
                    </div>
                    <div class="row">
                <?php endif; ?>

                        <div class="col-md-6 col-lg-4 text-center">
                            <a href="/gallery_one.php?id=<?= $comp[$i]->id; ?>">
                                <figure class="gallery__figure">
                                    <img src="<?= $comp[$i]->album_cover; ?>" class="gallery__img" alt="Фотография с соревнования">
                                </figure>
                            </a>
                            <div class="gallery__text">
                                <div class="gallery__text-name">
                                    <a href="/gallery_one.php?id<?= $comp[$i]->id; ?>">
                                        <?php if ($comp[$i]->album_name) echo $comp[$i]->album_name; else echo $comp[$i]->name; ?>
                                    </a>
                                </div>
                                <div><?= $comp[$i]->date; ?></div>
                            </div>
                        </div>

                <?php if ($i === count($comp) - 1): ?>
                    </div>
                <?php elseif (substr($comp[$i + 1]->date, 0 ,4) != substr($comp[$i]->date, 0 ,4)): ?>
                    </div>
                <?php endif; ?>

            <?php endfor;
        else: ?>
            <div class="row">
                <div class="col-lg-12">Фотогалерея пуста!</div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; ?>

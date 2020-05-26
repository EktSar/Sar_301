<?php require $_SERVER['DOCUMENT_ROOT'] . "/header.php";
$workers = getAllWorkers();
$partners = getAllPartnersByName();
?>

<section class="about">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2>О центре</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7">
                <h4>О нас</h4>
                <div class="text">
                    Центр олимпиадного программирования ЮУрГУ создан в 2018 году. Основной целью Центра является подготовка студентов к участию в командных и личных соревнованиях по программированию международного уровня ACM ICPC, Яндекс.Алгоритм, Google Code Jam, Russian Code Cup и др.
                </div>
            </div>
            <div class="col-lg-5">
                <figure>
                    <img class="news__img" src="img/about/img.png" alt="Картинка о нас">
                </figure>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h4>Сотрудники</h4>
            </div>
        </div>

        <div class="row">
            <div class="workers">
                <?php foreach ($workers as $worker):?>
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 text-center">
                        <figure class="workers__figure">
                            <img src="<?= $worker->image_url; ?>" class="workers__img" alt="Фотография сотрудника">
                        </figure>
                        <div class="workers__worker">
                            <div class="workers__worker_name"><?= $worker->surname; ?>  <?= $worker->name; ?></div>
                            <div class="workers__worker_position"><?= $worker->position; ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h4>Наши партнеры</h4>
            </div>
        </div>
        <div class="row partners">
            <?php foreach ($partners as $partner): ?>
                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                    <a href="<?= $partner->site_url; ?>">
                        <figure class="partners__figure">
                            <img src="<?= $partner->image_url; ?>" alt="Логотип партнера">
                        </figure>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
</section>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; ?>

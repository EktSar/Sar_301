<?php require $_SERVER['DOCUMENT_ROOT'] . "/header.php";
$comp = getAllCompetitionsByDate();
?>

<section class="competitions">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2>Соревнования</h2>
            </div>
        </div>

        <?php if (!empty($comp)):
            for ($i = 0; $i < count($comp); $i++):

                // Если выбрано отображение на сайте
                if ($comp[$i]->view == 1):
                    // Разделение фотоальбомов по годам
                    if ($i === 0): ?>
                        <div class="row">
                            <div class="col-lg-12 text-center"><h4><?= date("Y", strtotime($comp[$i]->date)); ?></h4></div>
                        </div>
                        <div class="competitions__competition">
                    <?php elseif (substr($comp[$i - 1]->date, 0 ,4) != substr($comp[$i]->date, 0 ,4)): ?>
                        <div class="row">
                            <div class="col-lg-12 text-center"><h4><?= date("Y", strtotime($comp[$i]->date)); ?></h4></div>
                        </div>
                        <div class="competitions__competition">
                    <?php endif; ?>

                            <div class="row competitions__competition_item">
                                <div class="col-md-3 offset-lg-1 col-lg-3 date"><?= $comp[$i]->date ?></div>
                                <div class="col-md-9 offset-lg-1 col-lg-7">
                                    <a href="/competitions_one.php?id=<?= $comp[$i]->id ?>"><?= $comp[$i]->name ?></a>
                                </div>
                            </div>

                    <?php if ($i === count($comp) - 1): ?>
                        </div>
                    <?php elseif (substr($comp[$i + 1]->date, 0 ,4) != substr($comp[$i]->date, 0 ,4)): ?>
                        </div>
                    <?php endif; ?>
                <?php endif;?>

            <?php endfor;
        else: ?>
            <div class="row">
                <div class="col-lg-12">Соревнований нет!</div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; ?>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/header.php";
$compMenu = getDataForMenuById($_GET['id']);
?>

<section class="competitions">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2><?= getCompetitionById($_GET['id'], 'name')->name; ?></h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5">
                <div class="competitions__menu">
                    <?php foreach ($compMenu as $menu):?>
                        <div class="competitions__menu_item"><a href="#<?=$menu->title?>"><?= $menu->title ?></a></div>
                    <?php endforeach;?>
                    <div class="competitions__menu_item"><a href="/competitions.php">Назад к соревнованиям</a></div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="competitions__text">
                    <?php foreach ($compMenu as $menu):?>
                        <h4 id="<?=$menu->title?>"><?= $menu->title ?></h4>
                        <div class="text"><?= $menu->text ?></div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; ?>

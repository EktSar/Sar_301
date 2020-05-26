<?php require $_SERVER['DOCUMENT_ROOT'] . "/header.php";
$news = getNewsById($_GET['id']);
?>

<section class="newsOne">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2><?= $news->title; ?></h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="news__title_date"><?= date("d.m.Y", strtotime($news->pubdate)); ?></div>
                <div class="text">
                    <figure>
                        <img class="newsOne__img" src="<?= $news->image; ?>" alt="Картинка новости">
                    </figure>
                    <?= $news->text; ?>
                </div>
            </div>
            <div class="col-lg-12">
                <a href="/?page=<?=$_GET['page']?>#news_<?= $news->id; ?>">Вернуться к списку новостей >></a>
            </div>
        </div>
    </div>
</section>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; ?>

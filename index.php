<?php require $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>

<main>
    <div class="container">
        <div class="row main">
            <div class="offset-1 col-9 offset-sm-0 col-lg-8">
                <h1 class="mainTitle"><?= $config['title']; ?></h1>
            </div>
        </div>
        <div class="row align-items-lg-start">
            <div class="offset-2 col-8 offset-sm-1 col-sm-11 offset-md-3 col-md-8 offset-lg-3 col-lg-6 offset-xl-3 col-xl-5">
                <h3>Не бывает хороших языков,
                    <span>бывают хорошие программисты</span>
                </h3>
            </div>
        </div>
    </div>
</main>

<section>
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 id="news">Новости</h2>
            </div>
        </div>

        <?php // Проверка на то, если ли в бд новости
        $countAllNews=intval(getConnection()->query("SELECT COUNT(*) as count FROM news")->fetchColumn());
        ?>

        <?php if ($countAllNews <= 0):?>
            <div class="row news">
                <div class="col-lg-12">Новостей нет!</div>
            </div>
        <?php endif;?>

        <?php
        $curPage = 1;
        $countNewsOnPage = $config['countNewsOnPage'];
        $countAllPages = ceil($countAllNews / $countNewsOnPage);

        if (isset($_GET['page'])) {
            $curPage = (int) $_GET['page'];
        }

        if ($curPage <= 1 || $curPage > $countAllPages) { // проверка на некорректный ввод
            $curPage = 1;
        }

        $offset = $countNewsOnPage * ($curPage - 1); // сдвиг на странице

        // Заполнение новостей из бд
        $sql = "SELECT * FROM news ORDER BY id DESC LIMIT $offset, $countNewsOnPage";
        $result = getConnection()->query($sql);
        $objNews = $result->fetchAll(PDO::FETCH_OBJ);

        if ($objNews):
            foreach ($objNews as $news): ?>
                <div class="row news">
                    <div class="col-lg-5">
                        <a href="/news_one.php?id=<?= $news->id; ?>&page=<?=$curPage?>">
                            <figure>
                                <img class="news__img" src="<?= $news->image; ?>" alt="Картинка новости">
                            </figure>
                        </a>
                    </div>
                    <div class="col-lg-7">
                        <div class="news__title" id="news_<?= $news->id; ?>">
                            <h4><a href="/news_one.php?id=<?= $news->id; ?>&page=<?=$curPage?>"><?= $news->title; ?></a></h4>
                        </div>
                        <div class="news__title_date"><?= date("d.m.Y", strtotime($news->pubdate)); ?></div>
                        <div class="text"><?= $news->announcement; ?></div>
                        <a href="/news_one.php?id=<?= $news->id; ?>&page=<?=$curPage?>" class="more">Подробнее >></a>
                    </div>
                </div>
            <?php endforeach;
        endif; ?>

        <?php // Пагинация
        if ($countAllPages > 1): ?>
            <div class="row">
                <ul class="pager offset-lg-4 col-lg-5">
                    <?php // Ссылка на первую страницу
                    if ($curPage > 1):?>
                        <li><a href="/?page=1&#news"><<</a></li>
                    <?php endif;?>

                    <?php for ($i = 1; $i <= $countAllPages; $i++): ?>
                        <?php if ($i === $curPage): ?>
                            <li><a href="/?page=<?=$i?>&#news" class="actionPager"><span><?=$i?></span></a></li>
                        <?php else:?>
                            <li><a href="/?page=<?=$i?>&#news"><?=$i?></a></li>
                        <?php endif;?>
                    <?php endfor;?>

                    <?php // Ссылка на последнюю страницу
                    if ($curPage < $countAllPages): ?>
                        <li><a href="/?page=<?=$countAllPages?>&#news" class="">>></a></li>
                    <?php endif;?>
                </ul>
            </div>
        <?php endif;?>
    </div>
</section>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/footer.php'; ?>

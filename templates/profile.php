<section class="pt90">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Личный кабинет</h2>
            </div>
        </div>

        <?php if (!empty($user)): ?>
            <div class="row">
                <div class="col-12 col-lg-5">
                    <div class="profile">
                        <div><span class="gray">ФИО:</span> <?= $user->name; ?></div>

                        <?php if ($user->group_name): ?>
                            <div><span class="gray">Группа:</span> <?= $user->group_name; ?></div>
                        <?php endif; ?>
                        <?php if ($user->email): ?>
                            <div><span class="gray">Почта:</span> <?= $user->email; ?></div>
                        <?php endif; ?>
                        <?php if ($user->phone): ?>
                            <div><span class="gray">Телефон:</span> <?= $user->phone; ?></div>
                        <?php endif; ?>
                        <?php if ($user->login_codeforces): ?>
                            <div><span class="gray">Ник на Codeforces:</span> <?= $user->login_codeforces; ?></div>
                        <?php endif; ?>
                        <?php if ($user->login_informatics): ?>
                            <div><span class="gray">Ник на Informatics:</span> <?= $user->login_informatics; ?></div>
                        <?php endif; ?>

                        <div><span class="gray">Уровень подготовки:</span> <?= getLevelPreparing($user->level_preparing); ?></div>
                        <div><span class="gray">Год поступления:</span> <?= $user->year_acceptance; ?></div>
                    </div>
                </div>

                <div class="col-12 col-lg-7">
                    <table class="table text-center" style="table-layout: fixed; width: 100%;">
                        <thead>
                        <tr>
                            <th colspan="4" >Рейтинг</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>Ваш</th>
                            <th>Min</th>
                            <th>Max</th>
                            <th>Средний</th>
                        </tr>
                        <tr>
                            <th><?= $user->overall_rating; ?></th>
                            <th><?= getMinRating(); ?></th>
                            <th><?= getMaxRating(); ?></th>
                            <th><?= getAvgRating(); ?></th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <h4>Подробный рейтинг</h4>
                </div>
                <div class="col-12 offset-lg-2 col-lg-8">
                    <?php
                    $arrRatingDate = getArrRatingDate(); // Массив с названиями последних 15 месяцов в виде "гггг-мм"
                    $objMonthlyRating = getMonthlyRating($user->id); // Объект из бд со значениями рейтинга за 15 месяцев данного студента
                    $listCompetitions = getListCompetitions($user->id); // Список соревнований студента за весь период

                    ?>

                    <ul class="months-list">
                        <?php for ($i = 1; $i <= count($arrRatingDate); $i++):
                            $monthNum = 'r_'.$i;
                            // Вывод шапки с месяцем
                            ?>
                            <li class="months-item page-months__item mb">
                                <div class="months-item__wrapper">
                                    <div class="months-item__group">
                                        <span class="months-item__title">Год-месяц</span>
                                        <span class="months-item__info"><?= $arrRatingDate["r_$i"] ?></span>
                                    </div>
                                    <div class="months-item__group">
                                        <span class="months-item__title">Рейтинг за месяц</span>
                                        <?php
                                            if ($objMonthlyRating->$monthNum === null) echo 0;
                                            else echo $objMonthlyRating->$monthNum;
                                        ?>
                                    </div>
                                    <button class="months-item__toggle"></button>
                                </div>

                                <?php // Вывод скрытой части, подробно о каждом соревновании ?>
                                <div class="months-item__wrapper">
                                    <?php if (!empty($listCompetitions)):
                                        foreach ($listCompetitions as $competition):
                                            if ($arrRatingDate["r_$i"] === mb_strimwidth($competition->date, 0, 7)): ?>
                                                <div class="months-item__wrapper-comp">
                                                    <div class="months-item__group">
                                                        <span class="months-item__title">Название соревнования</span>
                                                        <span class="months-item__info months-item__comp"><?= $competition->name ?></span>
                                                    </div>
                                                    <div class="months-item__group">
                                                        <span class="months-item__title">Рейтинг</span>
                                                        <span class="months-item__info"><?= $competition->rating ?></span>
                                                    </div>
                                                </div>
                                            <?php elseif ($competition->date === '1900-01-01'): // Если это подъемные баллы ?>
                                                <div class="months-item__wrapper-comp">
                                                    <div class="months-item__group">
                                                        <span class="months-item__title">Название соревнования</span>
                                                        <span class="months-item__info months-item__comp"><?= $competition->name ?></span>
                                                    </div>
                                                    <div class="months-item__group">
                                                        <span class="months-item__title">Рейтинг</span>
                                                        <span class="months-item__info"><?= $competition->rating ?></span>
                                                    </div>
                                                </div>
                                            <?php endif;
                                        endforeach;
                                    else: ?>
                                        <div class="months-item__wrapper-comp">
                                            <div>В данный период времени Вы не принимали участие в соревнованиях!</div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-12">Произошла ошибка!</div>
            </div>
        <?php endif; ?>
    </div>
</section>

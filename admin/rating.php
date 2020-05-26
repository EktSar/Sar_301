<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// Защита от гостей
if (empty($_SESSION['logged_admin'])) {
    header("Location: /admin/index.php");
    die();
}

require __DIR__ . "/header.php";

// Обращение к бд за студентами с их рейтингом
$students = getAllStudentsByRating();
?>

<section class="competitions">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2>Рейтинг</h2>
            </div>
        </div>

        <?php if (!empty($students)): ?>
            <div class="row">
                <div class="col-12">
                    <a href="rating_add.php" class="btn btn-primary btn-basic">Ввести данные</a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th>ФИО</th>
                            <th>Группа</th>
                            <th>Рейтинг</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php for ($i = 0; $i < count($students); $i++):?>
                            <tr class="table-row-rating" onclick="goPersonalRating(<?= $students[$i]->id ?>)">
                                <th scope="row"><?= $i + 1 ?></th>
                                <td><?= $students[$i]->name; ?></td>
                                <td><?= $students[$i]->group_name; ?></td>
                                <td><?= $students[$i]->overall_rating; ?></td>
                            </tr>
                        <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-12">Произошла ошибка! Рейтинг не найден.</div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . "/footer.php"; ?>

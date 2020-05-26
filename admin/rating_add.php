<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// Внесение данных бд
if (isset($_POST['add_rating']) && isset($_SESSION['logged_admin'])) {
    // Расчет рейтинга за данное соренование, возвращается рейтинг, id студента, дата соревнования
    $data = ratingCalculate($_POST);

    // Изменение рейтинга за конкретный месяц и общего рейтинга
    changeStudentRating($data);

    header("Location: /admin/rating.php");
    die();
}

// Защита от гостей
if (empty($_SESSION['logged_admin'])) {
    header("Location: /admin/index.php");
    die();
}

require __DIR__ . "/header.php";

$comp = getAllCompetitionsByDate('id, name');
$students = getAllStudentsByName();
?>

<section class="competitions">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2>Внесение данных</h2>
            </div>

            <?php if (!empty($comp) && !empty($students)): ?>
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-7">
                            <form method="POST">
                                <div class="legend">Для определения рейтинга заполните приведенные поля</div>
                                <p><span class="req">*</span> поля обязательные для заполнения</p>

                                <div class="form-group">
                                    <label for="comp">Выберите соревнование <span class="req">*</span></label>
                                    <select class="form-control" id="comp" name="comp">
                                        <?php for ($i = 0; $i < count($comp); $i++): ?>
                                            <option value="<?= $comp[$i]->id ?>"><?= $comp[$i]->name ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="student">Выберите студента <span class="req">*</span></label>
                                    <select class="form-control" id="student" name="student">
                                        <?php for ($i = 0; $i < count($students); $i++): ?>
                                            <option value="<?= $students[$i]->id ?>"><?= $students[$i]->name ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="count_tasks">Количество решенных задач студентом <span class="req">*</span></label>
                                    <input required type="text" class="form-control" id="count_tasks" name="count_tasks">
                                </div>
                                <div class="form-group">
                                    <label for="place">Место, которое занял студент <span class="req">*</span></label>
                                    <select class="form-control" id="place" name="place">
                                        <option value="0">Участник (Диплом участника)</option>
                                        <option value="1">1 место (Диплом 1 степени)</option>
                                        <option value="2">2 место (Диплом 2 степени)</option>
                                        <option value="3">3 место (Диплом 3 степени)</option>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <button type="submit" name="add_rating" class="btn btn-primary btn-basic btn-mt">Внести</button>
                                    </div>
                                    <div class="col">
                                        <a href="/admin/rating.php" class="btn btn-secondary btn-basic btn-mt">Отмена</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-12">Произошла ошибка!</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require __DIR__ . "/footer.php"; ?>

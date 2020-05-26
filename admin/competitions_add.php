<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// Добавление соревнования в бд
if (isset($_POST['add_competition']) && isset($_SESSION['logged_admin']) && empty($_GET['id'])) {
    insertCompetition($_POST);
    header("Location: /admin/competitions.php");
    die();
}

// Изменение соревнования в бд
if (isset($_POST['add_competition']) && isset($_SESSION['logged_admin']) && !empty($_GET['id'])) {
    updateCompetition($_POST, $_GET['id']);
    header("Location: /admin/competitions.php");
    die();
}

// Защита от гостей
if (empty($_SESSION['logged_admin'])) {
    header("Location: /admin/index.php");
    die();
}

require __DIR__ . "/header.php";

// Получение данных соревнования при его изменении
if (isset($_GET['id'])) {
    $compId = $_GET['id'];
    $comp = getCompetitionById($compId);
}
?>

<section class="competitions">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2><?php if (!empty($compId)) echo 'Изменение'; else echo 'Добавление'; ?> соревнования</h2>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-7">
                        <form method="POST" class="form-competition">
                            <div class="legend">Укажите данные соревнования</div>
                            <p><span class="req">*</span> поля обязательные для заполнения</p>

                            <div class="form-group">
                                <label for="name">Название <span class="req">*</span></label>
                                <input required type="text" class="form-control" id="name" name="name"
                                       value="<?php if(!empty($comp->name)) echo $comp->name ?>">
                            </div>
                            <div class="form-group">
                                <label for="date">Дата <span class="req">*</span></label>
                                <input required type="date" class="form-control" id="date" name="date"
                                       value="<?php if(!empty($comp->date)) echo $comp->date ?>">
                            </div>

                            <div class="form-group">
                                <label for="type">Тип соревнования <span class="req">*</span></label>
                                <select class="form-control" id="type" name="type">
                                    <?php for ($i = 1; $i < 8; $i++): ?>
                                        <option value="<?= $i ?>" <?php if (!empty($comp->type) && $comp->type == $i) echo 'selected' ?>>
                                            <?= getTypeCompetitions($i); ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="count_tasks">Количество задач, предоставляемые участникам данного соревнования</label>
                                <input type="text" class="form-control" id="count_tasks" name="count_tasks"
                                       value="<?php if(!empty($comp->count_tasks)) echo $comp->count_tasks ?>">
                            </div>
                            <div class="form-group">
                                <label for="place">Место проведения соревнования</label>
                                <input type="text" class="form-control" id="place" name="place" placeholder="г. Челябинск"
                                       value="<?php if(!empty($comp->place)) echo $comp->place ?>">
                            </div>
                            <div class="form-group">
                                <label for="view">Отображение на сайте <span class="req">*</span></label>
                                <select class="form-control" id="view" name="view">
                                    <option value="1" <?php if (!empty($comp->view) && $comp->view == 1) echo 'selected' ?>>Отображать</option>
                                    <option value="0" <?php if (!empty($comp->view) && $comp->view == 0) echo 'selected' ?>>Не отображать</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <button type="submit" name="add_competition" class="btn btn-primary btn-basic btn-mt">
                                        <?php if (!empty($compId)) echo 'Изменить'; else echo 'Добавить'; ?>
                                    </button>
                                </div>
                                <div class="col">
                                    <a href="/admin/competitions.php" class="btn btn-secondary btn-basic btn-mt">Отменить</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . "/footer.php"; ?>

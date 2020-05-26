<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// Добавление студента в бд
if (isset($_POST['add_student']) && isset($_SESSION['logged_admin']) && empty($_GET['id'])) {
    insertStudent($_POST);
    header("Location: /admin/students.php");
    die();
}

// Изменение студента в бд
if (isset($_POST['add_student']) && isset($_SESSION['logged_admin']) && !empty($_GET['id'])) {
    updateStudent($_POST, $_GET['id']);
    header("Location: /admin/students.php");
    die();
}

// Защита от гостей
if (empty($_SESSION['logged_admin'])) {
    header("Location: /admin/index.php");
    die();
}

require __DIR__ . "/header.php";

// Получение данных студента при его изменении
if (!empty($_GET['id'])) {
    $studentId = $_GET['id'];
    $student = getStudentById($studentId);
}
?>

<section class="competitions">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2><?php if (!empty($studentId)) echo 'Изменение'; else echo 'Добавление'; ?> студента</h2>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-7">
                        <form method="POST" class="form-student">
                            <div class="legend">Укажите личные данные студента</div>
                            <p><span class="req">*</span> поля обязательные для заполнения</p>

                            <div class="form-group">
                                <label for="name">ФИО <span class="req">*</span></label>
                                <input required type="text" class="form-control" id="name" name="name"
                                       value="<?php if(!empty($student->name)) echo $student->name ?>">
                            </div>
                            <div class="form-group">
                                <label for="login_codeforces">Логин на Codeforces</label>
                                <input type="text" class="form-control" id="login_codeforces" name="login_codeforces"
                                       value="<?php if(!empty($student->login_codeforces)) echo $student->login_codeforces ?>">
                            </div>
                            <div class="form-group">
                                <label for="login_informatics">Логин на Informatics</label>
                                <input type="text" class="form-control" id="login_informatics" name="login_informatics"
                                       value="<?php if(!empty($student->login_informatics)) echo $student->login_informatics ?>">
                            </div>
                            <div class="form-group">
                                <label for="password">
                                    <?php if (!empty($studentId)) echo 'Введите новый пароль для студента (только при необходимости)';
                                        else echo 'Пароль студента для входа в личный кабинет'; ?>
                                </label>
                                <input type="text" class="form-control" id="password" name="password">
                            </div>
                            <div class="form-group">
                                <label for="group_name">Группа</label>
                                <input type="text" class="form-control" id="group_name" name="group_name"
                                       value="<?php if (!empty($student->group_name)) echo $student->group_name ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Почта</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="<?php if (!empty($student->email)) echo $student->email ?>">
                            </div>
                            <div class="form-group">
                                <label for="phone">Телефон</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                       value="<?php if (!empty($student->phone)) echo $student->phone ?>">
                            </div>
                            <div class="form-group">
                                <label for="level_preparing">Уровень подготовки <span class="req">*</span></label>
                                <select class="form-control" id="level_preparing" name="level_preparing">
                                    <option value="1" <?php if (!empty($student->level_preparing) && $student->level_preparing == 1) echo 'selected' ?>>
                                        Базовая подготовка
                                    </option>
                                    <option value="2" <?php if (!empty($student->level_preparing) && $student->level_preparing == 2) echo 'selected' ?>>
                                        Олимпиадная подготовка
                                    </option>
                                    <option value="3" <?php if (!empty($student->level_preparing) && $student->level_preparing == 3) echo 'selected' ?>>
                                        Продвинутая подготовка
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="year_acceptance">Год поступления <span class="req">*</span></label>
                                <input required type="text" class="form-control" id="year_acceptance" name="year_acceptance"
                                       value="<?php if(!empty($student->year_acceptance)) echo $student->year_acceptance ?>">
                            </div>

                            <div class="row">
                                <div class="col">
                                    <button type="submit" name="add_student" class="btn btn-primary btn-basic btn-mt">
                                        <?php if (!empty($studentId)) echo 'Изменить'; else echo 'Добавить'; ?>
                                    </button>
                                </div>
                                <div class="col">
                                    <a href="/admin/students.php" class="btn btn-secondary btn-basic btn-mt">Отменить</a>
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

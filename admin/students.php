<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// Удаление студента из бд
if (isset($_POST['del_student']) && isset($_SESSION['logged_admin']) && !empty($_POST['studentId'])) {
    deleteStudentById($_POST['studentId']);
    die();
}

// Защита от гостей
if (empty($_SESSION['logged_admin'])) {
    header("Location: /admin/index.php");
    die();
}

require __DIR__ . "/header.php";

// Обращение к бд
$students = getAllStudentsByName();
?>

<section class="competitions">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2>Студенты</h2>
            </div>
        </div>

        <?php if (!empty($students)): ?>
            <div class="row">
                <div class="col">
                    <a href="students_add.php" class="btn btn-primary btn-basic">Добавить студента</a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <table class="table table-sm table-responsive-xl">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th>ФИО</th>
                            <th>Codeforces</th>
                            <th>Informatics</th>
                            <th>Группа</th>
                            <th>Почта</th>
                            <th>Телефон</th>
                            <th>Уровень подготовки</th>
                            <th>Год поступления</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="table-students">
                        <?php for ($i = 0; $i < count($students); $i++): ?>
                            <tr>
                                <th scope="row" class="num"><?= $i + 1 ?></th>
                                <td><?= $students[$i]->name; ?></td>
                                <td><?= $students[$i]->login_codeforces; ?></td>
                                <td><?= $students[$i]->login_informatics; ?></td>
                                <td><?= $students[$i]->group_name; ?></td>
                                <td><?= $students[$i]->email; ?></td>
                                <td><?= $students[$i]->phone; ?></td>
                                <td><?= getLevelPreparing($students[$i]->level_preparing); ?></td>
                                <td><?= $students[$i]->year_acceptance; ?></td>
                                <td><a href="students_add.php/?id=<?= $students[$i]->id ?>" class="table-edit" aria-label="Редактировать"></a></td>
                                <td>
                                    <a href="#" data-target="#model-delete" data-toggle="modal" class="table-delete"
                                       data-content="Вы точно хотите, чтобы студент <?= $students[$i]->name ?> был удален?"
                                       data-id="<?= $students[$i]->id ?>"></a>
                                </td>
                            </tr>
                        <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-12">Студентов нет!</div>
            </div>
        <?php endif; ?>
    </div>
</section>

<div class="modal fade" id="model-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Удаление студента</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">...</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                <button type="button" class="btn btn-primary btn-delete-student" data-dismiss="modal">Удалить</button>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . "/footer.php"; ?>

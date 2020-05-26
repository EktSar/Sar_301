<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// Удаление соревнования из бд
if (isset($_POST['del_competition']) && isset($_SESSION['logged_admin']) && !empty($_POST['competitionId'])) {
    deleteCompetitionById($_POST['competitionId']);
    return;
}

// Защита от гостей
if (empty($_SESSION['logged_admin'])) {
    header("Location: /admin/index.php");
    die();
}

require __DIR__ . "/header.php";

// Обращение к бд
$comp = getAllCompetitionsByName();
?>

<section class="competitions">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2>Соревнования</h2>
            </div>
        </div>

        <?php if (!empty($comp)): ?>
            <div class="row">
                <div class="col-12">
                    <a href="competitions_add.php" class="btn btn-primary btn-basic">Добавить соревнование</a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <table class="table table-sm table-responsive">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th>Название</th>
                            <th>Дата соревнования</th>
                            <th>Тип соревнования</th>
                            <th>Количество задач</th>
                            <th>Место проведения</th>
                            <th>Отображается на сайте</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="table-competitions">
                        <?php for ($i = 0; $i < count($comp); $i++): ?>
                            <tr>
                                <th scope="row" class="num"><?= $i + 1 ?></th>
                                <td><?= $comp[$i]->name; ?></td>
                                <td><?= date("d.m.Y", strtotime($comp[$i]->date)); ?></td>
                                <td><?= getTypeCompetitions($comp[$i]->type); ?></td>
                                <td><?= $comp[$i]->count_tasks ?></td>
                                <td><?= $comp[$i]->place; ?></td>
                                <td><?= getView($comp[$i]->view); ?></td>
                                <td><a href="competitions_add.php/?id=<?= $comp[$i]->id ?>" class="table-edit" aria-label="Редактировать"></a></td>
                                <td>
                                    <a href="#" data-target="#model-delete" data-toggle="modal" class="table-delete"
                                       data-content="Вы точно хотите, чтобы соревнование <?= $comp[$i]->name ?> было удалено?"
                                       data-id="<?= $comp[$i]->id ?>"></a>
                                </td>
                            </tr>
                        <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-12">Соревнований нет!</div>
            </div>
        <?php endif; ?>
    </div>
</section>

<div class="modal fade" id="model-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Удаление соревнования</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">...</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                <button type="button" class="btn btn-primary btn-delete-competition" data-dismiss="modal">Удалить</button>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . "/footer.php"; ?>

<?php error_reporting(E_ALL);
session_start();

require $_SERVER['DOCUMENT_ROOT'] . "/header.php";

// Проверка на корректность авторизации
if (checkUser($_POST) || isset($_SESSION['logged_user'])):
    $user = $_SESSION['logged_user'];
    require $_SERVER['DOCUMENT_ROOT'] . "/templates/profile.php";
else: ?>
    <section class="pt90">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Личный кабинет участника&nbsp;ЦОП</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-7">
                    <form action="index.php" method="POST">
                        <div class="form-group">
                            <label for="email">Почта</label>
                            <input required type="email" class="form-control" id="email" name="email" value="<?= @$_POST['email'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input required type="password" class="form-control" id="password" name="password" value="<?= @$_POST['password'] ?>">
                        </div>
                        <div class="link">
                            <a href="#">Восстановить пароль</a>
                        </div>

                        <button type="submit" name="log_in" class="btn btn-primary btn-basic">Войти</button>

                        <?php if (!empty($_POST)): // Вывод ошибки, если были введены неправильные данные ?>
                            <div class="error">Ошибка при вводе данных!</div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/footer.php"; ?>

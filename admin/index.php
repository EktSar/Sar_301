<?php error_reporting(E_ALL);

require __DIR__ . "/header.php";
?>

<?php if (checkAdmin($_POST) || isset($_SESSION['logged_admin'])): ?>
    <section class="pt90">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Страница администрирования</h2>
                </div>
                <div class="col-12">
                    <div>
                        Добро пожаловать, администратор!
                    </div>
                </div>
            </div>
    </section>
<?php else: ?>
    <section class="pt90">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Страница администрирования</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-7">
                    <form action="index.php" method="POST">
                        <div class="form-group">
                            <label for="login">Логин</label>
                            <input required type="text" class="form-control" id="login" name="login" value="<?= @$_POST['login'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input required type="password" class="form-control" id="password" name="password_admin" value="<?= @$_POST['password_admin'] ?>">
                        </div>

                        <button type="submit" name="log_in_admin" class="btn btn-primary btn-basic">Войти</button>

                        <?php if (!empty($_POST)): // Вывод ошибки, если были введены неправильные данные ?>
                            <div class="error">Ошибка при вводе данных!</div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php require __DIR__ . "/footer.php"; ?>

    </div>

    <div class="foot">
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-4 text-center">
                        <div class="footer-a">
                            <a href="/about.php" class="footer-a__about">Подробнее о центре</a>
                            <a href="/profile/index.php">Личный кабинет участника&nbsp;ЦОП</a>
                        </div>
                        <ul class="footer__links">
                            <li><a href="<?= $config['vk_url']; ?>" class="circle vk" target="_blank"></a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <nav class="navFooter">
                            <ul class="footer__menu my-auto">
                                <li><a href="/">Главная</a></li>
                                <li><a href="/preparing.php">Подготовка</a></li>
                                <li><a href="/competitions.php">Соревнования</a></li>
                                <li><a href="/system.php">Система</a></li>
                                <li><a href="/gallery.php">Фотогалерея</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-12 offset-md-1 col-md-5 offset-lg-0 col-lg-4">
                        <div class="footer__contact footer__phone"><a href="tel:<?= $config['phone']; ?>"><?= $config['phone']; ?></a></div>
                        <div class="footer__contact footer__email"><a href="mailto:<?= $config['email']; ?>"><?= $config['email']; ?></a></div>
                        <div class="footer__contact footer__time"><?= $config['time']; ?></div>
                        <address class="footer__contact footer__location"><?= $config['address']; ?></address>
                    </div>
                </div>
            </div>
        </footer>
        <section class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="copyright__text text-center">
                            © 2019-<?= date('Y') ?> <?= $config['title']; ?>. Все права защищены
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script src="/js/jquery-3.4.1.min.js"></script>
<script src="/js/jquery.fancybox.min.js"></script>
<script src="/js/jquery.maskedinput.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/main.js"></script>
</body>
</html>

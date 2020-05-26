<?php error_reporting(E_ALL); ?>
<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// Обработка выхода из административного отдела
if(isset($_GET['exit']) && $_GET['exit'] == 'on') {
    session_destroy();
    header("Location: /admin/index.php");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $config['title']; ?></title>
    <link rel="icon" href="/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700&display=swap&subset=cyrillic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=El+Messiri&display=swap&subset=cyrillic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap&subset=cyrillic" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/jquery.fancybox.min.css" rel="stylesheet" type="text/css"/>
    <link href="/css/main.css" rel="stylesheet" type="text/css"/>
    <link href="/css/media.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<header class="header">
    <div class="container">
        <div class="row text-center align-items-center">
            <div class="col-4 col-sm-4 col-lg-2 col-xl-1">
                <a href="/">
                    <img class="logo" src="/img/logo.png" alt="Логотип">
                </a>
            </div>
            <nav class="col-4 col-sm-4 col-lg-9 col-xl-9">
                <li class="btnMenu"><a href="javascript:void(0);" onclick="clickHamburger()">Меню</a></li>
                <ul class="menu">
                    <li><a href="/" class="menu__item">Главная</a></li>
                    <li><a href="/admin/competitions.php" class="menu__item">Соревнования</a></li>
                    <li><a href="/admin/students.php" class="menu__item">Студенты</a></li>
                    <li><a href="/admin/rating.php" class="menu__item">Рейтинг</a></li>
                    <li><a href="/admin/?exit=on" class="menu__item">Выйти</a></li>
                </ul>
            </nav>
            <div class="col-xl-2 hide">
                <a href="http://susu.ru" target="_blank"><img class="logoSUSU" src="/img/SUSUlogo.png" alt="Логотип ЮУрГУ"></a>
            </div>
            <div class="col-4 col-sm-4 col-lg-1">
                <a href="http://susu.ru" target="_blank"><img class="logoSUSU-small" src="/img/logoSUSU.png" alt="Логотип ЮУрГУ"></a>
            </div>
        </div>
    </div>
</header>
<section class="hidden">
    <div class="container">
        <ul id="menu" class="hidden__menu text-center">
            <li><a href="/" class="menu__item">Главная</a></li>
            <li><a href="/admin/competitions.php" class="menu__item">Соревнования</a></li>
            <li><a href="/admin/students.php" class="menu__item">Студенты</a></li>
            <li><a href="/admin/rating.php" class="menu__item">Рейтинг</a></li>
            <li><a href="/admin/?exit=on" class="menu__item">Выйти</a></li>
        </ul>
    </div>
</section>

<div class="wrapper">
    <div class="content">

<?php
// Настройки сайта
$config = array(
    'title' => 'Центр олимпиадного программирования ЮУрГУ',

    'vk_url' => 'https://vk.com/eecs_programming', // ссылка на группу ШОП

    'phone' => '+7 (351) 267-90-89',
    'email' => 'acm@susu.ru', // почта, на которую будут писать пользователи сайта
    'time' => 'Пн-Сб: 9:00-17:00', // время работы ЦОП
    'address' => 'г. Челябинск, пр-кт Ленина,&nbsp;78 (ЮУрГу, 3&nbsp;корпус)', // адрес ЦОП

    'countNewsOnPage' => 5, // количество новостей на главной странице, после которой появляется пагинация (переход между разными страницами)
);

require_once "functions.php";
if (session_status() == PHP_SESSION_NONE) {
    session_name("SESSAD");
    session_start();
}

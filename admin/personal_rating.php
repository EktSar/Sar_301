<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// Защита от гостей
if (empty($_SESSION['logged_admin']) && empty($_GET['id'])) {
    header("Location: /admin/index.php");
    die();
}

require __DIR__ . "/header.php";

if (!empty($_GET['id'])) {
    $user = getStudentById($_GET['id']);
}

require $_SERVER['DOCUMENT_ROOT'] . "/templates/profile.php";

require __DIR__ . "/footer.php";

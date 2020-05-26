<?php
$driver = 'mysql';
$host = 'localhost';
$db_name = 'acm';
$db_user = 'root';
$db_pass = '';
$charset = 'utf8';
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"];

<?php
/*Подключение функций*/
include_once MAIN_FILE . '/includes/addarticlesfunc.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Флаг, указывающий, что открыт блог*/
$itIsBlog = true;

$selectedAuthor = isset($_SESSION['loggIn']) ? (int)(authorID($_SESSION['email'], $_SESSION['password'])) : 0;//id автора

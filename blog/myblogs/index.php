<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка общих переменных*/
include_once MAIN_FILE . '/includes/commonvar.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка функций для формы публикаций*/
include_once MAIN_FILE . '/includes/addarticlesfunc.inc.php';

/*Определение нахождения пользователя в системе*/
loggedIn();

$idAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора

/*Выбор блогов автора*/
getAuthorBlogs ($idAuthor);

$title = 'Мои блоги | imagoz.ru';//Данные тега <title>
$headMain = 'Мои блоги';
$robots = 'noindex, nofollow';
$descr = 'Все мои блоги';
$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
$breadPart2 = '<a href="//'.MAIN_URL.'/blog/myblogs/">Мои блоги</a>';//Для хлебных крошек

include 'myblogs.html.php';
exit();
<?php 
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка функции вывода диалогов*/
include_once 'commondialogsfunc.inc.php';

loggedIn();

if (!loggedIn())
{
    $title = 'Ошибка доступа';//Данные тега <title>
    $headMain = 'Ошибка доступа';
    $robots = 'noindex, nofollow';
    $descr = '';
    $error = 'Доступ запрещен';
    include MAIN_FILE.'/admin/accessfail.html.php';
    exit();
}

/*Возвращение id автора*/

$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора

commonDialogsFunc($selectedAuthor);
			
include 'mainmessages.html.php';
exit();
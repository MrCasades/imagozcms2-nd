<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка общих переменных*/
include_once MAIN_FILE . '/includes/commonvar.inc.php';

/*возврат ID автора*/
$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора

/*Черновик блога*/
if (isset ($_GET['blid']))
{
	
}
<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Формирование запроса SELECT*/
	
/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';

$forSearch = array();//массив заполнения запроса

$select = 'SELECT id, metaname';
$from = ' FROM meta';
$where = ' WHERE TRUE';

/*Поле строки*/
if ($_GET['metaname'] != '')//Если выбрана какая-то строка
{
    $where .= " AND metaname LIKE :metaname ORDER BY metaname";
    $forSearch[':metaname'] = '%'. $_GET['metaname']. '%';	
}


/*Объеденение переменных в запрос*/
try
{
	$sql = $select.$from.$where;
	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	$s -> execute($forSearch);// метод дает инструкцию PDO отправить запрос MySQL. Т. к. массив $forSearch хранит значение всех псевдопеременных 
								  // не нужно указывать их по отдельности с помощью bindValue									
}

catch (PDOException $e)
{
	$error = 'Ошибка поиска';
	include MAIN_FILE . '/includes/error.inc.php';
}

foreach ($s as $row)
{
    $metas_1[] = array('idmeta' => $row['id'], 'metaname' => $row['metaname'], 'selected' => FALSE);
}

//echo $metas_1[0]['metaname'];

include 'searchtag.html.php';
exit();
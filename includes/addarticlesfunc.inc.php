<?php

/*Заполнение форм при добавлении статьи*/
function addListsInForms()
{
    /*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Список рубрик*/
	try
	{
		$result = $pdo -> query ('SELECT id, categoryname FROM category');
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка вывода category '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	foreach ($result as $row)
	{
		$GLOBALS['categorys_1'][] = array('idcategory' => $row['id'], 'categoryname' => $row['categoryname']);
	}
	
	/*Список тематик*/
	try
	{
		$result = $pdo -> query ('SELECT id, metaname FROM meta ORDER BY metaname');
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка вывода meta '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	foreach ($result as $row)
	{
		$GLOBALS['metas_1'][] = array('idmeta' => $row['id'], 'metaname' => $row['metaname'], 'selected' => FALSE);
	}
}
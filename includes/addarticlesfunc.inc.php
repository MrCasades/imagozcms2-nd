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

/*Определить цену статьи*/
function setArticlePrice($text, $type, $id, $queryType) //Type = pricenews or pricepost; id = idauthor or articleid	queryType = add or upd														
{
	include 'func.inc.php';

	/*Тип статьи для БД*/
	if($type === 'pricenews')
	{
		$tableType = 'newsblock';
	}

	elseif ($type === 'pricepost')
	{
		$tableType = 'posts';
	}

	/*Тип запроса для insrt или update*/
	if ($queryType === 'add')
	{
		$select = 'SELECT '.$type.' as price, bonus FROM author INNER JOIN rang ON idrang = rang.id
					WHERE author.id = :id';
	}

	elseif ($queryType === 'upd')
	{
		$select = 'SELECT '.$type.' as price, authorbonus as bonus FROM '.$tableType.' WHERE id = :id';
	}

	/*Подключение к базе данных*/
	include 'db.inc.php';
	
	/*Выбор цены за 1000 знаков*/
	try
	{
		$sql = $select;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':id', $id);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL		
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора цены новости '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();

	$GLOBALS['priceTxt'] = $row['price'];//цена за 1000 знаков
	$GLOBALS['bonus'] = $row['bonus'];//выбор бонуса(множителя)
	
	$GLOBALS['lengthText'] = lengthText($text);//определение длины текста
	$GLOBALS['fullPrice'] = priceText($text, $row['price'], $row['bonus']);//полная стоимость статьи
}
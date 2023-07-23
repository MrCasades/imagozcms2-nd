<?php
/*Вывод новостей в правую панель*/
/*Команда SELECT*/

try
{
	$sql = 'SELECT p.id, p.title, p.date, p.imghead
			FROM publication p 
			 
			WHERE premoderation = "YES" ORDER BY date DESC LIMIT 6';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода новостей в боковой панели';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$blogsRs[] =  array ('id' => $row['id'], 'title' =>  $row['title'], 'date' =>  $row['date'], 
						'imghead' =>  $row['imghead']);
}
	
include 'blogspublicationinrightside.inc.html.php';
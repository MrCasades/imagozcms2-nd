<?php
/*Загрузка главного пути*/
include_once '../../../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

/*Загрузка сообщения об ошибке входа*/
if (!userRole('Администратор'))
{
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Доступ запрещен';
	include '../accessfail.html.php';
	exit();
}

/*Загрузка содержимого статьи*/
if (isset ($_GET['promotion']))
{
	$idPost = $_GET['promotion'];
	
	@session_start();//Открытие сессии для сохранения id статьи
	
	$_SESSION['idpost'] = $idPost;
	$select = 'SELECT promotion.id AS promotionid, promotion, promotiontitle, imghead, videoyoutube, imgalt, promotiondate, author.id AS idauthor, authorname, category.id AS categoryid, categoryname 
				FROM promotion 
				INNER JOIN author ON idauthor = author.id 
				INNER JOIN category ON idcategory = category.id
				WHERE premoderation = "NO" AND refused = "NO" AND promotion.id = ';

	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = $select.$idPost;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода содержимого статьи';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();

	$articleId = $row['promotionid'];
	$articleText = $row['promotion'];
	$imgHead = $row['imghead'];
	$imgAlt = $row['imgalt'];
	$date = $row['promotiondate'];
	$articleTitle = $row['promotiontitle'];
	$categoryId = $row['categoryid'];
	$posttitle = $row['promotiontitle'];
	$categoryName = $row['categoryname']; 
	$authorId = $row['idauthor']; 
	$nameAuthor = $row['authorname']; 
	
	$title = $row['promotiontitle'];//Данные тега <title>
	$headMain = '<a href="#" onclick="history.back();">Назад</a>';	
	$robots = 'noindex, nofollow';
	$descr = '';
	
	/*Вывод видео в статью*/
	if ((isset($row['videoyoutube'])) && ($row['videoyoutube'] != ''))
	{
		$video = '<iframe width="460px" height="290px" src="'.$row['videoyoutube'].'" frameborder="0" allowfullscreen></iframe>';
	}
	
	else
	{
		$video = '';
	}
	
	/*Вывод тематик(тегов)*/
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT meta.id, metaname FROM promotion 
				INNER JOIN metapost ON promotion.id = idpromotion 
				INNER JOIN meta ON meta.id = idmeta 
				WHERE promotion.id = '.$idPost;//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода списка тегов';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$metas[] =  array ('id' => $row['id'], 'metaname' => $row['metaname']);
	}
	
	/*Вывод кнопок "Обновить" | "Удалить" | "Опубликовать"*/
	
	if ((isset($_SESSION['loggIn'])) && (userRole('Администратор')))
	{
		$delAndUpd = "<form action = '../../../admin/addupdpromotion/' method = 'post'>
			
						Действия с материалом:
						<input type = 'hidden' name = 'id' value = '".$_SESSION['idpost']."'>
						<input type = 'submit' name = 'action' value = 'Upd' class='btn_2 addit-btn'>
						<input type = 'submit' name = 'action' value = 'Del' class='btn_3 addit-btn'>
					  </form>";
		$premoderation = "<form action = '../../../admin/premoderation/promotionpremoderationstatus/' method = 'post'>
			
						Статус публикации:
						<input type = 'hidden' name = 'id' value = '".$_SESSION['idpost']."'>
						<input type = 'submit' name = 'action' value = 'Опубликовать' class='btn_1 addit-btn'>
						<input type = 'submit' name = 'action' value = 'Отклонить' class='btn_2 addit-btn'>
					  </form>";			  
	}
	
	include '../../commonfiles/preview.html.php';
}
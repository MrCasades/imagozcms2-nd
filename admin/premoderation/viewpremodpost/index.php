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
if (isset ($_GET['post']))
{
	$idPost = $_GET['post'];
	
	@session_start();//Открытие сессии для сохранения id статьи
	
	$_SESSION['idpost'] = $idPost;
	$select = 'SELECT posts.id AS postid, post, posttitle, imghead, videoyoutube, imgalt, postdate, idtask, author.id AS idauthor, authorname, category.id AS categoryid, categoryname 
	FROM posts
	INNER JOIN author ON idauthor = author.id 
	INNER JOIN category ON idcategory = category.id 
	WHERE premoderation = "NO" AND refused = "NO" AND posts.id = ';

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

	$articleId = $row['postid'];
	$articleText = $row['post'];
	$imgHead = $row['imghead'];
	$imgAlt = $row['imgalt'];
	$date = $row['postdate'];
	$idTask = $row['idtask'];
	$taskData = '<strong>Материал админа или супер-автора.</strong>';
	$categoryId = $row['categoryid'];
	$posttitle = $row['posttitle'];
	$categoryName = $row['categoryname']; 
	$authorId = $row['idauthor']; 
	$nameAuthor = $row['authorname']; 

	$title = $row['posttitle'];//Данные тега <title>
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
	
	/*Выбор данных задания*/
	if ($idTask != 0)
	{
		$select = 'SELECT task.id AS taskid, tasktitle, task.description AS taskdescription, taskdate FROM task WHERE task.id = ';
	
		try
		{
			$sql = $select.$idTask;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}

		catch (PDOException $e)
		{
			$error = 'Ошибка вывода содержимого задания';
			include MAIN_FILE . '/includes/error.inc.php';
		}

		$row = $s -> fetch();

		$taskId = $row['taskid'];
		$taskTitle = $row['tasktitle'];
		$taskDescription = $row['taskdescription'];
		$taskDate = $row['taskdate'];
	}
	
	/*Вывод тематик(тегов)*/
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT meta.id, metaname FROM posts 
				INNER JOIN metapost ON posts.id = idpost 
				INNER JOIN meta ON meta.id = idmeta 
				WHERE posts.id = '.$idPost;//Вверху самое последнее значение
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
		$delAndUpd = "<form action = '../../../admin/addupdpost/' method = 'post'>
			
						Действия с материалом:
						<input type = 'hidden' name = 'id' value = '".$_SESSION['idpost']."'>
						<input type = 'submit' name = 'action' value = 'Upd' class='btn_2 addit-btn'>
						<input type = 'submit' name = 'action' value = 'Del' class='btn_3 addit-btn'>
					  </form>";
		$premoderation = "<form action = '../../../admin/premoderation/postpremoderationstatus/' method = 'post'>
			
						Статус публикации:
						<input type = 'hidden' name = 'id' value = '".$_SESSION['idpost']."'>
						<input type = 'submit' name = 'action' value = 'Опубликовать' class='btn_1 addit-btn'>
						<input type = 'submit' name = 'action' value = 'Добавить в Дзен' class='btn_3 addit-btn'>
						<input type = 'submit' name = 'action' value = 'Отклонить' class='btn_2 addit-btn'>
					  </form>";	
		$convertData = "<form action = ' ' method = 'post'>
			
					  Конвертировать в нвость:
					  <input type = 'hidden' name = 'id' value = '".$_SESSION['idpost']."'>
					  <input type = 'submit' name = 'action' value = 'Конвертировать в новость' class='btn_4 addit-btn'>
					</form>";			  		  
	}
	
	include '../../commonfiles/preview.html.php';
}

if (isset ($_POST['action']) && $_POST['action'] == 'Конвертировать в новость')
{
	/*Загрузка функций в шаблон*/
	include_once MAIN_FILE . '/includes/addarticlesfunc.inc.php';

	/*Загрузка функций для формы входа*/
	require_once MAIN_FILE . '/includes/access.inc.php';
	
	$inData = 'posts';
	$idData = $_POST['id'];
	
	convertToPostOrNews($inData, $idData);
	
	//header ('Location: //'.$_SERVER['SERVER_NAME']);//перенаправление обратно в контроллер index.php
	exit();
}
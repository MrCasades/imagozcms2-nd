<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка функций для формы входа*/
include_once MAIN_FILE . '/includes/access.inc.php';

/*Определение нахождения пользователя в системе*/
loggedIn();

/*Загрузка содержимого записи*/
if (isset ($_GET['id']))
{
	$idComment = $_GET['id'];
	
	$selectedAuthor =  isset($_SESSION['loggIn']) ? (int)(authorID($_SESSION['email'], $_SESSION['password'])) : -1;//id автора

	$artTitle ='';

	/*Формируем URL для возврата */
	if (!empty($_GET['idart']) && $_GET['idart'] !== '')
	{
		if ($_GET['typeart'] === 'viewnews' )
		{
			$select = 'SELECT newstitle as title FROM newsblock WHERE id = ';
			$URL = '//'.MAIN_URL.'/viewnews/?id='.$_GET['idart'];
			$linkText = 'К новости';
		}

		elseif ($_GET['typeart'] === 'viewpost' )
		{
			$select = 'SELECT posttitle as title FROM posts WHERE id = ';
			$URL = '//'.MAIN_URL.'/viewpost/?id='.$_GET['idart'];
			$linkText = 'К статье';
		} 

		elseif ($_GET['typeart'] === 'viewpromotion' )
		{
			$select = 'SELECT promotiontitle as title FROM promotion WHERE id = ';
			$URL = '//'.MAIN_URL.'/viewpromotion/?id='.$_GET['idart'];
			$linkText = 'К статье';
		} 

		elseif ($_GET['typeart'] === 'account' )
		{
			$select = 'SELECT authorname as title FROM author WHERE id = ';
			$URL = '//'.MAIN_URL.'/account/?id='.$_GET['idart'];
			$linkText = 'К профилю';
		} 

		elseif ($_GET['typeart'] === 'video' )
		{
			$select = 'SELECT videotitle as title FROM video WHERE id = ';
			$URL = '//'.MAIN_URL.'/video/?id='.$_GET['idart'];
			$linkText = 'К видео';
		} 

		elseif ($_GET['typeart'] === 'publication' )
		{
			$select = 'SELECT title FROM publication WHERE id = ';
			$URL = '//'.MAIN_URL.'/blog/publication/?id='.$_GET['idart'];
			$linkText = 'К записи';
		}

		else
		{
			$select = '';
			$URL = '#';
			$linkText = 'Не определено';
			$artTitle ='';
		}

		/*Подключение к базе данных*/
		include MAIN_FILE . '/includes/db.inc.php';

		/*Получение заголовка для ссылки */

		try
		{
			$sql = $select.$_GET['idart'];
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}

		catch (PDOException $e)
		{
			$error = 'Ошибка вывода записи';
			include MAIN_FILE . '/includes/error.inc.php';
		}

		$row = $s -> fetch();

		$artTitle = $row['title'];
	}

	else
	{
		$URL = '#';
		$linkText = 'Не определено';
	}

	$typeArt = $_GET['typeart'];
	$idArt = $_GET['idart'];
	
	
	// @session_start();//Открытие сессии для сохранения id статьи
	
	// $_SESSION['idcomment'] = $idComment;
	
	$select = 'SELECT 
		cm.id, 
		a.id AS idauthor, 
		cm.likescount,
		cm.dislikescount, 
		cm.comment, 
		cm.commentdate, 
		cm.imghead, 
		cm.imgalt, 
		cml.islike, 
		cml.isdislike, 
		a.avatar, 
		a.authorname 
	FROM comments cm
	INNER JOIN author a
	ON cm.idauthor = a.id 
	LEFT JOIN 
		(SELECT idauthor AS idauthorlk, idcomment, islike, isdislike
		FROM commentlikes WHERE idauthor = '.$selectedAuthor.') cml
	ON cm.id = cml.idcomment
	WHERE cm.id = ';
				
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	try
	{
		$sql = $select.$idComment;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка вывода записи';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	$row = $s -> fetch();
		
	$articleId = $row['id'];
	$authorId = $row['idauthor'];
	$articleText = $row['comment'];
	$imgHead = $row['imghead'];
	$imgAlt = $row['imgalt'];
	$date = $row['commentdate'];
	// $viewCount = $row['viewcount'];
	// $averageNumber = $row['averagenumber'];
	$nameAuthor = $row['authorname'];
	$avatar = $row['avatar'];
	$isLike = $row['islike'];
	$isDisLike = $row['isdislike'];
	$comment['id'] = $idComment;//Для лайков
	$comment['likescount'] = $row['likescount'];
	$comment['dislikescount'] = $row['dislikescount'];
	// $favouritesCount = $row['favouritescount'];

	/*Если страница отсутствует. Ошибка 404*/
	if (!$row)
	{
		header ('Location: ../page-not-found/');//перенаправление обратно в контроллер index.php
		exit();	
	}
	
	$title = 'Комментарий пользователя '. $row['authorname'].' | imagoz.ru';//Данные тега <title>
	$headMain = 'Комментарий к "<a href="'.$URL.'">'.implode(' ', array_slice(explode(' ', strip_tags($artTitle)), 0, 7)).'...</a>"';
	$robots = 'noindex, follow';
	$descr = '';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS
	
	/*Вывод ответов*/
	
	/*Постраничный вывод информации*/
		
	$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;// помещаем номер страницы из массива GET в переменую $page
	$onPage = 10;// количество статей на страницу
	$shift = ($page - 1) * $onPage;// (номер страницы - 1) * статей на страницу

	try
	{
		$sql = 'SELECT 
					scm.id, 
					a.id AS subidauthor, 
					scm.subcomment, 
					scm.subcommentdate,
					scm.likescount,
					scm.dislikescount, 
					a.authorname AS subauthorname,
					a.avatar AS subavatar,
					scml.islike, 
					scml.isdislike, 
					case 
						when cm.idnews is not null or cm.idnews <> 0 then cm.idnews 
						when cm.idpost is not null or cm.idpost <> 0 then cm.idpost
						when cm.idpromotion is not null or cm.idpromotion <> 0 then cm.idpromotion
						when cm.idaccount  is not null or cm.idaccount  <> 0 then cm.idaccount 
						when cm.idvideo is not null or cm.idvideo   <> 0 then cm.idvideo 
						when cm.idpublication is not null or cm.idpublication   <> 0 then cm.idpublication
					end as idart  
				FROM subcomments scm
		INNER JOIN author a 
		ON scm.idauthor = a.id 
		INNER JOIN comments cm
		ON scm.idcomment = cm.id
		LEFT JOIN 
			(SELECT idauthor AS idauthorlk, idsubcomment, islike, isdislike
			FROM subcommentlikes WHERE idauthor = '.$selectedAuthor.') scml
		ON scm.id = scml.idsubcomment
		WHERE scm.idcomment = '.$idComment.' ORDER BY scm.subcommentdate DESC LIMIT '.$shift.' ,'.$onPage;//Внизу самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка вывода ответов';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$subcomments[] =  array ('id' => $row['id'], 'text' => $row['subcomment'], 'date' => $row['subcommentdate'], 'subauthorname' => $row['subauthorname'],
										'likescount' => $row['likescount'], 'dislikescount' => $row['dislikescount'], 'subidauthor' => $row['subidauthor'], 'subavatar' => $row['subavatar'],
										'islike' => $row['islike'],	'isdislike' => $row['isdislike'], 'idart' => $row['idart']);
	}
	
	/*Определение количества статей*/
	$sql = "SELECT count(*) AS all_articles FROM subcomments WHERE idcomment = ".$idComment;
	$result = $pdo->query($sql);
	
	foreach ($result as $row)
	{
		$numPosts[] = array('all_articles' => $row['all_articles']);
	}

	$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));;//id автора

	/*Проверка пользователя на бан*/

	$isBlocked = checkBlockedAuthor($selectedAuthor);
	
	$countPosts = $row["all_articles"];
	$pagesCount = ceil($countPosts / $onPage);
	$previousPage = $page - 1;
	$nextPage = $page + 1;
	$secondLast = $pagesCount -1;
	$additData = '&id='.$idComment.'&typeart='.$typeArt.'&idart='.$idArt;
	
	include 'viewwallpost.html.php';
	exit();
}

/*Добавление комментария*/
if (isset ($_GET['addcomment']))
{
	$title = 'Добавить ответ | imagoz.ru';//Данные тега <title>
	$headMain = 'Добавить ответ';
	$robots = 'noindex, follow';
	$descr = 'Напишите ответ';
	$padgeTitle = 'Новый ответ';// Переменные для формы "Новая статья"
	$action = 'addform';	
	$text = '';
	$idauthor = '';
	$id = '';
	$button = 'Добавить ответ';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS
	
	if (isset($_SESSION['loggIn']))
	{
		$authorComment = authorLogin ($_SESSION['email'], $_SESSION['password']);//возвращает имя автора
		
		include 'subcommentform.html.php';
		exit();
	}	
	
	else
	{
		$title = 'Ошибка добавления ответа';//Данные тега <title>
		$headMain = 'Ошибка добавления ответа';
		$robots = 'noindex, follow';
		$descr = '';
		$commentError = '<a href="../admin/registration/?log">Авторизируйтесь</a> в системе или 
						 <a href="../admin/registration/?reg">зарегестрируйтесь</a> для того, чтобы написать ответ!';//Вывод сообщения в случае невхода в систему
		
		include 'commentfail.html.php';
		exit();
	}	
}

/*Обновление комментария*/
if (isset ($_POST['action']) && $_POST['action'] == 'Редактировать')
{		
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	try
	{
		$sql = 'SELECT * FROM subcomments  
		WHERE id = :idsubcomment';//Вверху самое последнее значение
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idsubcomment', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора ответа';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();	
	
	$title = 'Редактирование ответа | imagoz.ru';//Данные тега <title>
	$headMain = 'Редактирование ответа';
	$robots = 'noindex, follow';
	$descr = 'Форма редактирования ответа';
	$action = 'editform';	
	$text = $row['subcomment'];
	$idComment = $_POST['idcomment'];
	$typeArt = $_POST['typeart'];
	$idArt = $_POST['idart'];
	$id = $row['id'];
	$button = 'Обновить ответ';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS
	
	include 'subcommentform.html.php';
	exit();
}
	
/*команда INSERT  - добавление комментария в базу данных*/
if (isset($_GET['addform']))//Если есть переменная addform выводится форма
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
			
	/*Возвращение id автора*/
	$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));;//id автора
		
	try
	{
		$sql = 'INSERT INTO subcomments SET 
			subcomment = :subcomment,	
			subcommentdate = SYSDATE(),
			idauthor = '.$selectedAuthor.','.
			'idcomment = '.$_SESSION['idcomment'];
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':subcomment', $_POST['subcomment']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка добавления информации';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	/*Обновление счётчика ответов*/
	try
	{
		$sql = 'UPDATE comments SET 
			subcommentcount = subcommentcount + 1
			WHERE id = '.$_SESSION['idcomment'];
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idcomment', $_POST['id']);//отправка значения
		$s -> bindValue(':comment', $_POST['comment']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
		
	catch (PDOException $e)
	{
		$error = 'Ошибка обновления счётчика ответов';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	header ('Location: ../viewwallpost/?id='.$_POST['idcomment']);//перенаправление обратно в контроллер index.php
	exit();	
}
	
/*UPDATE - обновление текста комментария*/

if (isset($_GET['editform']))//Если есть переменная editform выводится форма
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'UPDATE subcomments SET 
			subcomment = :subcomment
			WHERE id = :idsubcomment';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idsubcomment', $_POST['id']);//отправка значения
		$s -> bindValue(':subcomment', $_POST['subcomment']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
		
	catch (PDOException $e)
	{
		$error = 'Ошибка обновления информации ответа';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	header ('Location: ../viewwallpost/?id='.$_POST['idcomment'].'&typeart='.$_POST['typeart'].'&idart='.$_POST['idart']);//перенаправление обратно в контроллер index.php
	exit();
}

/*DELETE - удаление комментария*/

if (isset ($_POST['action']) && $_POST['action'] == 'Del')	
{	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT id FROM subcomments WHERE id = :idsubcomment';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idsubcomment', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора id ответа';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$title = 'Удаление ответа';//Данные тега <title>
	$headMain = 'Удаление ответа';
	$robots = 'noindex, follow';
	$descr = '';
	$action = 'delete';
	$posttitle = 'Ответ';
	$id = $row['id'];
	$idComment = $_POST['idcomment'];
	$button = 'Удалить';
	
	include 'delete.html.php';
}
	
if (isset ($_GET['delete']))
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'DELETE FROM subcomments WHERE id = :idsubcomment';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idsubcomment', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления ответа';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	/*Обновление счётчика ответов*/
	try
	{
		$sql = 'UPDATE comments SET 
			subcommentcount = subcommentcount - 1
			WHERE id = :idcomment';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idcomment', $_POST['idcomment']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
		
	catch (PDOException $e)
	{
		$error = 'Ошибка обновления счётчика ответов';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	header ('Location: ../viewwallpost/?id='.$_POST['idcomment']);//перенаправление обратно в контроллер index.php
	exit();
}	
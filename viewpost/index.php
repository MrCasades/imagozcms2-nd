<?php
$pubFolder = 'viewpost'; //Папка скрипта

/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка общих переменных*/
include_once MAIN_FILE . '/includes/commonvar.inc.php';

/*Определение нахождения пользователя в системе*/
loggedIn();

/*Загрузка содержимого статьи*/
if (isset ($_GET['id']))
{
	$idPublication = $_GET['id'];
	
	$select = 'SELECT posts.id AS postid, author.id AS idauthor, post, posttitle, imghead, videoyoutube, viewcount, votecount, averagenumber, favouritescount, description, imgalt, postdate, authorname, category.id AS categoryid, categoryname FROM posts 
			   INNER JOIN author ON idauthor = author.id 
			   INNER JOIN category ON idcategory = category.id WHERE premoderation = "YES" AND zenpost = "NO" AND posts.id = ';
	
	/*Канонический адрес*/
	$canonicalURL = '<link rel="canonical" href="//'.MAIN_URL.'/viewpost/?id='.$idPublication.'"/>';


	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = $select.$idPublication;
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
	$authorId = $row['idauthor'];
	$articleText = $row['post'];
	$imgHead = $row['imghead'];
	$imgAlt = $row['imgalt'];
	$date = $row['postdate'];
	$viewCount = $row['viewcount'];
	$averageNumber = $row['averagenumber'];
	$nameAuthor = $row['authorname'];
	$categoryName = $row['categoryname'];
	$categoryId = $row['categoryid'];
	$favouritesCount = $row['favouritescount'];
	
	/*Если страница отсутствует. Ошибка 404*/
	if (!$row)
	{
		header ('Location: ../page-not-found/');//перенаправление обратно в контроллер index.php
		exit();	
	}
	
	$categoryID = $row['categoryid'];//Сохранение id сатегории
	
	$title = $row['posttitle'].' | imagoz.ru';//Данные тега <title>
	$headMain = $row['posttitle'];
	$robots = 'all';
	$descr = $row['description'];
	$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
	$breadPart2 = '<a href="//'.MAIN_URL.'/viewallposts/">Все статьи</a> >> ';//Для хлебных крошек
	$breadPart3 = '<a href="//'.MAIN_URL.'/viewpost/?id='.$idPublication.'">'.$row['posttitle'].'</a> ';//Для хлебных крошек
	$authorComment = '';
	//$jQuery = '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>';
	$scriptJScode = '<script src="//'.MAIN_URL.'/pubcommonfiles/script.js"></script>';//добавить код JS
	
	/*Микроразметка*/
	
	$dataMarkup = dataMarkup($row['posttitle'], $row['description'], $row['imghead'], $row['imgalt'], $row['postid'],
							$row['postdate'], $row['authorname'], $row['averagenumber'], $row['votecount'], '', '', 'viewpost');
	
	/*Вывод видео в статью*/
	if ((isset($row['videoyoutube'])) && ($row['videoyoutube'] != ''))
	{
		$video = codeInFrameVideo($row['videoyoutube']);
	}
	
	else
	{
		$video = '';
	}
	
	/*Кнопка добавления в избранное*/
	if (isset($_SESSION['loggIn']))
	{
		try
		{
			$sql = 'SELECT idpost FROM favourites WHERE idauthor = '.(authorID($_SESSION['email'], $_SESSION['password'])).' AND idpost = '.$idPublication;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}
		
		catch (PDOException $e)
		{
			$error = 'Ошибка выбора избранного';
			include MAIN_FILE . '/includes/error.inc.php';
		}

		$row = $s -> fetch();

		if (!empty($row['idpost']))
		{
			$addFavourites = '<form action=" " metod "post" id = "ajax_form_fav">
								<input type = "hidden" name = "pb_type" id = "pb_type" value = "post">
								<input type = "hidden" name = "idauthor" value = "'.(authorID($_SESSION['email'], $_SESSION['password'])).'">
								<input type = "hidden" name = "id" value = "'.$idPublication.'">
								<input type = "hidden" id = "val_fav" name = "val_fav" value = "delfav">
								<button id = "btn_fav" title="Убрать из избранного" class = btn_fav_2><i class="fa fa-check-square" aria-hidden="true"></i> Избранное</button>  
							</form>
							<strong><p id = "result_form_fav"></p></strong>';
		}

		else
		{
			$addFavourites = '<form action=" " metod "post" id = "ajax_form_fav">
								<input type = "hidden" name = "pb_type" id = "pb_type" value = "post">
								<input type = "hidden" name = "idauthor" value = "'.(authorID($_SESSION['email'], $_SESSION['password'])).'">
								<input type = "hidden" name = "id" value = "'.$idPublication.'">
								<input type = "hidden" id = "val_fav" name = "val_fav" value = "addfav">
								<button id = "btn_fav" title="Добавить в избранное" class = btn_fav_1><i class="fa fa-check-square" aria-hidden="true"></i> Избранное</button> 
							</form>
							<strong><p id = "result_form_fav"></p></strong>';
		}
	}
	
	else
	{
		$addFavourites = '';
	}
	
	/*Обновление значения счётчика*/
	
	$updateCount = 'UPDATE posts SET viewcount = viewcount + 1 WHERE id = ';
	
	try
	{
		$sql = $updateCount.$idPublication;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка счётчика';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	/*Вывод тематик(тегов)*/
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT m.id, m.metaname FROM meta m
				INNER JOIN metapost mp ON m.id = mp.idmeta 
				WHERE mp.idpost = '.$idPublication;//Вверху самое последнее значение
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
	
 /*Скрипт оценки статьи*/

	/*Вывод панели оценок*/
		
	/*Возвращение id автора*/
		
	/*Подключение к базе данных*/
	$selectedAuthor = isset($_SESSION['loggIn']) ? (int)(authorID($_SESSION['email'], $_SESSION['password'])) : -1;//id автора
	
	$votedPost = (int)$idPublication;
	
	try
	{
		$sql = 'SELECT idauthor, idpost FROM votedauthor WHERE idauthor = '.$selectedAuthor.' AND idpost = '.$votedPost;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора данных из votedauthor';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
		
	$votedAuthor = empty ($row['idauthor']) ? '' : (int)$row['idauthor'];
	$votedPost = empty($row['idpost']) ? '' : (int)$row['idpost'];
	
	/*Условия вывода панели голосования*/
	if (($votedAuthor == $selectedAuthor) && ($votedPost == $idPublication) || (!isset($_SESSION['loggIn'])))
	{
		$votePanel = '';
	}
	
	elseif ((isset($_SESSION['loggIn'])) && ($votedAuthor != $selectedAuthor))
	{
		$votePanel = '<form action=" " metod "post" id = "confirmlike">
						<i class="fa fa-thumbs-up" aria-hidden="true" title="Оценить"></i>
						<input type = "hidden" name = "pb_type" id = "pb_type" value = "post">
						<input type = "hidden" name = "id" id = "idarticle" value = "'.$idPublication.'">
						<input type = "hidden" name = "idauthor" id = "idauthor" value = "'.$selectedAuthor.'">
						<input type = "submit" name = "vote" id = "btn_vot_5" class = "btn_vot" value = "5"> 
						<input type = "submit" name = "vote" id = "btn_vot_4" class = "btn_vot" value = "4"> 
						<input type = "submit" name = "vote" id = "btn_vot_3" class = "btn_vot" value = "3"> 
						<input type = "submit" name = "vote" id = "btn_vot_2" class = "btn_vot" value = "2"> 
						<input type = "submit" name = "vote" id = "btn_vot_1" class = "btn_vot" value = "1"> 
					</form>
					<strong><p id = "result_form_vot"></p></strong>';
	}
	
	/*Вывод кнопок "Обновить" | "Удалить" | "Снять с публикации"(Возможно убрать эту кнопку для всех, кромке админа и редактора)"*/
	
	if ((isset($_SESSION['loggIn'])) && (userRole('Администратор')))
	{
		$delAndUpd = "<form action = '../admin/addupdpost/' method = 'post'>
			
						Действия с материалом:
						<input type = 'hidden' name = 'id' value = '".$idPublication."'>
						<input type = 'submit' name = 'action' value = 'Upd' class='btn_1'>
						<input type = 'submit' name = 'action' value = 'Del' class='btn_2'>
					  </form>";
		
		$premoderation = "<form action = '../admin/premoderation/postpremoderationstatus/' method = 'post'>
			
						Статус публикации:
						<input type = 'hidden' name = 'id' value = '".$idPublication."'>
						<input type = 'submit' name = 'action' value = 'Снять с публикации' class='btn_3'>
					  </form>";				
	}
	
	else
	{
		$delAndUpd = '';
		$premoderation = '';
	}	
	
	/*Вывод кнопки "Рекомендовать статью"*/
	if (isset($_SESSION['loggIn']) && ((userRole('Администратор')) || (userRole('Автор')) || (userRole('Рекламодатель'))))
	{
		/*Команда SELECT выбор цены промоушена*/
		try
		{
			$sql = 'SELECT promotionprice FROM promotionprice WHERE id = 2';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}

		catch (PDOException $e)
		{
			$error = 'Ошибка выбора цены рекомендации';
			include MAIN_FILE . '/includes/error.inc.php';
		}

		$row = $s -> fetch();

		$recommendationPrice = $row['promotionprice'];
		
		$recommendation = '<form action = "" method = "post" id = "ajax_form_recomm">
								<input type = "hidden" name = "pb_type" id = "pb_type" value = "post">
								<input type = "hidden" name = "id" id = "idarticle" value = "'.$idPublication.'">
								<input type = "hidden" name = "recommprice" id = "recommprice" value = "'.$recommendationPrice.'">
								<input type = "hidden" name = "idauthor" id = "idauthor" value = "'.$selectedAuthor.'">
								<button id = "btn_recomm" title="Рекомендовать статью" class = btn_recomm><i class="fa fa-bell" aria-hidden="true"></i> Рекомендовать статью</button>
							</form>
							<strong><p id = "result_form_recomm"></p></strong>';
	}
	
	elseif (isset($_SESSION['loggIn']) && ((!userRole('Администратор')) || (!userRole('Автор')) || (!userRole('Рекламодатель'))))
	{
		$recommendation = '<strong>Получите статус рекламодателя в профиле, чтобы получить возможность рекомендовать статью.</strong>';
	}
	
	elseif (!isset($_SESSION['loggIn']))
	{
		// $recommendation = '<span class="recomm-nolog-txt">Вы можете <a href="../admin/registration/?log">авторизироваться</a> в системе или 
		// 				 <a href="../admin/registration/?reg">зарегестрироваться</a> для того, чтобы рекомендовать статью на главной странице!</span>'
		
		$recommendation = '';
	}
	
	/*Вывод похожих материалов*/

	similarPublication('post', $categoryID);

	/*Проверка пользователя на бан*/

	$isBlocked = checkBlockedAuthor($selectedAuthor);
	
	/*Вывод комментариев*/	
	include_once MAIN_FILE . '/includes/showcomments.inc.php';

	showComments('post', 'idpost', $idPublication);
	
	if($categoryName === 'Изображение дня')
		include '../pubcommonfiles/viewimageday.html.php';//Шаблон для изображения дня
	else
		include '../pubcommonfiles/viewpublication.html.php';//Шаблон для статьи
	exit();		
}
	
/*Обновление комментария*/
if (isset ($_POST['action']) && $_POST['action'] == 'Редактировать')
{		
	updCommentData($_POST['id'], $_POST['idarticle']);
	
	include '../pubcommonfiles/form.html.php';
	exit();
}
	
/*команда INSERT  - добавление комментария в базу данных перенесено в addcomment*/
	
/*UPDATE - обновление текста комментария*/

if (isset($_GET['editform']))//Если есть переменная editform выводится форма
{
	updComment($_POST['id'], $_POST['comment'], $_POST['idarticle'], 'post');
}

/*DELETE - удаление комментария*/

if (isset ($_POST['action']) && $_POST['action'] == 'Del')	
{	
	delCommentData($_POST['id'], $_POST['idarticle']);
	
	include '../pubcommonfiles/delete.html.php';
}
	
if (isset ($_GET['delete']))
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	$SELECTCONTEST = 'SELECT conteston FROM contest WHERE id = 1';//проверка включения/выключения конкурса
	
	/*Если конкурс включён, происходит изменение конкурсного счёта*/
	if ($contestOn == 'YES') delOrAddContestScore('del', 'commentpoints');//если конкурс включен
	
	/*Удаление комментариев*/
	try
	{
		$pdo->beginTransaction();//инициация транзакции
		
		$sql = 'DELETE FROM comments WHERE id = :idcomment';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idcomment', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		$sql = $SELECTCONTEST;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			
		$row = $s -> fetch();
		
		$contestOn = $row['conteston'];//проверка на включение конкурса
		
		/*Если конкурс включён, происходит изменение конкурсного счёта*/
		if ($contestOn == 'YES') delOrAddContestScore('del', 'commentpoints');//если конкурс включен
		
		$pdo->commit();//подтверждение транзакции	
	}
	
	catch (PDOException $e)
	{
		$pdo->rollBack();//отмена транзакции

		$error = 'Ошибка удаления информации';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	/*Удаление ответов*/
	try
	{
		$sql = 'DELETE FROM subcomments WHERE idcomment = :idcomment' ;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idcomment', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления ответов';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	header ('Location: ../viewpost/?id='.$_POST['idarticle']);//перенаправление обратно в контроллер index.php
	exit();
}	
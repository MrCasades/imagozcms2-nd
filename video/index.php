<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

/*Загрузка содержимого статьи*/
if (isset ($_GET['id']))
{
	$idVideo = $_GET['id'];
	
	$select = 'SELECT 
					v.id AS videoid, 
					a.id AS idauthor, 
					v.post, 
					v.videotitle, 
					v.imghead, 
					v.videoyoutube, 
					v.videofile, 
					v.viewcount, 
					v.votecount, 
					v.averagenumber, 
					v.favouritescount, 
					v.description, 
					v.imgalt, 
					v.videodate, 
					a.authorname, 
					c.id AS categoryid, 
					c.categoryname 
			   FROM video v
			   INNER JOIN author a ON v.idauthor = a.id 
			   INNER JOIN category c ON v.idcategory = c.id WHERE premoderation = "YES" AND v.id = ';
	
	/*Канонический адрес*/
	if(!empty($_GET['utm_referrer']) || !empty($_GET['page']))
	{
		$canonicalURL = '<link rel="canonical" href="//'.MAIN_URL.'/video/?id='.$idVideo.'"/>';
	}

	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = $select.$idVideo;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода содержимого видео ';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
		
	$articleId = $row['videoid'];
	$authorId = $row['idauthor'];
	$articleText = $row['post'];
	$imgHead = $row['imghead'];
	$imgAlt = $row['imgalt'];
	$date = $row['videodate'];
	$viewCount = $row['viewcount'];
	$averageNumber = $row['averagenumber'];
	$nameAuthor = $row['authorname'];
	$categoryName = $row['categoryname'];
	$categoryId = $row['categoryid'];
	$favouritesCount = $row['favouritescount'];
	$videoYoutube = $row['videoyoutube'];
	$videoFile = $row['videofile'];
	
	/*Если страница отсутствует. Ошибка 404*/
	if (!$row)
	{
		header ('Location: ../page-not-found/');//перенаправление обратно в контроллер index.php
		exit();	
	}
	
	$categoryID = $row['categoryid'];//Сохранение id сатегории
	
	$title = $row['videotitle'].' | imagoz.ru';//Данные тега <title>
	$headMain = $row['videotitle'];
	$robots = 'all';
	$descr = $row['description'];
	$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
	$breadPart2 = '<a href="//'.MAIN_URL.'/viewallvideos/">Все видео</a> >> ';//Для хлебных крошек
	$breadPart3 = '<a href="//'.MAIN_URL.'/video/?id='.$idVideo.'">'.$row['videotitle'].'</a> ';//Для хлебных крошек
	$authorComment = '';
	//$jQuery = '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS
	
	/*Микроразметка*/
	
	$dataMarkup = dataMarkup($row['videotitle'], $row['description'], $row['imghead'], $row['imgalt'], $row['videoid'],
							$row['videodate'], $row['authorname'], $row['averagenumber'], $row['votecount'], 'video');
	
	/*Вывод видео в статью*/
	if ((isset($row['videoyoutube'])) && ($row['videoyoutube'] != ''))
	{
		$video = '<iframe width="85%" height="320px" src="'.$row['videoyoutube'].'" frameborder="0" allowfullscreen></iframe>';
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
			$sql = 'SELECT idvideo FROM favourites WHERE idauthor = '.(authorID($_SESSION['email'], $_SESSION['password'])).' AND idvideo = '.$idVideo;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}
		
		catch (PDOException $e)
		{
			$error = 'Ошибка выбора избранного ';
			include MAIN_FILE . '/includes/error.inc.php';
		}

		$row = $s -> fetch();

		if (!empty($row['idpost']))
		{
			$addFavourites = '<form action=" " metod "post" id = "ajax_form_fav">
								<input type = "hidden" name = "idauthor" value = "'.(authorID($_SESSION['email'], $_SESSION['password'])).'">
								<input type = "hidden" name = "id" value = "'.$idVideo.'">
								<input type = "hidden" id = "val_fav" name = "val_fav" value = "delfav">
								<button id = "btn_fav" title="Убрать из избранного" class = btn_fav_2><i class="fa fa-check-square" aria-hidden="true"></i> Избранное</button>  
							</form>
							<strong><p id = "result_form_fav"></p></strong>';
		}

		else
		{
			$addFavourites = '<form action=" " metod "post" id = "ajax_form_fav">
								<input type = "hidden" name = "idauthor" value = "'.(authorID($_SESSION['email'], $_SESSION['password'])).'">
								<input type = "hidden" name = "id" value = "'.$idVideo.'">
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
	
	$updateCount = 'UPDATE video SET viewcount = viewcount + 1 WHERE id = ';
	
	try
	{
		$sql = $updateCount.$idVideo;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка счётчика ';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	/*Вывод тематик(тегов)*/
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT 
					m.id, 
					m.metaname 
				FROM video v 
				INNER JOIN metapost mp ON v.id = mp.idvideo 
				INNER JOIN meta m ON m.id = mp.idmeta 
				WHERE v.id = '.$idVideo;//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода списка тегов ';
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
	if (isset($_SESSION['loggIn']))
	{
		$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));;//id автора
	}
		
	else
	{
		$selectedAuthor = 0;//id автора
	}
	
	$votedPost = (int)$idVideo;
	
	try
	{
		$sql = 'SELECT idauthor, idvideo FROM votedauthor WHERE idauthor = '.$selectedAuthor.' AND idvideo = '.$votedPost;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора данных из votedauthor ';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();

	$votedAuthor = empty($row['idauthor']) ? '' : (int)$row['idauthor'];

	$votedPost = empty($row['idvideo']) ? '' : (int)$row['idvideo'];
				
	/*Условия вывода панели голосования*/
	if (($votedAuthor == $selectedAuthor) && ($votedPost == $idVideo) || (!isset($_SESSION['loggIn'])))
	{
		$votePanel = '';
	}
	
	elseif ((isset($_SESSION['loggIn'])) && ($votedAuthor != $selectedAuthor))
	{
		$votePanel = '<form action=" " metod "post" id = "confirmlike">
						<i class="fa fa-thumbs-up" aria-hidden="true" title="Оценить"></i>
						<input type = "hidden" name = "id" id = "idarticle" value = "'.$idVideo.'">
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
		$delAndUpd = "<form action = '../admin/addupdvideo/' method = 'post'>
			
						Действия с материалом:
						<input type = 'hidden' name = 'id' value = '".$idVideo."'>
						<input type = 'submit' name = 'action' value = 'Upd' class='btn_1'>
						<input type = 'submit' name = 'action' value = 'Del' class='btn_2'>
					  </form>";
		
		$premoderation = "<form action = '../admin/premoderation/postpremoderationstatus/' method = 'post'>
			
						Статус публикации:
						<input type = 'hidden' name = 'id' value = '".$idVideo."'>
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
			$error = 'Ошибка выбора цены рекомендации ';
			include MAIN_FILE . '/includes/error.inc.php';
		}

		$row = $s -> fetch();

		$recommendationPrice = $row['promotionprice'];
	
		$recommendation = '<form action = "" method = "post" id = "ajax_form_recomm">
							<input type = "hidden" name = "id" id = "idarticle" value = "'.$idVideo.'">
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
		$recommendation = '<span class="recomm-nolog-txt">Вы можете <a href="../admin/registration/?log">авторизироваться</a> в системе или 
						 <a href="../admin/registration/?reg">зарегестрироваться</a> для того, чтобы рекомендовать статью на главной странице!</span>';
	}
	
	/*Вывод похожих материалов*/

	try
	{
		$sql = 'SELECT id, videotitle, imghead, imgalt FROM video WHERE idcategory = '.$categoryID.' AND premoderation = "YES" ORDER BY rand() LIMIT 6';
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода заголовка похожей статьи ';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$similarPosts[] =  array ('id' => $row['id'], 'videotitle' =>  $row['videotitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt']);
	}	
			
	/*Вывод комментариев*/	
	include_once MAIN_FILE . '/includes/showcomments.inc.php';

	showComments('video', 'idvideo', $idVideo);
	
	include 'video.html.php';//Шаблон для видео
	exit();		
}
	
/*Обновление комментария*/
if (isset ($_POST['action']) && $_POST['action'] == 'Редактировать')
{		
	updCommentData($_POST['id'], $_POST['idarticle']);
	
	include 'form.html.php';
	exit();
}
	
/*команда INSERT  - добавление комментария в базу данных перенесено в addcomment*/
	
/*UPDATE - обновление текста комментария*/

if (isset($_GET['editform']))//Если есть переменная editform выводится форма
{
	updComment($_POST['id'], $_POST['comment'], $_POST['idarticle'], 'video');
}

/*DELETE - удаление комментария*/

if (isset ($_POST['action']) && $_POST['action'] == 'Del')	
{	
	delCommentData($_POST['id'], $_POST['idarticle']);
	
	include 'delete.html.php';
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

		$error = 'Ошибка удаления информации ';
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
		$error = 'Ошибка удаления ответов ';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	header ('Location: ../video/?id='.$_POST['idarticle']);//перенаправление обратно в контроллер index.php
	exit();
}	
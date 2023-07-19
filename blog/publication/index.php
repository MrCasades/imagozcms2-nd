<?php
$pubFolder = 'publication'; //Папка скрипта

/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

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
	$idPub = $_GET['id'];
	
	$select = 'SELECT 
					p.id AS pubid, 
					a.id AS idauthor, 
					p.text, 
					p.title, 
					p.imghead, 
					p.videoyoutube, 
					p.viewcount, 
					p.votecount, 
					p.averagenumber,  
					p.description, 
					p.imgalt, 
					p.date, 
					p.idblog,
					a.authorname, 
					c.id AS categoryid, 
					c.categoryname,
					b.title AS blogtitle
				FROM publication p
				INNER JOIN author a ON p.idauthor = a.id 
				INNER JOIN blogs b ON b.idauthor = p.idauthor 
				LEFT JOIN category c ON p.idcategory = c.id 
				WHERE p.premoderation = "YES" AND p.id = ';
	
	/*Канонический адрес*/
	if(!empty($_GET['utm_referrer']) || !empty($_GET['page']))
	{
		$canonicalURL = '<link rel="canonical" href="//'.MAIN_URL.'/blog/publication?id='.$idPub.'"/>';
	}

	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = $select.$idPub;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода содержимого публикации';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
		
	$articleId = $row['pubid'];
	$authorId = $row['idauthor'];
	$articleText = $row['text'];
	$imgHead = $row['imghead'];
	$imgAlt = $row['imgalt'];
	$date = $row['date'];
	$viewCount = $row['viewcount'];
	$averageNumber = $row['averagenumber'];
	$nameAuthor = $row['authorname'];
	$categoryName = $row['categoryname'];
	$categoryId = $row['categoryid'];
	//$favouritesCount = $row['favouritescount'];

	$blogTitle = $row['blogtitle'];
	$blogId = $row['idblog'];
	
	/*Если страница отсутствует. Ошибка 404*/
	if (!$row)
	{
		header ('Location: ../page-not-found/');//перенаправление обратно в контроллер index.php
		exit();	
	}

	/*Инициализация блога*/
	require_once MAIN_FILE . '/includes/blogvar.inc.php';

	/*Получение атрибутов блога для шапки */
	getBlogAtributs($blogId);
	
	$categoryID = $row['categoryid'];//Сохранение id сатегории
	
	$title = $row['title'].' | imagoz.ru';//Данные тега <title>
	$headMain = $row['title'];
	$robots = 'all';
	$descr = $row['description'];
	$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
	$breadPart2 = '<a href="//'.MAIN_URL.'/blog?id='.$blogId.'">Блог "'.$blogTitle.'"</a> >> ';//Для хлебных крошек
	$breadPart3 = '<a href="//'.MAIN_URL.'/blog/publication?id='.$idPub.'">'.$row['title'].'</a> ';//Для хлебных крошек
	$authorComment = '';
	//$jQuery = '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>';
	$scriptJScode = '<script src="//'.MAIN_URL.'/pubcommonfiles/script.js"></script>';//добавить код JS
	
	/*Микроразметка*/
	
	$dataMarkup = dataMarkup($row['title'], $row['description'], $row['imghead'], $row['imgalt'], $row['pubid'],
							$row['date'], $row['authorname'], $row['averagenumber'], $row['votecount'], '', '', 'blog/publication');
	
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
	// if (isset($_SESSION['loggIn']))
	// {
	// 	try
	// 	{
	// 		$sql = 'SELECT idpost FROM favourites WHERE idauthor = '.(authorID($_SESSION['email'], $_SESSION['password'])).' AND idpost = '.$idPost;
	// 		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	// 		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	// 	}
		
	// 	catch (PDOException $e)
	// 	{
	// 		$error = 'Ошибка выбора избранного';
	// 		include MAIN_FILE . '/includes/error.inc.php';
	// 	}

	// 	$row = $s -> fetch();

	// 	if (!empty($row['idpost']))
	// 	{
	// 		$addFavourites = '<form action=" " metod "post" id = "ajax_form_fav">
	// 							<input type = "hidden" name = "idauthor" value = "'.(authorID($_SESSION['email'], $_SESSION['password'])).'">
	// 							<input type = "hidden" name = "id" value = "'.$idPost.'">
	// 							<input type = "hidden" id = "val_fav" name = "val_fav" value = "delfav">
	// 							<button id = "btn_fav" title="Убрать из избранного" class = btn_fav_2><i class="fa fa-check-square" aria-hidden="true"></i> Избранное</button>  
	// 						</form>
	// 						<strong><p id = "result_form_fav"></p></strong>';
	// 	}

	// 	else
	// 	{
	// 		$addFavourites = '<form action=" " metod "post" id = "ajax_form_fav">
	// 							<input type = "hidden" name = "idauthor" value = "'.(authorID($_SESSION['email'], $_SESSION['password'])).'">
	// 							<input type = "hidden" name = "id" value = "'.$idPost.'">
	// 							<input type = "hidden" id = "val_fav" name = "val_fav" value = "addfav">
	// 							<button id = "btn_fav" title="Добавить в избранное" class = btn_fav_1><i class="fa fa-check-square" aria-hidden="true"></i> Избранное</button> 
	// 						</form>
	// 						<strong><p id = "result_form_fav"></p></strong>';
	// 	}
	// }
	
	// else
	// {
	// 	$addFavourites = '';
	// }
	
	/*Обновление значения счётчика*/
	
	$updateCount = 'UPDATE publication SET viewcount = viewcount + 1 WHERE id = ';
	
	try
	{
		$sql = $updateCount.$idPub;
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
		$sql = 'SELECT meta.id, metaname FROM publication 
				INNER JOIN metapost ON publication.id = idpublication 
				INNER JOIN meta ON meta.id = idmeta 
				WHERE publication.id = '.$idPub;//Вверху самое последнее значение
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
	if (isset($_SESSION['loggIn']))
	{
		$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));;//id автора
	}
		
	else
	{
		$selectedAuthor = 0;//id автора
	}
	
	$votedPost = (int)$idPub;
	
	try
	{
		$sql = 'SELECT idauthor, idpublication FROM votedauthor WHERE idauthor = '.$selectedAuthor.' AND idpublication = '.$votedPost;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора id';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
		
	$votedAuthor = empty ($row['idauthor']) ? '' : (int)$row['idauthor'];
	$votedPost = empty($row['idpublication']) ? '' : (int)$row['idpublication'];
	
	/*Условия вывода панели голосования*/
	if (($votedAuthor == $selectedAuthor) && ($votedPost == $idPub) || (!isset($_SESSION['loggIn'])))
	{
		$votePanel = '';
	}
	
	elseif ((isset($_SESSION['loggIn'])) && ($votedAuthor != $selectedAuthor))
	{
		$votePanel = '<form action=" " metod "post" id = "confirmlike">
						<i class="fa fa-thumbs-up" aria-hidden="true" title="Оценить"></i>
						<input type = "hidden" name = "pb_type" id = "pb_type" value = "publication">
						<input type = "hidden" name = "id" id = "idarticle" value = "'.$idPub.'">
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
		$delAndUpd = "<form action = '../admin/addupdblogpublication/' method = 'post'>
			
						Действия с материалом:
						<input type = 'hidden' name = 'id' value = '".$idPub."'>
						<input type = 'submit' name = 'action' value = 'Upd' class='btn_1'>
						<input type = 'submit' name = 'action' value = 'Del' class='btn_2'>
					  </form>";
		
		$premoderation = "<form action = '../admin/premoderation/postpremoderationstatus/' method = 'post'>
			
						Статус публикации:
						<input type = 'hidden' name = 'id' value = '".$idPub."'>
						<input type = 'submit' name = 'action' value = 'Снять с публикации' class='btn_3'>
					  </form>";				
	}
	
	else
	{
		$delAndUpd = '';
		$premoderation = '';
	}	
	
	/*Вывод кнопки "Рекомендовать статью"*/
	// if (isset($_SESSION['loggIn']) && ((userRole('Администратор')) || (userRole('Автор')) || (userRole('Рекламодатель'))))
	// {
	// 	/*Команда SELECT выбор цены промоушена*/
	// try
	// {
	// 	$sql = 'SELECT promotionprice FROM promotionprice WHERE id = 2';
	// 	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	// 	$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	// }

	// catch (PDOException $e)
	// {
	// 	$robots = 'noindex, nofollow';
	// 	$descr = '';
	// 	$error = 'ошибка выбора цены рекомендации: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
	// 	include 'error.html.php';
	// 	exit();
	// 	}

	// 	$row = $s -> fetch();

	// 	$recommendationPrice = $row['promotionprice'];
	
	// 	$recommendation = '<form action = "" method = "post" id = "ajax_form_recomm">
	// 						<input type = "hidden" name = "id" id = "idarticle" value = "'.$idPub.'">
	// 						<input type = "hidden" name = "recommprice" id = "recommprice" value = "'.$recommendationPrice.'">
	// 						<input type = "hidden" name = "idauthor" id = "idauthor" value = "'.$selectedAuthor.'">
	// 						<button id = "btn_recomm" title="Рекомендовать статью" class = btn_recomm><i class="fa fa-bell" aria-hidden="true"></i> Рекомендовать статью</button>
	// 					</form>
	// 					<strong><p id = "result_form_recomm"></p></strong>';
	// }
	
	// elseif (isset($_SESSION['loggIn']) && ((!userRole('Администратор')) || (!userRole('Автор')) || (!userRole('Рекламодатель'))))
	// {
	// 	$recommendation = '<strong>Получите статус рекламодателя в профиле, чтобы получить возможность рекомендовать статью.</strong>';
	// }
	
	// elseif (!isset($_SESSION['loggIn']))
	// {
	// 	// $recommendation = '<span class="recomm-nolog-txt">Вы можете <a href="../admin/registration/?log">авторизироваться</a> в системе или 
	// 	// 				 <a href="../admin/registration/?reg">зарегестрироваться</a> для того, чтобы рекомендовать статью на главной странице!</span>'
		
	// 	$recommendation = '';
	// }
	
	/*Вывод похожих материалов*/

	/*Вывод похожих материалов*/

	similarPublication('post', $categoryID);
	
	/*Вывод комментариев*/	
	include_once MAIN_FILE . '/includes/showcomments.inc.php';

	showComments('publication', 'idpublication', $idPub);
	
	include '../../pubcommonfiles/viewpublication.html.php';//Шаблон для статьи
	exit();		
}
	
/*Обновление комментария*/
if (isset ($_POST['action']) && $_POST['action'] == 'Редактировать')
{		
	updCommentData($_POST['id'], $_POST['idarticle']);
	
	include '../../pubcommonfiles/form.html.php';
	exit();
}
	
/*команда INSERT  - добавление комментария в базу данных перенесено в addcomment*/
	
/*UPDATE - обновление текста комментария*/

if (isset($_GET['editform']))//Если есть переменная editform выводится форма
{
	updComment($_POST['id'], $_POST['comment'], $_POST['idarticle'], 'publication');
}

/*DELETE - удаление комментария*/

if (isset ($_POST['action']) && $_POST['action'] == 'Del')	
{	
	delCommentData($_POST['id'], $_POST['idarticle']);
	
	include '../../pubcommonfiles/delete.html.php';
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
		
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка удаления информации '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
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
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка удаления ответов '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	header ('Location: ../viewpost/?id='.$_POST['idarticle']);//перенаправление обратно в контроллер index.php
	exit();
}	
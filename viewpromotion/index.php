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
	$idPromotion = $_GET['id'];
	
	$select = 'SELECT promotion.id AS promotionid, author.id AS idauthor, promotion, promotiontitle, imghead, videoyoutube, promotion.www, viewcount, votecount, averagenumber, description, imgalt, promotiondate, authorname, category.id AS categoryid, categoryname FROM promotion 
			   INNER JOIN author ON idauthor = author.id 
			   INNER JOIN category ON idcategory = category.id WHERE premoderation = "YES" AND promotion.id = ';
	
	/*Канонический адрес*/
	if(!empty($_GET['utm_referrer']) || !empty($_GET['page']))
	{
		$canonicalURL = '<link rel="canonical" href="//'.MAIN_URL.'/viewpromotion/?id='.$idPromotion.'"/>';
	}
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = $select.$idPromotion;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка вывода содержимого статьи ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
		
	$articleId = $row['promotionid'];
	$authorId = $row['idauthor'];
	$articleText = $row['promotion'];
	$imgHead = $row['imghead'];
	$imgAlt = $row['imgalt'];
	$www = $row['www'];
	$date = $row['promotiondate'];
	$viewCount = $row['viewcount'];
	$averageNumber = $row['averagenumber'];
	$nameAuthor = $row['authorname'];
	$categoryName = $row['categoryname'];
	$categoryId = $row['categoryid'];
	
	/*Если страница отсутствует. Ошибка 404*/
	if (!$row)
	{
		header ('Location: ../page-not-found/');//перенаправление обратно в контроллер index.php
		exit();	
	}
	
	$categoryID = $row['categoryid'];//Сохранение id сатегории
	
	$title = $row['promotiontitle'].' | imagoz.ru';//Данные тега <title>
	$headMain = $row['promotiontitle'];
	$robots = 'all';
	$descr = $row['description'];
	$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
	$breadPart2 = '<a href="//'.MAIN_URL.'/viewallpromotion/">Весь промоушен</a> >> ';//Для хлебных крошек
	$breadPart3 = '<a href="//'.MAIN_URL.'/viewpromotion/?id='.$idPromotion.'">'.$row['promotiontitle'].'</a> ';//Для хлебных крошек
	$authorComment = '';
	//$jQuery = '';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS
	
	/*Микроразметка*/
	
	$dataMarkup = dataMarkup($row['promotiontitle'], $row['description'], $row['imghead'], $row['imgalt'], $row['promotionid'],
							$row['promotiondate'], $row['authorname'], $row['averagenumber'], $row['votecount'], 'viewpromotion');
	
	/*Вывод видео в статью*/
	if ((isset($row['videoyoutube'])) && ($row['videoyoutube'] != ''))
	{
		$video = '<iframe width="85%" height="320px" src="'.$row['videoyoutube'].'" frameborder="0" allowfullscreen></iframe>';
	}
	
	else
	{
		$video = '';
	}
	
	/*Обновление значения счётчика*/
	
	$updateCount = 'UPDATE promotion SET viewcount = viewcount + 1 WHERE id = ';
	
	try
	{
		$sql = $updateCount.$idPromotion;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка счётчика ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	/*Вывод тематик(тегов)*/
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT meta.id, metaname FROM promotion 
				INNER JOIN metapost ON promotion.id = idpromotion 
				INNER JOIN meta ON meta.id = idmeta 
				WHERE promotion.id = '.$idPromotion;//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка вывода списка тегов ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
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

	$votedPost = (int)$idPromotion;
	
	try
	{
		$sql = 'SELECT idauthor, idpromotion FROM votedauthor WHERE idauthor = '.$selectedAuthor.' AND idpromotion = '.$votedPost;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора данных из votedauthor ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
		
	if(empty ($row['idauthor']))
	{		
		$votedAuthor = '';
	}
	
	else
	{
		$votedAuthor = (int)$row['idauthor'];;//id автора, который проголосовал
	}	
	
	if (empty ($row['idpromotion']))//если переменная отсутствует
	{
		$votedPost = '';
	}
	
	else
	{		
		$votedPost = (int)$row['idpromotion'];//id статьи, за которую проголосовали
	}
	
	/*Условия вывода панели голосования*/
	if (($votedAuthor == $selectedAuthor) && ($votedPost == $idPromotion) || (!isset($_SESSION['loggIn'])))
	{
		$votePanel = '';
	}
	
	elseif ((isset($_SESSION['loggIn'])) && ($votedAuthor != $selectedAuthor))
	{
		$votePanel = '<form action=" " metod "post" id = "confirmlike">
						<i class="fa fa-thumbs-up" aria-hidden="true" title="Оценить"></i>
						<input type = "hidden" name = "id" id = "idarticle" value = "'.$idPromotion.'">
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
		$delAndUpd = "<form action = '../admin/addupdpromotion/' method = 'post'>
			
						Действия с материалом:
						<input type = 'hidden' name = 'id' value = '".$idPromotion."'>
						<input type = 'submit' name = 'action' value = 'Upd' class='btn_1'>
						<input type = 'submit' name = 'action' value = 'Del' class='btn_2'>
					  </form>";
		
		$premoderation = "<form action = '../admin/premoderation/promotionpremoderationstatus/' method = 'post'>
			
						Статус публикации:
						<input type = 'hidden' name = 'id' value = '".$idPromotion."'>
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
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'ошибка выбора цены рекомендации: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
		}

		$row = $s -> fetch();

		$recommendationPrice = $row['promotionprice'];
	
		$recommendation = '<form action = "" method = "post" id = "ajax_form_recomm">
							<input type = "hidden" name = "id" id = "idarticle" value = "'.$idPromotion.'">
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
		$recommendation = '<strong>Вы можете <a href="../admin/registration/?log">авторизироваться</a> в системе или 
						 <a href="../admin/registration/?reg">зарегестрироваться</a> для того, чтобы рекомендовать статью на главной странице!</strong>';
	}
	
	/*Вывод похожих материалов*/

	try
	{
		$sql = 'SELECT id, promotiontitle, imghead, imgalt FROM promotion WHERE idcategory = '.$categoryID.' AND premoderation = "YES" ORDER BY rand() LIMIT 6';
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка вывода заголовка похожей статьи ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$similarPosts[] =  array ('id' => $row['id'], 'promotiontitle' =>  $row['promotiontitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt']);
	}	
	
	$columns = count ($similarPosts) > 1 ? 'columns' : 'columns_f1';//подсчёт материалов
	
	/*Вывод комментариев*/
	include_once MAIN_FILE . '/includes/showcomments.inc.php';

	showComments('promotion', 'idpromotion', $idPromotion);
	
	include 'viewpromotion.html.php';
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
	updComment($_POST['id'], $_POST['comment'], $_POST['idarticle'], 'promotion');
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
	
	header ('Location: ../viewpromotion/?id='.$_POST['idarticle']);//перенаправление обратно в контроллер index.php
	exit();
}	
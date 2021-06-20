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

/*Загрузка данных автора*/
if (isset ($_GET['id']))
{
	$idAuthor = $_GET['id'];
	
	/*Возвращение id автора для вызова функции изменения пароля*/

	$selectedAuthor = isset($_SESSION['loggIn']) ? (int)(authorID($_SESSION['email'], $_SESSION['password'])) : '';//id автора
	
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'SELECT authorname, www, accountinfo, avatar FROM author WHERE id = :id';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':id', $idAuthor);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка вывода аккаунта ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
	
	$authorName = $row['authorname'];
	$www = $row['www'];
	$accountInfo = $row['accountinfo'];
	$avatar = $row['avatar'];
	
	/*Если страница отсутствует. Ошибка 404*/
	if (!$row)
	{
		header ('Location: ../page-not-found/');//перенаправление обратно в контроллер index.php
		exit();	
	}
	
	$title = 'Профиль пользователя '.$authorName;//Данные тега <title>
	$headMain = $authorName;
	$robots = 'all';
	$descr = 'Вся информация о пользователе '.$authorName. ' портала imagoz.ru';
	$scriptJScode = '<script src="script.js"></script>
					 <script src="//'.MAIN_URL.'/js/jquery-1.min.js"></script>
					 <script src="//'.MAIN_URL.'/js/bootstrap-markdown.js"></script>
					 <script src="//'.MAIN_URL.'/js/bootstrap.min.js"></script>';//добавить код JS
	
	/*Вывод избранного*/
	
	$selectFavourites = 'SELECT post, title, date, imghead, imgalt, idauthorpost, idcategory, url, authorname, categoryname FROM favourites 
						 INNER JOIN author ON idauthorpost = author.id 
			   			 INNER JOIN category ON idcategory = category.id WHERE idauthor = '.$idAuthor.' ORDER BY adddate DESC LIMIT 3';
		
	try
	{
		$sql = $selectFavourites;
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка вывода избраного ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$favourites[] =  array ('post' => $row['post'], 'authorname' => $row['authorname'], 'title' => $row['title'],
							'date' => $row['date'], 'imghead' => $row['imghead'], 'imghead' => $row['imghead'], 'imgalt' => $row['imgalt'],
							'idauthorpost' => $row['idauthorpost'], 'idcategory' => $row['idcategory'], 'url' => $row['url'],
							'categoryname' => $row['categoryname']);
	}		
	
	/*Управление аккаунтом*/
	
	if ($selectedAuthor == $idAuthor)
	{
		$setAccount = '<a href = "./setaccount"><button class="btn_1">Настройки аккаунта</button></a>';//запуск обновления информации профиля
		
		/*Присвоить роль рекламодателя*/
		if ((!userRole('Администратор')) && (!userRole('Автор')) && (!userRole('Рекламодатель')))
		{
		
			$addRoleAdvertiser = '<form action = "?" method = "post">
									<div>
										<input type = "hidden" name = "id" value = "'.$selectedAuthor.'">
										<button name = "action" class="btn_1" value = "Стать рекламодателем">Стать рекламодателем</button>
									</div>
								</form>';//вывод кнопки "Стать рекламодателем"
		}
		
		elseif (userRole('Рекламодатель'))
		{
			$addRoleAdvertiser = '<form action = "?" method = "post">
									<div>
										<input type = "hidden" name = "id" value = "'.$selectedAuthor.'">
										<button name = "action" class="btn_1" value = "Отказаться от роли рекламодателя">Отказаться от роли рекламодателя</button>
									</div>
								</form>';//вывод кнопки "Стать рекламодателем"
		}
		
		else
		{
			$addRoleAdvertiser ='';
		}
		
		/*Команда SELECT, вывод счёта автора*/
		try
		{
			$sql = 'SELECT score FROM author WHERE author.id = '.$selectedAuthor;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}

		catch (PDOException $e)
		{
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Ошибка выбора информации о счёте автора : ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();
		}

		$row = $s -> fetch();
	
		$score = '<br><strong>Мой счёт '.round($row['score'], 2, PHP_ROUND_HALF_DOWN).'</strong>';	//вывод счёта
		
		/*Команда SELECT, Вывод платёжной системы и кошелька*/
		try
		{
			$sql = 'SELECT paysystemname, ewallet FROM author 
					INNER JOIN paysystem ON idpaysystem = paysystem.id 
					WHERE author.id = '.$selectedAuthor;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}

		catch (PDOException $e)
		{
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Ошибка выбора информации о счёте автора : ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();
		}
		
		$row = $s -> fetch();
		
		$ewallet = !empty($row['ewallet']) ? 'П/с: '.$row['paysystemname']. '; Счёт: '. $row['ewallet'] : '';
	}
	
	else
	{
		$setAccount = ''; 
		$addRoleAdvertiser ='';
		$score = '';
		$ewallet = '';
	}
	
	/*Вывод кнопки "Написать сообщение"*/
	if ($selectedAuthor != $idAuthor)
	{
		$mainMessagesForm = '<form action = "../mainmessages/addupdmainmessage/#bottom" method = "post">
								<div>
									<input type = "hidden" name = "idto" value = "'.$idAuthor.'">
									<button name = "action" class="btn_1" value="Написать сообщение">Написать сообщение</button>
								</div>
							</form>';// написать сообщение!
	}
	
	else
	{
		$mainMessagesForm = '';
	}
	
	/*Вывод новостей и статей автора*/
	/*Команда SELECT, возвращение роли автора*/
	try
	{
		$sql = 'SELECT idrole FROM author 
				INNER JOIN authorrole ON author.id = idauthor
				INNER JOIN role ON idrole = role.id WHERE author.id = :id';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':id', $idAuthor);
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора информации о роли автора : ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}

	$row = $s -> fetch();
	
	$authorRole = !empty($row['idrole']) ? $row['idrole'] : '';

	/*Если у автора роль автора, администратора и т. д., то выводится список его новостей и статей*/

	if	(($authorRole == 'Автор') || ($authorRole == 'Администратор'))
	{	
		/*Выбор новостей автора*/
		try
		{
			$sql = 'SELECT newsblock.id AS newsid, newstitle, newsdate, imghead FROM author
					INNER JOIN newsblock ON author.id = idauthor 
					WHERE premoderation = "YES" AND author.id = '.$idAuthor.' ORDER BY newsblock.id DESC LIMIT 3';
			$result = $pdo->query($sql);
		}
	
		catch (PDOException $e)
		{
			$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
			$headMain = 'Ошибка данных!';
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Ошибка вывода статей автора ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();
		}

		/*Вывод результата в шаблон*/
		foreach ($result as $row)
		{
			$newsIn[] =  array ('id' => $row['newsid'], 'newstitle' => $row['newstitle'], 'newsdate' => $row['newsdate'],
								'imghead' => $row['imghead']);
		}	
		
		/*Если массив пустой для избежания ошибки "Warning: Invalid argument supplied for foreach()"*/
		// if (!isset ($newsIn))
		// {
		// 	$newsIn[] =  array ('id' => 'Нет значения', 'newstitle' => '');
		// }
		
		/*Выбор статей автора*/
		try
		{
			$sql = 'SELECT posts.id AS postid, posttitle, postdate, imghead FROM author
					INNER JOIN posts ON author.id = idauthor 
					WHERE premoderation = "YES" AND author.id = '.$idAuthor.' ORDER BY posts.id DESC LIMIT 3';
			$result = $pdo->query($sql);
		}
	
		catch (PDOException $e)
		{
			$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
			$headMain = 'Ошибка данных!';
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Ошибка вывода статей автора ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();
		}

		/*Вывод результата в шаблон*/
		foreach ($result as $row)
		{
			$posts[] =  array ('id' => $row['postid'], 'posttitle' => $row['posttitle'], 'postdate' => $row['postdate'],
			'imghead' => $row['imghead']);
		}	
		
		/*Если массив пустой для избежания ошибки "Warning: Invalid argument supplied for foreach()"*/
		// if (!isset ($posts))
		// {
		// 	$posts[] =  array ('id' => 'Нет значения', 'posttitle' => '');
		// }
		
		/*Вывод ранга автора*/
		try
		{
			$sql = 'SELECT rangname, pricenews, pricepost, rating FROM author
					INNER JOIN rang ON rang.id = idrang 
					WHERE author.id = '.$idAuthor;
			$result = $pdo->query($sql);
		}
	
		catch (PDOException $e)
		{
			$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
			$headMain = 'Ошибка данных!';
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Ошибка вывода ранга ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();
		}
		
		foreach ($result as $row)
		{
			$rangName[] =  array ('rangname' => $row['rangname'], 'pricenews' => $row['pricenews'], 'pricepost' => $row['pricepost'],
								  'rating' => $row['rating']);
		}	
		
		$rangView = '<strong> Авторский ранг: '. (string) $row['rangname']. '</strong>';//Если присвоен соответствующий статус, то выводиться ранг
		$rating = '<br><strong> Рейтинг: '.(string) $row['rating'].'</strong>';//Если присвоен соответствующий статус, то выводиться рейтинг
		
		if ($selectedAuthor == $idAuthor)
		{
			$prices = '<p><strong> Цена новости: '.$row['pricenews'].' за 1000 зн. <br> Цена статьи: '.$row['pricepost'].' за 1000 зн. </strong></p>';
		}
		
		else
		{
			$prices = '';
		}
	}
	
	/*Присвоить - удалить ранг "Автор" / Назначить премию или бонус автору*/
	
	if (!isset($_SESSION['loggIn']))//Если пользователь не вошёл в систему
	{	
		$addRole = '';
		$addBonus = '';
	}
	
	elseif (!userRole('Администратор'))//Если пользователь не Администратор
	{
		$addRole = '';
		$addBonus = '';
	}
		
	else
	{
		if	($authorRole == 'Автор')
		{		
			$addRole = '<form action=" " metod "post">
							<input type = "hidden" name = "id" value = "'.$idAuthor.'">
							<button name = "delrang" value = "Удалить ранг Автор" class="btn_1">Удалить ранг Автор</button> 
					 	 </form>';
			
			$addBonus = '<form action = "../admin/payment/" method = "post">
									<input type = "hidden" name = "id" value = "'.$idAuthor.'">
									<button name = "action" class="btn_1" value = "Назначить премию или бонус">Назначить премию или бонус</button>
							</form>';//если у автора статус "Автор", то ему можно назначить премию или бонус
		}
		
		else
		{		
			$addRole = '<form action=" " metod "post">
							<input type = "hidden" name = "id" value = "'.$idAuthor.'">
							<button name = "addrang" value = "Присвоить ранг Автор" class="btn_1">Присвоить ранг Автор</button> 
					 	 </form>';
			
			$addBonus = '';//кнопка не отображается
		}
	}
	
	/*Присвоить статус автора*/
	if (isset($_GET['addrang']))
	{
		include MAIN_FILE . '/includes/db.inc.php';
		
		try
		{
			$sql = 'INSERT authorrole SET 
					idauthor = :id,
					idrole = "Автор"';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':id', $idAuthor);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}
		
		catch (PDOException $e)
		{
			$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
			$headMain = 'Ошибка данных!';
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Ошибка обновления информации news'. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();
			
		}
		
		header ('Location: ../account/?id='.$idAuthor);//перенаправление обратно в контроллер index.php
		exit();	
	}
	
	/*Присвоить статус автора*/
	if (isset($_GET['delrang']))
	{
		include MAIN_FILE . '/includes/db.inc.php';
		
		try
		{
			$sql = 'DELETE FROM authorrole WHERE 
					idauthor = '.$idAuthor.' AND
					idrole = "Автор"';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}
		
		catch (PDOException $e)
		{
			$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
			$headMain = 'Ошибка данных!';
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Ошибка обновления информации news'. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();
			
		}
		
		header ('Location: ../account/?id='.$idAuthor);//перенаправление обратно в контроллер index.php
		exit();	
	}
	
	/*Вывод комментариев*/
	/*Постраничный вывод информации*/
		
	$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;// помещаем номер страницы из массива GET в переменую $page
	$onPage = 10;// количество статей на страницу
	$shift = ($page - 1) * $onPage;// (номер страницы - 1) * статей на страницу

	try
	{
		$sql = 'SELECT comments.id, author.id AS idauthor, comment, imghead, imgalt, subcommentcount, commentdate, authorname, avatar FROM comments 
		INNER JOIN author 
		ON idauthor = author.id 
		WHERE idaccount = '.$idAuthor.' 
		ORDER BY comments.id DESC LIMIT '.$shift.' ,'.$onPage;//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Error table in mainpage' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$comments[] =  array ('id' => $row['id'], 'idauthor' => $row['idauthor'], 'text' => $row['comment'], 'date' => $row['commentdate'], 'authorname' => $row['authorname'],
								'subcommentcount' => $row['subcommentcount'], 'imghead' => $row['imghead'], 'imgalt' => $row['imgalt'], 'avatar' => $row['avatar']);
	}
	
	/*Форма добавления комментария / Получение имени автора для вывода меню редактирования или удаления комментария*/
	if (isset($_SESSION['loggIn']))
	{
		$addComment = ' <form class="m-content comment-form" action = "../account/addupdwallpost/?addform" method = "post" enctype="multipart/form-data">               
								<input type = "file" name = "upload" id = "upload">
								<input type = "hidden" name = "action" value = "upload">
								<input type = "hidden" name = "idauthin" value = "'.$idAuthor.'">
								<textarea class = "comment-textarea" rows="10" id = "comment" name = "comment" data-provide="markdown" placeholder = "Напишите свой комментарий!"></textarea>	
								<button class = "btn_1">Добавить коммнтарий</button>  
						</form>';	
	}
	
	else
	{
		$authorName = '';
		$_SESSION['email'] = '';
		$addComment = '<a href="../admin/registration/?log">Авторизируйтесь</a> в системе или 
						 <a href="../admin/registration/?reg">зарегестрируйтесь</a> для того, чтобы оставить запись!';//Вывод сообщения в случае невхода в систему
		
		$action = '';	
	}
	
	/*Определение количества статей*/
	$sql = "SELECT count(idaccount) AS all_articles FROM comments WHERE idaccount = ".$idAuthor;
	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	
	$row = $s -> fetch();
	
	$countPosts = $row["all_articles"];
	$pagesCount = ceil($countPosts / $onPage);
	
	include 'account.html.php';
	exit();
}
	
/*Присвоение роли "Рекламодатель"*/
if (isset ($_POST['action']) && $_POST['action'] == 'Стать рекламодателем')
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT author.id FROM author WHERE author.id = :id';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':id', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора информации аккаунта : ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}	

	$row = $s -> fetch();
	
	$title = 'Стать рекламодателем';//Данные тега <title>
	$headMain = 'Стать рекламодателем';
	$robots = 'noindex, nofollow';
	$descr = '';
	$padgeTitle = 'Стать рекламодателем портала';// Переменные для формы "Новый автор"
	$action = 'addrole';
	$idauthor = $row['id'];
	$button = 'Получить статус рекламодателя';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT promotionprice FROM promotionprice';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора цены промоушена : ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}	
	
	$row = $s -> fetch();
	
	$promotionPrice = $row['promotionprice'];
	
	$annotation = '<p>Вы собираетесь присвоить себе ранг рекламодателя на портале. Это позволит Вам писать платные материалы рекламного характера для продвиения своего бренда, 
			товара, услуги и т. п. Стоимость публикации составляет на данный момент <strong>'.$promotionPrice.' рубля</strong>. </p>
			
			 <p>Чтобы получить возможность разместить статью Вам нужно пополнить свой счёт минимум на сумму достаточную для одного материала. Публикация должна максимально 
			 соответствовать ряду требований:</p>
			 <ul>
			 	<li>Органично вписываться в тематику портала, должна хотябы косвенно подходить под одну из рубрик (продвижение высокотехнологичного товара, 
					реклама научного, игрового, hi-tech-портала, продажа ретро-игр, игровых журналов и т.п., главное оформить это в статью и интересно преподать).</li>
				<li>Публикация должна быть написана грамотным русским языком.</li>
				<li>Уникальность материала 90-100%.</li>
			</ul>
			<p>Все публикации проходят премодерацию, и в случае не соответствия требоаниям - отклоняться. В этом случае деньги вернуться на Ваш счёт и при необходимости 
		 	могут быть выведены обратно, либо использованы для повторной попытки опубликоать статью.</p>';
	
	include 'becomadvertiser.html.php';
	exit();
}

/*Команда UPDATE - обновление роли*/
if (isset ($_GET['addrole']))
{
	include MAIN_FILE . '/includes/db.inc.php';
		
		try
		{
			$sql = 'INSERT authorrole SET 
					idauthor = :id,
					idrole = "Рекламодатель"';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':id', $_POST['id']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}
		
		catch (PDOException $e)
		{
			$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
			$headMain = 'Ошибка данных!';
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Ошибка обновления информации news'. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();
			
		}
		
		header ('Location: ../account/?id='.$_POST['id']);//перенаправление обратно в контроллер index.php
		exit();	
}

/*Отказаться от роли "Рекламодатель"*/
if (isset ($_POST['action']) && $_POST['action'] == 'Отказаться от роли рекламодателя')
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT author.id FROM author WHERE author.id = :id';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':id', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора информации аккаунта : ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}	

	$row = $s -> fetch();
	
	$title = 'Отказаться от роли рекламодателя';//Данные тега <title>
	$headMain = 'Отказаться от роли рекламодателя';
	$robots = 'noindex, nofollow';
	$descr = '';
	$padgeTitle = 'Отказаться от роли рекламодателя';// Переменные для формы "Новый автор"
	$action = 'delrole';
	$idauthor = $row['id'];
	$button = 'Отказаться от роли рекламодателя';
	$annotation = '';
	
	include 'becomadvertiser.html.php';
	exit();
}

	/*Команда UPDATE - обновление роли*/
if (isset ($_GET['delrole']))
{
	include MAIN_FILE . '/includes/db.inc.php';
		
	try
	{
		$sql = 'DELETE FROM authorrole WHERE 
				idauthor = :id AND
				idrole = "Рекламодатель"';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':id', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
		
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка обновления информации news'. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
			
	}
		
	header ('Location: ../account/?id='.$_POST['id']);//перенаправление обратно в контроллер index.php
	exit();	
}
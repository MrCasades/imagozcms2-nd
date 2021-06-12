<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

else
{
	include '../login.html.php';
	exit();
}

/*Загрузка сообщения об ошибке входа*/
if ((!userRole('Администратор')) && (!userRole('Автор')))
{
	$title = 'Ошибка доступа';//Данные тега <title>
	$headMain = 'Ошибка доступа';
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Доступ запрещен';
	include '../accessfail.html.php';
	exit();
}

/*Ошибка доступа, если автор не взял задание  и он не супер-автор*/
if ((userRole('Автор')) && (!isset ($_POST['id'])))
{
	if (!userRole('Супер-автор'))
	{
		$title = 'Ошибка доступа';//Данные тега <title>
		$headMain = 'Ошибка доступа';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Сначала необходимо получить задание!';
		include '../accessfail.html.php';
		exit();
	}
	
	else
	{
		/*С рангом Супер-автор происходит проверка времени публикации последнего задания*/
		/*Подключение к базе данных*/
		include MAIN_FILE . '/includes/db.inc.php';
		
		try
		{
			$sql = 'SELECT pubtime FROM superuserpubtime WHERE idauthor = '.(int)(authorID($_SESSION['email'], $_SESSION['password']));
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}

		catch (PDOException $e)
		{
			$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
			$headMain = 'Ошибка данных!';
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Ошибка выбора времени последней публикации ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();
		}
	
		$row = $s -> fetch();
		
		$lastPubTime = $row['pubtime'];	
	}
}

if (empty ($lastPubTime)) $lastPubTime = '';//если переменная не объявлена

/*Суточный лимит публикаций в качестве Супер-автора*/
if ((userRole('Супер-автор')) && ($lastPubTime != '') && (time() < $lastPubTime + 2*60*60*24))
{
		$title = 'Ошибка доступа';//Данные тега <title>
		$headMain = 'Ошибка доступа';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Можно делать только 1 публикацию в течении 48 часов в качестве Супер-автора!';
		include '../accessfail.html.php';
		exit();
}

/*Вывод ссылок на разделы администрирования списков*/
if (userRole('Администратор'))
{
	$addAuthor = '<a href="//'.MAIN_URL.'/admin/authorlist/">Редактировать список авторов</a>';
	$addCatigorys = '<a href="//'.MAIN_URL.'/admin/categorylist/">Редактировать рубрики</a>';
	$addMetas = '| <a href="//'.MAIN_URL.'/admin/metalist/" class="btn btn-primary-sm">Редактировать список тегов</a>';
}

else
{
	$addAuthor = '';
	$addCatigorys = '';
	$addMetas = '';
}

/*Добавление информации о статье*/
if (isset($_GET['add']))//Если есть переменная add выводится форма
{
	$errorForm = '';
	$title = 'Добавить новую новость';//Данные тега <title>
	$headMain = 'Добавить новую новость';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'addform';
	$newstitle = '';
	$description = '';
	$text = '';
	$imgalt = '';
	$videoyoutube = '';
	$idauthor = '';
	$idcategory = '';
	$id = '';
	$button = 'Добавить новость';
	$authorPost = authorLogin ($_SESSION['email'], $_SESSION['password']);//возвращает имя автора
	$scriptJScode = '<script src="script.js"></script>
					 <script src="//'.MAIN_URL.'/js/jquery-1.min.js"></script>
					 <script src="//'.MAIN_URL.'/js/bootstrap-markdown.js"></script>
					 <script src="//'.MAIN_URL.'/js/bootstrap.min.js"></script>';//добавить код JS
	
	if (isset($_POST['id']))
	{
		@session_start();//Открытие сессии для сохранения id задания
	
		$_SESSION['idtask'] = $_POST['id'];
	}
	
	else
	{
		@session_start();//Открытие сессии для сохранения id задания
	
		$_SESSION['idtask'] = 0;
	}
	
	@session_start();//Открытие сессии для сохранения id автора
	
	$_SESSION['authorname'] = $authorPost;
	
	/*Вывод информации для формы добавления*/

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
		$categorys_1[] = array('idcategory' => $row['id'], 'categoryname' => $row['categoryname']);
	}
	
	/*Список тематик*/
	try
	{
		$result = $pdo -> query ('SELECT id, metaname FROM meta');
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
		$metas_1[] = array('idmeta' => $row['id'], 'metaname' => $row['metaname'], 'selected' => FALSE);
	}
	
	include 'addupdform.html.php';
	exit();
	
}

/*Обновление информации о статье*/
if (isset ($_POST['action']) && ($_POST['action'] == 'Upd' || $_POST['action'] == 'Переделать' || $_POST['action'] == 'ОБНОВИТЬ'))
{
	if ($_POST['action'] == 'Переделать')
	{
		@session_start();//Открытие сессии для сохранения флага переработки
	
		$_SESSION['rewrite'] = true;
	}
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT id, news, newstitle, idauthor, idcategory, imghead, imgalt, videoyoutube, translittitle, description FROM newsblock WHERE id = :idnews';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idnews', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора новости: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
	
	$title = 'Обновление новости';//Данные тега <title>
	$headMain = 'Обновление новости';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'editform';
	$text = $row['news'];
	$newstitle = $row['newstitle'];
	$description = $row['description'];
	$imgalt = $row['imgalt'];
	$videoyoutube = $row['videoyoutube'];
	$idauthor = 
	$idcategory = $row['idcategory'];
	$id = $row['id'];
	$button = 'Обновить информацию о новости';
	$errorForm = '';
	$scriptJScode = '<script src="script.js"></script>
					 <script src="//'.MAIN_URL.'/js/jquery-1.min.js"></script>
					 <script src="//'.MAIN_URL.'/js/bootstrap-markdown.js"></script>
					 <script src="//'.MAIN_URL.'/js/bootstrap.min.js"></script>';//добавить код JS
	
	@session_start();//Открытие сессии для сохранения названия файла изображения
	
	$_SESSION['imghead'] = $row['imghead'];
		
	/*Выбор автора статьи*/
	try
	{
		$result = $pdo -> query ('SELECT authorname FROM newsblock INNER JOIN author ON idauthor = author.id WHERE newsblock.id = '.$id);
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка вывода author '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	foreach ($result as $row)
	{
		$authors_1[] = array('authorname' => $row['authorname']);
	}
	
	$authorPost = $row['authorname'];//возвращает имя автора
	
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
		$categorys_1[] = array('idcategory' => $row['id'], 'categoryname' => $row['categoryname']);
	}
	
	/*Статьи по тематикам*/
	try
	{
		$sql = 'SELECT idmeta FROM metapost WHERE idnews = :idnews';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idnews', $id);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка вывода metapost ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	foreach ($s as $row)
	{
		$selectedMeta[] = $row['idmeta'];
	}
	
	if (empty ($selectedMeta)) $selectedMeta[] = 0;//если нет ни одной тематики
	
	/*Список тематик*/
	try
	{
		$result = $pdo -> query ('SELECT id, metaname FROM meta');
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
		$metas_1[] = array('idmeta' => $row['id'],'metaname' => $row['metaname'], 'selected' => in_array($row['id'], $selectedMeta));
	}

	include 'addupdform.html.php';
	exit();
}

/*команда INSERT  - добавление в базу данных*/
if (isset($_GET['addform']))//Если есть переменная addform выводится форма
{
	$fileNameScript = 'img-'. time();//имя файла новости/статьи
	$filePathScript = '/images/';//папка с изображениями для новости/статьи
	
	/*Загрузка функций для формы входа*/
	require_once MAIN_FILE . '/includes/access.inc.php';
	
	/*Загрузка скрипта добавления файла*/
	include MAIN_FILE . '/includes/uploadfile.inc.php';
		
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Возвращение id автора*/
	
	$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора
	
	if (($_POST['category'] == '') || ($_POST['textnews'] == '') || ($_POST['newstitle'] == ''))
	{
		$title = 'Добавить новую новость';//Данные тега <title>
		$headMain = 'Добавить новую новость';
		$robots = 'noindex, nofollow';
		$descr = '';
		$action = 'addform';
		$idauthor = '';
		$idcategory = '';
		$id = '';
		$button = 'Добавить новость';
		$authorPost = authorLogin ($_SESSION['email'], $_SESSION['password']);//возвращает имя автора
		$errorForm = 'Один или несколько атрибутов не указаны. Выбирете все!';
		$scriptJScode = '<script src="script.js"></script>
					 <script src="//'.MAIN_URL.'/js/jquery-1.min.js"></script>
					 <script src="//'.MAIN_URL.'/js/bootstrap-markdown.js"></script>
					 <script src="//'.MAIN_URL.'/js/bootstrap.min.js"></script>';//добавить код JS
		
		@session_start();//Открытие сессии для сохранения данных форм
	
		$_SESSION['newstitle'] = $_POST['newstitle'];
		$_SESSION['imgalt'] = $_POST['imgalt'];
		$_SESSION['description'] = $_POST['description'];
		$_SESSION['textnews'] = $_POST['textnews'];
		
		$newstitle = $_SESSION['newstitle'];
		$imgalt = $_SESSION['imgalt'];
		$description = $_SESSION['description'];
		$text = $_SESSION['textnews'];
		
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
		$categorys_1[] = array('idcategory' => $row['id'], 'categoryname' => $row['categoryname']);
	}
	
	/*Список тематик*/
	try
	{
		$result = $pdo -> query ('SELECT id, metaname FROM meta');
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
		$metas_1[] = array('idmeta' => $row['id'], 'metaname' => $row['metaname'], 'selected' => FALSE);
	}
	
		include 'addupdform.html.php';
		exit();
	}
	
	/*Определение предворительной длины и цены текста*/
	include_once MAIN_FILE . '/includes/func.inc.php';
	
	$text = $_POST['textnews'];
	$lengthText = lengthText($text);//определение длины текста
	
	/*Выбор цены за 1000 знаков*/
	try
	{
		$result = $pdo -> query ('SELECT pricenews, bonus FROM author INNER JOIN rang ON idrang = rang.id
									WHERE author.id = '.$selectedAuthor);
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора цены новости '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	foreach ($result as $row)
	{
		$price[] =  array ('pricenews' => $row['pricenews'], 'bonus' => $row['bonus']);
	}	
	
	$priceNews = $row['pricenews'];//цена за 1000 знаков
	
	$bonus = $row['bonus'];//выбор бонуса(множителя)
	
	$fullPrice = priceText($text, $priceNews, $bonus);//полная стоимость статьи
	
	/*Обновление параметров задания*/
	
	if($_SESSION['idtask'] != 0)
	{
		try
		{
			$pdo->beginTransaction();//инициация транзакции

			$sql = 'UPDATE task SET readystatus  = "YES",
									readydate = SYSDATE()
								WHERE id = '.$_SESSION['idtask'];
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

			$sql = 'UPDATE author SET taskcount  = taskcount - 1
								  WHERE id = '.$selectedAuthor;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

			$pdo->commit();//подтверждение транзакции			
		}

		catch (PDOException $e)
		{
			$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
			$headMain = 'Ошибка данных!';
			$robots = 'noindex, nofollow';
			$descr = '';
			$pdo->rollBack();//отмена транзакции
			$error = 'Error transaction 1 newsblock '.$e -> getMessage();// вывод сообщения об ошибке в переменой $e;// вывод сообщения об ошибке в переменой $e;// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();		
		}
	}
	
	/*Если у автора роль "Супер-автор", то обновляется таблица*/
	
	if (userRole('Супер-автор') && ($_SESSION['idtask'] == 0))
	{
		/*Публиковался ли автор, как "Супер-автор"*/
		try
		{
			$sql = 'SELECT pubtime FROM superuserpubtime WHERE idauthor = '.$selectedAuthor;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}

		catch (PDOException $e)
		{
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Ошибка вывода pubtime ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();
		}
		
		$row = $s -> fetch();
		
		if (!isset ($row['pubtime']))
		{
			try
			{
				$sql = 'INSERT INTO superuserpubtime SET 
					pubtime = "'.time().'",
					idauthor = '.$selectedAuthor;
				$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
				$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			}
			catch (PDOException $e)
			{
				$robots = 'noindex, nofollow';
				$descr = '';
				$error = 'Ошибка добавления информации '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
				include 'error.html.php';
				exit();
			}
		}
		
		else
		{
			try
			{
				$sql = 'UPDATE superuserpubtime SET 
					pubtime = "'.time().'" WHERE
					idauthor = '.$selectedAuthor;
				$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
				$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			}
			catch (PDOException $e)
			{
				$robots = 'noindex, nofollow';
				$descr = '';
				$error = 'Ошибка добавления информации '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
				include 'error.html.php';
				exit();
			}
		}
	}
	
	try
	{
		$sql = 'INSERT INTO newsblock SET 
			news = :news,
			newstitle = :newstitle,
			description = :description,
			imgalt = :imgalt,	
			videoyoutube = :videoyoutube,
			newsdate = SYSDATE(),
			imghead = '.'"'.$fileName.'"'.', '.
			'idauthor = '.$selectedAuthor.','.
			'idcategory = :idcategory,
			idtask = '.$_SESSION['idtask'].' ,
			lengthtext = '.$lengthText.', 
			pricenews = '.$priceNews.', 
			authorbonus = '.$bonus.',
			pricetext = '.$fullPrice;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':news', viewVideoInArticle($_POST['textnews']));//отправка значения
		$s -> bindValue(':newstitle', $_POST['newstitle']);//отправка значения
		$s -> bindValue(':description', $_POST['description']);//отправка значения
		$s -> bindValue(':imgalt', $_POST['imgalt']);//отправка значения
		$s -> bindValue(':videoyoutube', toEmbedInVideo($_POST['videoyoutube']));//отправка значения
		$s -> bindValue(':idcategory', $_POST['category']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка добавления информации '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$idpost_ind = $pdo->lastInsertId();//метод возвращает число, которое MySQL назначил последней автомнкрементной записи (INSERT INTO post - в данном случае)
	
	if (isset ($_POST['metas']))
	{
		try
		{
			$sql = 'INSERT INTO metapost SET 
				idnews = :idnews, 
				idmeta = :idmeta,
				idpost = 0,
				idpromotion = 0';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной

			foreach	($_POST['metas'] as $idmetas)
			{		
				$s -> bindValue(':idnews', $idpost_ind);//отправка значения
				$s -> bindValue(':idmeta', $idmetas);//отправка значения
				$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			}
		}
		catch (PDOException $e)
		{
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Ошибка добавления информации в metaname '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();
		}
		
	}
	
	/*Предварительенй просмотр*/
	
	$select = 'SELECT newsblock.id AS newsid, author.id AS idauthor, news, newstitle, imghead, description, imgalt, newsdate, authorname, category.id AS categoryid, categoryname FROM newsblock 
			   INNER JOIN author ON idauthor = author.id 
			   INNER JOIN category ON idcategory = category.id WHERE premoderation = "NO" AND newsblock.id = ';

	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = $select.$idpost_ind ;
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Error select news ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$newsIn[] =  array ('id' => $row['newsid'], 'idauthor' => $row['idauthor'],  'textnews' => $row['news'], 'newstitle' =>  $row['newstitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
							'description' => $row['description'], 'newsdate' => $row['newsdate'], 
							'authorname' => $row['authorname'], 'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}	
	
	/*Вывод тематик(тегов)*/
	
	/*Команда SELECT*/
	
	try
	{
		$sql = 'SELECT meta.id, metaname FROM newsblock 
				INNER JOIN metapost ON newsblock.id = idnews 
				INNER JOIN meta ON meta.id = idmeta 
				WHERE newsblock.id = '.$idpost_ind;//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора тега ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$metas[] =  array ('id' => $row['id'], 'metaname' => $row['metaname']);
	}
	
	$delAndUpd = "<form action = '../../admin/addupdnews/' method = 'post'>
			
						Редактировать материал:
						<input type = 'hidden' name = 'id' value = '".$idpost_ind."'>
						<input type = 'submit' name = 'action' value = 'Upd' class='btn btn-primary btn-sm'>
					  </form>";
	
	$title = 'Материал сохранён в черновике';//Данные тега <title>
	$headMain = 'Материал сохранён в черновике';
	$robots = 'noindex, nofollow';
	$descr = '';
	$scriptJScode = '<script src="script.js"></script>
					 <script src="//'.MAIN_URL.'/js/jquery-1.min.js"></script>
					 <script src="//'.MAIN_URL.'/js/bootstrap-markdown.js"></script>
					 <script src="//'.MAIN_URL.'/js/bootstrap.min.js"></script>';//добавить код JS
	
	unset($_SESSION['idtask']);//закрытие сессии
	
	include 'premodsucc.html.php';
	exit();
}

/*UPDATE - обновление информации в базе данных*/

if (isset($_GET['editform']))//Если есть переменная editform выводится форма
{
	if (!is_uploaded_file($_FILES['upload']['tmp_name']))//если файл не загружен, оставить старое имя
	{
		$fileName = $_SESSION['imghead'];
	}
	
	else
	{
		/*Удаление старого файла изображения*/
		$fileName = $_SESSION['imghead'];
		$delFile = MAIN_FILE . '/images/'.$fileName;//путь к файлу для удаления
		unlink($delFile);//удаление файла
		
		/*Загрузка скрипта добавления файла*/
		$fileNameScript = 'img-'. time();//имя файла новости/статьи
		$filePathScript = '/images/';//папка с изображениями для новости/статьи
		
		include MAIN_FILE . '/includes/uploadfile.inc.php';
	}
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	if (($_POST['category'] == '') || ($_POST['textnews'] == '') || ($_POST['newstitle'] == ''))
	{
		$title = 'В форме есть незаполненные поля!';//Данные тега <title>
		$headMain = 'В форме есть незаполненные поля!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Один или несколько атрибутов не указаны. Выбирете все.';
		include 'error.html.php';
		exit();
	}
	
	/*Определение предворительной длины и цены текста*/
	include_once MAIN_FILE . '/includes/func.inc.php';
	
	$text = $_POST['textnews'];
	$lengthText = lengthText($text);//определение длины текста
	
	/*Выбор цены за 1000 знаков*/
	try
	{
		$sql = 'SELECT pricenews, authorbonus FROM newsblock WHERE id = :idnews';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idnews', $_POST['id']);
		$s -> execute();
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
	
	$priceNews = $row['pricenews'];//цена за 1000 знаков
	$bonus = $row['authorbonus'];
	
	$fullPrice = priceText($text, $priceNews, $bonus);//полная стоимость статьи
	
	try
	{
		$sql = 'UPDATE newsblock SET 
			news = :news,
			newstitle = :newstitle,	
			description = :description,
			imgalt = :imgalt,	
			videoyoutube = :videoyoutube,
			imghead = '.'"'.$fileName.'"'.', '.
			'idcategory = :idcategory,
			lengthtext = '.$lengthText.', 
			pricetext = '.$fullPrice.'
			WHERE id = :idnews';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idnews', $_POST['id']);//отправка значения
		$s -> bindValue(':news', viewVideoInArticle($_POST['textnews']));//отправка значения
		$s -> bindValue(':newstitle', $_POST['newstitle']);//отправка значения
		$s -> bindValue(':description', $_POST['description']);//отправка значения
		$s -> bindValue(':imgalt', $_POST['imgalt']);//отправка значения
		$s -> bindValue(':videoyoutube', toEmbedInVideo($_POST['videoyoutube']));//отправка значения
		$s -> bindValue(':idcategory', $_POST['category']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка обновления информации news'. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	try
	{
		$sql = 'DELETE FROM metapost WHERE idnews = :idnews';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idnews', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка удаления информации '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	if (isset ($_POST['metas']))
	{
		try
		{
			$sql = 'INSERT INTO metapost SET 
				idnews = :idnews, 
				idmeta = :idmeta,
				idpost = 0,
				idpromotion = 0';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной

			foreach	($_POST['metas'] as $idmetas)
			{		
				$s -> bindValue(':idnews', $_POST['id']);//отправка значения
				$s -> bindValue(':idmeta', $idmetas);//отправка значения
				$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			}
		}
		catch (PDOException $e)
		{
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Ошибка обновления информации metapost'. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();
		}
	}
	
	//Если материал в переработке
	if (isset ($_SESSION['rewrite']) && $_SESSION['rewrite'] == true)
	{
		/*Вернуть материал в премодерацию*/
		try
		{
			$sql = 'UPDATE newsblock SET 
					refused = "NO",
					draft = "YES"  
					WHERE id = :idnews';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idnews', $_POST['id']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

		}
		catch (PDOException $e)
		{
			$robots = 'noindex, nofollow';
			$descr = '';
			$error = 'Ошибка отклонения публикации '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.html.php';
			exit();
		}
	}
	
	$idpost_ind = $_POST['id'];//id материала
	
	/*Предварительенй просмотр*/
	
	$select = 'SELECT newsblock.id AS newsid, author.id AS idauthor, news, newstitle, imghead, viewcount, averagenumber, description, imgalt, newsdate, authorname, category.id AS categoryid, categoryname FROM newsblock 
			   INNER JOIN author ON idauthor = author.id 
			   INNER JOIN category ON idcategory = category.id WHERE premoderation = "NO" AND newsblock.id = ';

	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = $select.$idpost_ind ;
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Error select news ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$newsIn[] =  array ('id' => $row['newsid'], 'idauthor' => $row['idauthor'],  'textnews' => $row['news'], 'newstitle' =>  $row['newstitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
							'description' => $row['description'], 'newsdate' => $row['newsdate'], 
							'authorname' => $row['authorname'], 'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}	
	
	/*Вывод тематик(тегов)*/
	
	/*Команда SELECT*/
	
	try
	{
		$sql = 'SELECT meta.id, metaname FROM newsblock 
				INNER JOIN metapost ON newsblock.id = idnews 
				INNER JOIN meta ON meta.id = idmeta 
				WHERE newsblock.id = '.$idpost_ind;//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора тега ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$metas[] =  array ('id' => $row['id'], 'metaname' => $row['metaname']);
	}
	
	$delAndUpd = "<form action = '../../admin/addupdnews/' method = 'post'>
			
						Редактировать материал:
						<input type = 'hidden' name = 'id' value = '".$idpost_ind."'>
						<input type = 'submit' name = 'action' value = 'Upd' class='btn btn-primary btn-sm'>
					  </form>";
	
	$title = 'Материал сохранён в черновике';//Данные тега <title>
	$headMain = 'Материал сохранён в черновике';
	$robots = 'noindex, nofollow';
	$descr = '';
	$scriptJScode = '<script src="script.js"></script>
					 <script src="//'.MAIN_URL.'/js/jquery-1.min.js"></script>
					 <script src="//'.MAIN_URL.'/js/bootstrap-markdown.js"></script>
					 <script src="//'.MAIN_URL.'/js/bootstrap.min.js"></script>';//добавить код JS
	
	unset($_SESSION['idtask']);//закрытие сессии
	
	include 'premodsucc.html.php';
	exit();
}

/*Публикация материала*/

if (isset ($_POST['action']) && $_POST['action'] == 'ОПУБЛИКОВАТЬ')
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	/*Отправка материала в премодерацию*/
	try
	{
		$sql = 'SELECT newstitle, pricetext FROM newsblock WHERE id = :idnews';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idnews', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка публикации '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}

	$row = $s -> fetch();

	$title = 'Отправить в премодерацию';//Данные тега <title>
	$headMain = 'Отправить в премодерацию';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'topremod';
	$posttitle = $row['newstitle'];
	$price = $row['pricetext'];
	$id = $_POST['id'];
	$button = 'Опубликовать';

	include 'topremoderation.html.php';
}

if (isset ($_GET['topremod']))
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	include_once MAIN_FILE . '/includes/func.inc.php';

	/*Отправка материала в премодерацию*/
	try
	{
		$sql = 'UPDATE newsblock SET draft = "NO" WHERE id = :idnews';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idnews', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка публикации '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}

	/*Отправка сообщений (тест)*/
	
	$titleMessage = 'Ваш материал "'. $_POST['posttitle'].'" находится в премодерации.';
	$mailMessage = 'Вами был отправлен в премодерацию материал "'. $_POST['posttitle'].'". После успешной проверки Вам будет начислен '.$_POST['price'].' балл';

	toEmail_1($titleMessage, $mailMessage);//отправка письма

	header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	exit();
}

/*DELETE - удаление материала*/

if (isset ($_POST['action']) && $_POST['action'] == 'Del')
{	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT id, newstitle, imghead FROM newsblock WHERE id = :idnews';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idnews', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка выбора id и заголовка newsblock : ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
	
	$title = 'Удаление новости';//Данные тега <title>
	$headMain = 'Удаление новости';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'delete';
	$posttitle = $row['newstitle'];
	$id = $row['id'];
	$button = 'Удалить';
	
	@session_start();//Открытие сессии для сохранения названия файла изображения
	
	$_SESSION['imghead'] = $row['imghead'];
	
	include 'delete.html.php';
}

if (isset ($_GET['delete']))
{
	/*Удаление изображения заголовка*/
	$fileName = $_SESSION['imghead'];
	$delFile = MAIN_FILE . '/images/'.$fileName;//путь к файлу для удаления
	unlink($delFile);//удаление файла
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'DELETE FROM comments WHERE idnews = :idnews';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idnews', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка удаления информации '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	try
	{
		$sql = 'DELETE FROM metapost WHERE idnews = :idnews';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idnews', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка удаления информации metapost '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	try
	{
		$sql = 'DELETE FROM votedauthor WHERE idnews = :idnews';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idnews', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка удаления информации votedauthor '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	try
	{
		$sql = 'DELETE FROM newsblock WHERE id = :idnews';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idnews', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка удаления информации newsblock '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	exit();
}	


<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка функций для формы входа*/
include_once MAIN_FILE . '/includes/addarticlesfunc.inc.php';

/*Функция проверки на доступы*/
accessForWritingArticles();

/*Добавление информации о статье*/
if (isset($_GET['add']))//Если есть переменная add выводится форма
{
	$title = 'Добавить новое видео';//Данные тега <title>
	$headMain = 'Добавить новое видео';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'addform';
	$posttitle = '';
	$description = '';
	$text = '';
	$imgalt = '';
	$videoyoutube = '';
	$idauthor = '';
	$idcategory = '';
	$id = '';
	$button = 'Добавить видео';
	$errorForm = '';
	$authorPost = authorLogin ($_SESSION['email'], $_SESSION['password']);//возвращает имя автора
	$scriptJScode = '<script src="../commonfiles/addarticlescripts.js"></script>';//добавить код JS
	
	/*id задания*/
	$idTask = isset($_POST['id']) ? $_POST['id'] : 0;
	
	/*Вывод информации для формы добавления*/

	addListsInForms();

	include 'addupdform.html.php';
	exit();
	
}

/*Обновление информации о статье*/
if (isset ($_POST['action']) && ($_POST['action'] == 'Upd'|| $_POST['action'] == 'Переделать' || $_POST['action'] == 'ОБНОВИТЬ'))
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
		$sql = 'SELECT id, post, videotitle, idauthor, imghead, imgalt, videoyoutube, videofile, videofileext, description, idcategory FROM video WHERE id = :idvideo';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idvideo', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора атрибутов видео';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$title = 'Обновление видео';//Данные тега <title>
	$headMain = 'Обновление видео';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'editform';
	$text = $row['post'];
	$posttitle = $row['videotitle'];
	$description = $row['description'];
	$imgalt = $row['imgalt']; 
	$videoyoutube = $row['videoyoutube']; 
	$idcategory = $row['idcategory'];
	$id = $row['id'];
	$button = 'Обновить информацию о видео';
	$errorForm ='';
	$scriptJScode = '<script src="../commonfiles/addarticlescripts.js"></script>';//добавить код JS
	
	@session_start();//Открытие сессии для сохранения названия файла изображения
	
	$_SESSION['imghead'] = $row['imghead'];
	$_SESSION['videofile'] = $row['videofile'];
	$_SESSION['videofileext'] = $row['videofileext'];
	
	
	/*Выбор автора статьи*/
	try
	{
		$result = $pdo -> query ('SELECT authorname FROM video INNER JOIN author ON idauthor = author.id WHERE video.id = '.$id);
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода author';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	foreach ($result as $row)
	{
		$authors_1[] = array('authorname' => $row['authorname']);
	}
	
	$authorPost = $row['authorname'];//возвращает имя автора00
	
	/*Список рубрик*/
	try
	{
		$result = $pdo -> query ('SELECT id, categoryname FROM category');
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода category';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	foreach ($result as $row)
	{
		$categorys_1[] = array('idcategory' => $row['id'], 'categoryname' => $row['categoryname']);
	}
	
	/*Статьи по тематикам*/
	try
	{
		$sql = 'SELECT idmeta FROM metapost WHERE idvideo = :idvideo';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idvideo', $id);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка вывода metapost';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	foreach ($s as $row)
	{
		$selectedMeta[] = $row['idmeta'];
	}
	
	if (empty ($selectedMeta)) $selectedMeta[] = 0;//если нет ни одной тематики
	
	/*Список тематик*/
	try
	{
		$result = $pdo -> query ('SELECT id, metaname FROM meta ORDER BY metaname');
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода meta';
		include MAIN_FILE . '/includes/error.inc.php';
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
	$fileNameVideoScript = 'video-'. time().rand(11, 99);//имя файла новости/статьи
	$filePathVideoScript = '/videofiles/';//папка с изображениями для новости/статьи
	
	/*Загрузка функций для формы входа*/
	require_once MAIN_FILE . '/includes/access.inc.php';

	/*Загрузка скрипта добавления видео*/
	include MAIN_FILE . '/includes/uploadvideo.inc.php';
		
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	/*Подключение функций*/
	include_once MAIN_FILE . '/includes/func.inc.php';

	$fileNameScript = 'img-'. time();//имя файла изображения
	$filePathScript = '/images/';//папка с изображениями для новости/статьи
		
	//Загрузка файла изображения
	$fileName = uploadImgHeadFull ($fileNameScript, $filePathScript);
	
	/*Возвращение id автора*/
	
	$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора
	
	if (($_POST['category'] == '') || ($_POST['text'] == '') || ($_POST['articletitle'] == ''))
	{
		$title = 'Добавить новое видео';//Данные тега <title>
		$headMain = 'Добавить новое видео';
		$robots = 'noindex, nofollow';
		$descr = '';
		$action = 'addform';
		$idauthor = '';
		$idcategory = '';
		$id = '';
		$button = 'Добавить видео';
		$authorPost = authorLogin ($_SESSION['email'], $_SESSION['password']);//возвращает имя автора
		$errorForm = 'Один или несколько атрибутов не указаны. Выбирете все!';
		$scriptJScode = '<script src="../commonfiles/addarticlescripts.js"></script>';//добавить код JS
		
		@session_start();//Открытие сессии для сохранения id автора
	
		$_SESSION['articletitle'] = $_POST['articletitle'];
		$_SESSION['imgalt'] = $_POST['imgalt'];
		$_SESSION['description'] = $_POST['description'];
		$_SESSION['text'] = $_POST['text'];
		
		$videotitle = $_SESSION['articletitle'];
		$imgalt = $_SESSION['imgalt'];
		$description = $_SESSION['description'];
		$text = $_SESSION['text'];
		
		/*Вывод информации для формы добавления*/
			
		addListsInForms();
		
		include 'addupdform.html.php';
		exit();
	}
	
	/*Определение предворительной длины и цены текста*/
		
	setArticlePrice($_POST['text'], 'pricepost', $selectedAuthor, 'add');//полная стоимость статьи
	
	/*Обновление параметров задания*/
	
	if($_POST['idtask'] != 0)
	{
		try
		{
			$pdo->beginTransaction();//инициация транзакции

			$sql = 'UPDATE task SET readystatus  = "YES",
									readydate = SYSDATE()
								WHERE id = '.$_POST['idtask'];
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
			$pdo->rollBack();//отмена транзакции

			$error = 'Ошибка изменения статуса задания';
			include MAIN_FILE . '/includes/error.inc.php';	
		}
	}
	
	/*Если у автора роль "Супер-автор", то обновляется таблица*/
	
	if (userRole('Супер-автор') && ($_POST['idtask'] == 0))
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
			$error = 'Ошибка вывода pubtime';
			include MAIN_FILE . '/includes/error.inc.php';	
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
				$error = 'Ошибка контроля времени публикации Супер-автора';
				include MAIN_FILE . '/includes/error.inc.php';
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
				$error = 'Ошибка контроля времени публикации Супер-автора';
				include MAIN_FILE . '/includes/error.inc.php';
			}
		}
	}
	
	try
	{
		$sql = 'INSERT INTO video SET 
					post = :post,
					videotitle = :articletitle,	
					description = :description,
					videodate = SYSDATE(),
					imgalt = :imgalt,
					videoyoutube = :videoyoutube,
					videofile = :videofile,
					videofileext = :videofileext,
					imghead = :imghead,
					idauthor = :idauthor,
					idcategory = :idcategory,
					idtask = :idtask';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':post', viewVideoInArticle($_POST['text']));//отправка значения
		$s -> bindValue(':articletitle', $_POST['articletitle']);//отправка значения
		$s -> bindValue(':description', $_POST['description']);//отправка значения
		$s -> bindValue(':imgalt', $_POST['imgalt']);//отправка значения
		$s -> bindValue(':videoyoutube', toEmbedInVideo($_POST['videoyoutube']));//отправка значения
		$s -> bindValue(':videofile', $fileNameVideoScript);//отправка значения
		$s -> bindValue(':videofileext', $videoExt);//отправка значения
		$s -> bindValue(':idcategory', $_POST['category']);//отправка значения
		$s -> bindValue(':imghead', $fileName);//отправка значения	
		$s -> bindValue(':idauthor', $selectedAuthor);//отправка значения
		$s -> bindValue(':idtask', $_POST['idtask']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка добавления информации';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$idpost_ind = $pdo->lastInsertId();//метод возвращает число, которое MySQL назначил последней автомнкрементной записи (INSERT INTO post - в данном случае)

	if (isset ($_POST['metas']))
	{
		try
		{
			$sql = 'INSERT INTO metapost SET 
				idvideo = :idvideo, 
				idmeta = :idmeta,
				idnews = 0,
				idpost = 0,
				idpromotion = 0';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной

			foreach	($_POST['metas'] as $idmetas)
			{		
				$s -> bindValue(':idvideo', $idpost_ind);//отправка значения
				$s -> bindValue(':idmeta', $idmetas);//отправка значения
				$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			}
		}
		catch (PDOException $e)
		{
			$error = 'Ошибка добавления информации metapost';
			include MAIN_FILE . '/includes/error.inc.php';
		}
		
	}
	
/*Предварительенй просмотр*/
	
	preview('video', $idpost_ind);
	
	/*Вывод тематик(тегов)*/
	
	$metas = previewMetas('video', 'idvideo', $idpost_ind);
	
	include 'premodsucc.html.php';
	exit();
}

/*UPDATE - обновление информации в базе данных*/

if (isset($_GET['editform']))//Если есть переменная editform выводится форма
{
	/*Подключение функций*/
	include_once MAIN_FILE . '/includes/func.inc.php';

	$fileNameScript = 'img-'. time();//имя файла изображения
	$filePathScript = '/images/';//папка с изображениями для новости/статьи

	$fileName = uploadImgHeadFull ($fileNameScript, $filePathScript, 'upd', 'video', $_POST['id']);

	/*Удаление/сохранения названия видео */
	if (!is_uploaded_file($_FILES['uploadvideo']['tmp_name'])) //если файл не загружен, оставить старое имя
	{
		$fileNameVideoScript = $_SESSION['videofile'];
		$videoExt = $_SESSION['videofileext'];
	}
	
	else
	{
		$fileNameVideo = $_SESSION['videofile'].'.'.$_SESSION['videofileext'];	
		$delVideo = MAIN_FILE . '/videofiles/'.$fileNameVideo;//путь к файлу для удаления
		unlink($delVideo);//удаление файла

		$fileNameVideoScript = 'video-'. time().rand(11, 99);//имя файла новости/статьи
		$filePathVideoScript = '/videofiles/';//папка с изображениями для новости/статьи
		
		/*Загрузка скрипта добавления файла*/
		include MAIN_FILE . '/includes/uploadvideo.inc.php';
	}
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	if (($_POST['category'] == '') || ($_POST['text'] == '') || ($_POST['articletitle'] == ''))
	{
		$error = 'В форме есть незаполненные поля!';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	/*Определение предворительной длины и цены текста*/
	//setArticlePrice($_POST['text'], 'pricepost', $_POST['id'], 'upd');//полная стоимость статьи
	
	try
	{
		$sql = 'UPDATE video SET 
					post = :post,
					videotitle = :articletitle,
					description = :description,
					imgalt = :imgalt,
					videoyoutube = :videoyoutube,
					videofile = :videofile,
					imghead = :imghead,
					idcategory = :idcategory
				WHERE id = :idvideo';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idvideo', $_POST['id']);//отправка значения
		$s -> bindValue(':post', viewVideoInArticle($_POST['text']));//отправка значения
		$s -> bindValue(':articletitle', $_POST['articletitle']);//отправка значения
		$s -> bindValue(':description', $_POST['description']);//отправка значения
		$s -> bindValue(':imghead', $fileName);//отправка значения
		$s -> bindValue(':imgalt', $_POST['imgalt']);//отправка значения
		$s -> bindValue(':videoyoutube', toEmbedInVideo($_POST['videoyoutube']));//отправка значения
		$s -> bindValue(':videofile', $fileNameVideoScript);//отправка значения
		$s -> bindValue(':idcategory', $_POST['category']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка обновления информации video';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	try
	{
		$sql = 'DELETE FROM metapost WHERE idvideo = :idvideo';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idvideo', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	if (isset ($_POST['metas']))
	{
		try
		{
			$sql = 'INSERT INTO metapost SET 
				idvideo = :idvideo, 
				idmeta = :idmeta,
				idnews = 0,
				idpost = 0,
				idpromotion = 0';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной

			foreach	($_POST['metas'] as $idmetas)
			{		
				$s -> bindValue(':idvideo', $_POST['id']);//отправка значения
				$s -> bindValue(':idmeta', $idmetas);//отправка значения
				$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			}
		}
		catch (PDOException $e)
		{
			$error = 'Ошибка обновления информации metapost';
			include MAIN_FILE . '/includes/error.inc.php';
		}
	}
	
	//Если материал в переработке
	if (isset ($_SESSION['rewrite']) && $_SESSION['rewrite'] == true)
	{
		/*Вернуть материал в премодерацию*/
		try
		{
			$sql = 'UPDATE video SET 
					refused = "NO",
					draft = "YES" 
					WHERE id = :idvideo';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idvideo', $_POST['id']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

		}
		catch (PDOException $e)
		{
			$error = 'Ошибка отклонения публикации';
			include MAIN_FILE . '/includes/error.inc.php';
		}
	}
	
	$idpost_ind = $_POST['id'];//id материала
	
/*Предварительенй просмотр*/
	
	preview('video', $idpost_ind);
	
	/*Вывод тематик(тегов)*/
	
	$metas = previewMetas('video', 'idvideo', $idpost_ind);
	
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
		$sql = 'SELECT videotitle FROM video WHERE id = :idvideo';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idvideo', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

	}
	catch (PDOException $e)
	{
		$error = 'Ошибка публикации';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	$row = $s -> fetch();

	$title = 'Отправить в премодерацию';//Данные тега <title>
	$headMain = 'Отправить в премодерацию';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'topremod';
	$posttitle = $row['videotitle'];	
	$id = $_POST['id'];
	$button = 'Опубликовать';

	include '../commonfiles/topremoderation.html.php';
}

if (isset ($_GET['topremod']))
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	include_once MAIN_FILE . '/includes/func.inc.php';

	/*Отправка материала в премодерацию*/
	try
	{
		$sql = 'UPDATE video SET draft = "NO" WHERE id = :idvideo';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idvideo', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

	}
	catch (PDOException $e)
	{
		$error = 'Ошибка публикации';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Отправка сообщений (тест)*/
	
	$titleMessage = 'Ваш материал "'. $_POST['posttitle'].'" находится в премодерации.';
	$mailMessage = 'Вами был отправлен в премодерацию материал "'. $_POST['posttitle'].'". После успешной проверки Вам будет начислен балл';

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
		$sql = 'SELECT id, videotitle, imghead, videofile, videofileext FROM video WHERE id = :idvideo';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idvideo', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора данных video';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$title = 'Удаление видео';//Данные тега <title>
	$headMain = 'Удаление видео';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'delete';
	$posttitle = $row['videotitle'];
	$id = $row['id'];
	$button = 'Удалить';
	
	@session_start();//Открытие сессии для сохранения названия файла изображения
	
	$_SESSION['imghead'] = $row['imghead'];
	$_SESSION['videofile'] = $row['videofile'];
	$_SESSION['videofileext'] = $row['videofileext'];
	
	include '../commonfiles/delete.html.php';
}

if (isset ($_GET['delete']))
{
	/*Удаление изображения заголовка*/
	$fileName = $_SESSION['imghead'];
	$delFile = MAIN_FILE . '/images/'.$fileName;//путь к файлу для удаления
	
	$fileNameVideo = $_SESSION['videofile'].'.'.$_SESSION['videofileext'];	
	$delVideo = MAIN_FILE . '/videofiles/'.$fileNameVideo;//путь к файлу для удаления

	unlink($delFile);//удаление файла
	unlink($delVideo);//удаление файла
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'DELETE FROM comments WHERE idvideo = :idvideo';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idvideo', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации video comments';
		include MAIN_FILE . '/includes/error.inc.php';
	}
		
	try
	{
		$sql = 'DELETE FROM metapost WHERE idvideo = :idvideo';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idvideo', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации video meta';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	try
	{
		$sql = 'DELETE FROM votedauthor WHERE idvideo = :idvideo';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idvideo', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации video voted';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	try
	{
		$sql = 'DELETE FROM video WHERE id = :idvideo';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idvideo', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации video';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	

	header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	exit();
}
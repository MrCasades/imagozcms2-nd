<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка функций для формы входа*/
include_once MAIN_FILE . '/includes/addarticlesfunc.inc.php';

$pubFolder = 'addupdpost'; //Папка скрипта

/*Функция проверки на доступы*/
accessForWritingArticles();

/*Добавление информации о статье*/
if (isset($_GET['add']))//Если есть переменная add выводится форма
{
	$title = 'Добавить новую статью';//Данные тега <title>
	$headMain = 'Добавить новую статью';
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
	$button = 'Добавить статью';
	$errorForm = '';
	$authorPost = authorLogin ($_SESSION['email'], $_SESSION['password']);//возвращает имя автора
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS
	
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
		$sql = 'SELECT id, post, posttitle, idauthor, imghead, imgalt, translittitle, videoyoutube,  description, idcategory FROM posts WHERE id = :idpost';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpost', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора статьи';
		include MAIN_FILE . '/includes/error.inc.php'; 
	}
	
	$row = $s -> fetch();
	
	$title = 'Обновление статьи';//Данные тега <title>
	$headMain = 'Обновление статьи';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'editform';
	$text = $row['post'];
	$posttitle = $row['posttitle'];
	$description = $row['description'];
	$imgalt = $row['imgalt']; 
	$videoyoutube = $row['videoyoutube']; 
	$idcategory = $row['idcategory'];
	$id = $row['id'];
	$button = 'Обновить информацию о статье';
	$errorForm ='';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS
	
	@session_start();//Открытие сессии для сохранения названия файла изображения
	
	$_SESSION['imghead'] = $row['imghead'];
	
	
	/*Выбор автора статьи*/
	try
	{
		$result = $pdo -> query ('SELECT authorname FROM posts INNER JOIN author ON idauthor = author.id WHERE posts.id = '.$id);
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
		$sql = 'SELECT idmeta FROM metapost WHERE idpost = :idpost';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpost', $id);//отправка значения
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
	
	if (($_POST['category'] == '') || ($_POST['text'] == '') || ($_POST['posttitle'] == ''))
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
		$scriptJScode = '<script src="script.js"></script>';//добавить код JS
		
		@session_start();//Открытие сессии для сохранения id автора
	
		$_SESSION['posttitle'] = $_POST['posttitle'];
		$_SESSION['imgalt'] = $_POST['imgalt'];
		$_SESSION['description'] = $_POST['description'];
		$_SESSION['text'] = $_POST['text'];
		
		$posttitle = $_SESSION['posttitle'];
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
			
			$error = 'Ошибка обновления параметров задания';
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
			$error = 'Ошибка выбора времени публикации суперавтора';
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
				$error = 'Ошибка добавления времени публикации суперавтора';
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
				$error = 'Ошибка обновления времени публикации суперавтора';
				include MAIN_FILE . '/includes/error.inc.php';
			}
		}
	}
	
	try
	{
		$sql = 'INSERT INTO posts SET 
					post = :post,
					posttitle = :posttitle,	
					description = :description,
					postdate = SYSDATE(),
					imgalt = :imgalt,
					videoyoutube = :videoyoutube,
					imghead = :imghead,
					idauthor = :idauthor,
					idcategory = :idcategory,
					idtask = :idtask,
					lengthtext = :lengthtext, 
					pricepost = :priceTxt, 
					authorbonus = :bonus,
					pricetext = :fullprice';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':post', viewVideoInArticle($_POST['text']));//отправка значения
		$s -> bindValue(':posttitle', $_POST['posttitle']);//отправка значения
		$s -> bindValue(':description', $_POST['description']);//отправка значения
		$s -> bindValue(':imgalt', $_POST['imgalt']);//отправка значения
		$s -> bindValue(':videoyoutube', toEmbedInVideo($_POST['videoyoutube']));//отправка значения
		$s -> bindValue(':idcategory', $_POST['category']);//отправка значения
		$s -> bindValue(':imghead', $fileName);//отправка значения
		$s -> bindValue(':idauthor', $selectedAuthor);//отправка значения
		$s -> bindValue(':idtask', $_POST['idtask']);//отправка значения
		$s -> bindValue(':lengthtext', $lengthText);//отправка значения
		$s -> bindValue(':priceTxt', $priceTxt);//отправка значения
		$s -> bindValue(':bonus', $bonus);//отправка значения
		$s -> bindValue(':fullprice', $fullPrice);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка добавления статьи';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$idpost_ind = $pdo->lastInsertId();//метод возвращает число, которое MySQL назначил последней автомнкрементной записи (INSERT INTO post - в данном случае)

	if (isset ($_POST['metas']))
	{
		try
		{
			$sql = 'INSERT INTO metapost SET 
				idpost = :idpost, 
				idmeta = :idmeta,
				idnews = 0,
				idpromotion = 0,
				idvideo = 0';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной

			foreach	($_POST['metas'] as $idmetas)
			{		
				$s -> bindValue(':idpost', $idpost_ind);//отправка значения
				$s -> bindValue(':idmeta', $idmetas);//отправка значения
				$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			}
		}
		catch (PDOException $e)
		{
			$error = 'Ошибка добавления информации в metaname';
			include MAIN_FILE . '/includes/error.inc.php';
		}
		
	}
	
/*Предварительенй просмотр*/
	
	preview('posts', $idpost_ind);
	
	/*Вывод тематик(тегов)*/
	
	$metas = previewMetas('posts', 'idpost', $idpost_ind);
	
	include '../commonfiles/preview.html.php';
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
		
		$fileNameScript = 'img-'. time();//имя файла новости/статьи
		$filePathScript = '/images/';//папка с изображениями для новости/статьи
		
		/*Загрузка скрипта добавления файла*/
		include MAIN_FILE . '/includes/uploadfile.inc.php';
	}
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	if (($_POST['category'] == '') || ($_POST['text'] == '') || ($_POST['posttitle'] == ''))
	{
		$error = 'Один или несколько атрибутов не указаны. Выбирете все.';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	/*Определение предворительной длины и цены текста*/
	setArticlePrice($_POST['text'], 'pricepost', $_POST['id'], 'upd');//полная стоимость статьи
	
	try
	{
		$sql = 'UPDATE posts SET 
					post = :post,
					posttitle = :posttitle,
					description = :description,
					imgalt = :imgalt,
					videoyoutube = :videoyoutube,
					imghead = :imghead,
					idcategory = :idcategory,
					lengthtext = :lengthtext, 
					pricetext = :fullprice
				WHERE id = :idpost';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpost', $_POST['id']);//отправка значения
		$s -> bindValue(':post', viewVideoInArticle($_POST['text']));//отправка значения
		$s -> bindValue(':posttitle', $_POST['posttitle']);//отправка значения
		$s -> bindValue(':description', $_POST['description']);//отправка значения
		$s -> bindValue(':imghead', $fileName);//отправка значения
		$s -> bindValue(':imgalt', $_POST['imgalt']);//отправка значения
		$s -> bindValue(':videoyoutube', toEmbedInVideo($_POST['videoyoutube']));//отправка значения
		$s -> bindValue(':idcategory', $_POST['category']);//отправка значения
		$s -> bindValue(':lengthtext', $lengthText);//отправка значения
		$s -> bindValue(':fullprice', $fullPrice);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка обновления информации post';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	try
	{
		$sql = 'DELETE FROM metapost WHERE idpost = :idpost';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpost', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации metapost';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	if (isset ($_POST['metas']))
	{
		try
		{
			$sql = 'INSERT INTO metapost SET 
				idpost = :idpost, 
				idmeta = :idmeta,
				idnews = 0,
				idpromotion = 0,
				idvideo = 0';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной

			foreach	($_POST['metas'] as $idmetas)
			{		
				$s -> bindValue(':idpost', $_POST['id']);//отправка значения
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
			$sql = 'UPDATE posts SET 
					refused = "NO",
					draft = "YES" 
					WHERE id = :idpost';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idpost', $_POST['id']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

		}
		catch (PDOException $e)
		{
			$error = 'Ошибка возврата материала в черновик';
			include MAIN_FILE . '/includes/error.inc.php';
		}
	}
	
	$idpost_ind = $_POST['id'];//id материала
	
/*Предварительенй просмотр*/
	
	preview('posts', $idpost_ind);
	
	/*Вывод тематик(тегов)*/
	
	$metas = previewMetas('posts', 'idpost', $idpost_ind);
	
	include '../commonfiles/preview.html.php';
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
		$sql = 'SELECT posttitle, pricetext FROM posts WHERE id = :idpost';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpost', $_POST['id']);//отправка значения
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
	$posttitle = $row['posttitle'];
	$price = $row['pricetext'];
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
		$sql = 'UPDATE posts SET draft = "NO" WHERE id = :idpost';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpost', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

	}
	catch (PDOException $e)
	{
		$error = 'Ошибка отправки в премодерацию';
		include MAIN_FILE . '/includes/error.inc.php';
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
		$sql = 'SELECT id, posttitle, imghead FROM posts WHERE id = :idpost';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpost', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора id и заголовка posts';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$title = 'Удаление статьи';//Данные тега <title>
	$headMain = 'Удаление статьи';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'delete';
	$posttitle = $row['posttitle'];
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
		$sql = 'DELETE FROM comments WHERE idpost = :idpost';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpost', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации comments';
		include MAIN_FILE . '/includes/error.inc.php';
	}
		
	try
	{
		$sql = 'DELETE FROM metapost WHERE idpost = :idpost';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpost', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации metapost';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	try
	{
		$sql = 'DELETE FROM votedauthor WHERE idpost = :idpost';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpost', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации votedauthor';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	try
	{
		$sql = 'DELETE FROM posts WHERE id = :idpost';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpost', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	

	header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	exit();
}
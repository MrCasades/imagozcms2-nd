﻿<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

$pubFolder = 'addupdblogpublication'; //Папка скрипта

/*Определение нахождения пользователя в системе*/
if (!loggedIn())
{
	include '../login.html.php';
	exit();
}

/*Загрузка сообщения об ошибке входа*/
// if ((!userRole('Администратор')) && (!userRole('Автор')) && (!userRole('Рекламодатель')))
// {
// 	$title = 'Ошибка доступа';//Данные тега <title>
// 	$headMain = 'Ошибка доступа';
// 	$robots = 'noindex, nofollow';
// 	$descr = '';
// 	$error = 'В данный раздел доступ запрещён!';
// 	include '../accessfail.html.php';
// 	exit();
// }

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
if (isset ($_POST['action']) && $_POST['action'] == 'Добавить статью')
{
	$title = 'Добавить новую статью';//Данные тега <title>
	$headMain = 'Добавить новую статью';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'addform';
	$articletitle = '';
	$translittitle = '';
	$description = '';
	$text = '';
	$idauthor = '';
	$imgHead = '';
	$videoyoutube = '';
	$idcategory = '';
	$id = '';
	$idBlog = $_POST['id'];
	$button = 'Добавить статью';
	$errorForm = '';
	$authorPost = authorLogin ($_SESSION['email'], $_SESSION['password']);//возвращает имя автора
	$scriptJScode = '<script src="../commonfiles/addarticlescripts-md.js"></script>';//добавить код JS

	/*Инициализация блога*/
	require_once MAIN_FILE . '/includes/blogvar.inc.php';

	/*Получение атрибутов блога для шапки */
	getBlogAtributs($_POST['id']);

	addListsInForms();
		
	include '../commonfiles/addupdform.html.php';
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

	else
	{
		@session_start();//Открытие сессии для сохранения флага переработки
	
		$_SESSION['rewrite'] = false;
	}
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT id, text, title, idauthor, idblog, imghead, videoyoutube, description, idcategory FROM publication WHERE id = :idpublication';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpublication', $_POST['id']);//отправка значения
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
	$text = $row['text'];
	$articletitle = $row['title'];
	$description = $row['description'];
	$idcategory = $row['idcategory'];
	$videoyoutube = $row['videoyoutube'];
	$id = $row['id'];
	$imgHead = $row['imghead']; 
	$idBlog = $row['idblog'];
	$button = 'Обновить информацию о статье';
	$errorForm ='';
	$scriptJScode = '<script src="../commonfiles/addarticlescripts-md.js"></script>';//добавить код JS
		
	$promotionPrice = 0;

	/*Инициализация блога*/
	require_once MAIN_FILE . '/includes/blogvar.inc.php';
	
	/*Получение атрибутов блога для шапки */
	getBlogAtributs($idBlog);
	
	/*Выбор автора статьи*/
	try
	{
		$result = $pdo -> query ('SELECT authorname FROM publication INNER JOIN author ON idauthor = author.id WHERE publication.id = '.$id);
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
	
	$authorPost = $row['authorname'];//возвращает имя автора

	/*Список тематик*/
	try
	{
		$sql = 'SELECT m.id, m.metaname FROM meta m INNER JOIN metapost mp ON m.id = mp.idmeta WHERE idpublication = :idpublication';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpublication', $id);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		// $result = $pdo -> query ('SELECT id, metaname FROM meta INNER ORDER BY metaname');
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода meta';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	foreach ($s as $row)
	{
		$metas_1[] = array('idmeta' => $row['id'],'metaname' => $row['metaname']/*, 'selected' => in_array($row['id'], $selectedMeta)*/);
		$metas_2[] = array('idmeta' => $row['id'],'metaname' => $row['metaname']/*, 'selected' => in_array($row['id'], $selectedMeta)*/);
	}

	include '../commonfiles/addupdform.html.php';
	exit();
}

/*команда INSERT  - добавление в базу данных*/
if (isset($_GET['addform']))//Если есть переменная addform выводится форма
{
	/*Загрузка функций для формы входа*/
	require_once MAIN_FILE . '/includes/access.inc.php';
		
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	/*Подключение функций*/
	include_once MAIN_FILE . '/includes/func.inc.php';

	$fileNameScript = 'img-'. time().rand(100, 999);//имя файла изображения
	$filePathScript = '/images/';//папка с изображениями для новости/статьи
	
	//Загрузка файла изображения
	$fileName = uploadImgHeadFull ($fileNameScript, $filePathScript);
	
	/*Возвращение id автора*/
	
	$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора
	
	if (($_POST['articletext'] == '') || ($_POST['articletitle'] == ''))
	{
		$title = 'Добавить новую статью';//Данные тега <title>
		$headMain = 'Добавить новую статью';
		$robots = 'noindex, nofollow';
		$descr = '';
		$action = 'addform';
		$idauthor = '';
		$idcategory = '';
		$id = '';
		$button = 'Добавить статью';
		$authorPost = authorLogin ($_SESSION['email'], $_SESSION['password']);//возвращает имя автора
		$errorForm = 'Один или несколько атрибутов не указаны. Выбирете все!';
		$scriptJScode = '<script src="../commonfiles/addarticlescripts-md.js"></script>';//добавить код JS
		
		@session_start();//Открытие сессии для сохранения id автора
	
		$_SESSION['articletitle'] = $_POST['articletitle'];
		$_SESSION['description'] = $_POST['description'];
		$_SESSION['articletext'] = $_POST['articletext'];
		
		$articletitle = $_SESSION['articletitle'];
		$description = $_SESSION['description'];
		$text = $_SESSION['articletext'];
		
		/*Вывод информации для формы добавления*/
		
		addListsInForms();
		
		include '../commonfiles/addupdform.html.php';
		exit();
	}

	if (empty($_POST['category']))
		$_POST['category'] = 6;
	
	/*INSERT - добавление информации в базу данных и списание средств со счёта*/
	
	try
	{
		$sql = 'INSERT INTO publication SET 
					text = :articletext,
					title = :articletitle,	
					description = :description,
					date = SYSDATE(),
					videoyoutube = :videoyoutube,
					imghead = :imghead,
					idcategory = :idcategory,
					idauthor = :idauthor,
					idblog = :idblog';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':articletext', viewVideoInArticle($_POST['articletext']));//отправка значения
		$s -> bindValue(':articletitle', $_POST['articletitle']);//отправка значения
		$s -> bindValue(':description', $_POST['description']);//отправка значения
		$s -> bindValue(':videoyoutube', toEmbedInVideo($_POST['videoyoutube']));//отправка значения
		$s -> bindValue(':imghead', $fileName);//отправка значения
		$s -> bindValue(':idcategory', $_POST['category']);//отправка значения
		$s -> bindValue(':idauthor', $selectedAuthor);//отправка значения
		$s -> bindValue(':idblog', $_POST['blogid']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка добавления информации promotion';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	$idpost_ind = $pdo->lastInsertId();//метод возвращает число, которое MySQL назначил последней автомнкрементной записи (INSERT INTO post - в данном случае)
	
	if (isset ($_POST['metas']))
	{
		try
		{
			$sql = 'INSERT INTO metapost SET 
				idpublication = :idpublication, 
				idmeta = :idmeta,
				idnews = 0,
				idpost = 0,
				idvideo = 0,
				idpromotion = 0';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной

			foreach	($_POST['metas'] as $idmetas)
			{		
				$s -> bindValue(':idpublication', $idpost_ind);//отправка значения
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

	$idBlog = $_POST['blogid'];

	/*Инициализация блога*/
	require_once MAIN_FILE . '/includes/blogvar.inc.php';

	/*Получение атрибутов блога для шапки */
	getBlogAtributs($_POST['blogid']);

	preview('publication', $idpost_ind);
	
	/*Вывод тематик(тегов)*/
	
	$metas = previewMetas('publication', 'idpublication', $idpost_ind);
	
	include '../commonfiles/preview.html.php';
	exit();
}

/*UPDATE - обновление информации в базе данных*/

if (isset($_GET['editform']))//Если есть переменная editform выводится форма
{
	/*Подключение функций*/
	include_once MAIN_FILE . '/includes/func.inc.php';

	$fileNameScript = 'img-'. time().rand(100, 999);//имя файла изображения
	$filePathScript = '/images/';//папка с изображениями для новости/статьи

	$fileName = uploadImgHeadFull ($fileNameScript, $filePathScript, 'upd', 'publication', $_POST['id']);
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	if (($_POST['articletext'] == '') || ($_POST['articletitle'] == ''))
	{
		$error = 'В форме есть незаполненные поля!';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	/*UPDATE - обновление информации в базе данных*/
	try
	{
		$sql = 'UPDATE publication SET 
					text = :articletext,
					title = :articletitle,
					description = :description,
					videoyoutube = :videoyoutube,
					imghead = :imghead
				WHERE id = :idpub';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpub', $_POST['id']);//отправка значения
		$s -> bindValue(':articletext', viewVideoInArticle($_POST['articletext']));//отправка значения
		$s -> bindValue(':articletitle', $_POST['articletitle']);//отправка значения
		$s -> bindValue(':description', $_POST['description']);//отправка значения
		$s -> bindValue(':videoyoutube', toEmbedInVideo($_POST['videoyoutube']));//отправка значения
		$s -> bindValue(':imghead', $fileName);//отправка значения
		//$s -> bindValue(':idcategory', $_POST['category']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка обновления информации publication';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	try
	{
		$sql = 'DELETE FROM metapost WHERE idpublication = :idpublication';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpublication', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации metapost';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Обновление тегов*/
	if (isset ($_POST['metas']))
	{
		try
		{
			$sql = 'INSERT INTO metapost SET 
				idpublication = :idpublication, 
				idmeta = :idmeta,
				idnews = 0,
				idpost = 0,
				idpromotion = 0,
				idvideo = 0';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной

			foreach	($_POST['metas'] as $idmetas)
			{		
				$s -> bindValue(':idpublication', $_POST['id']);//отправка значения
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
			$sql = 'UPDATE publication SET 
					refused = "NO",
					draft = "YES"  
					WHERE id = :idpublication';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idpublication', $_POST['id']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

		}
		catch (PDOException $e)
		{
			$error = 'Ошибка возврата материала в черновик';
			include MAIN_FILE . '/includes/error.inc.php';
		}

		$_SESSION['rewrite'] = false;
	}
	
	$idpost_ind = $_POST['id'];//id материала

	/*Проверка на нахождение в черновике*/
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT draft, premoderation FROM publication WHERE id = :idpublication';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpublication', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора статьи';
		include MAIN_FILE . '/includes/error.inc.php'; 
	}
	
	$row = $s -> fetch();

	if ($row['draft'] == 'NO' && $row['premoderation'] == 'YES')//Доработать!
	{
		/*UPDATE - обновление информации в базе данных*/
		try
		{
			$sql = 'UPDATE publication SET 
						upddate = SYSDATE(),
						secondpremoderation = "NO"
					WHERE id = :idpub';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idpub', $_POST['id']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}
		catch (PDOException $e)
		{
			$error = 'Ошибка обновления информации publication';
			include MAIN_FILE . '/includes/error.inc.php';
		}

		header ('Location: //'.MAIN_URL.'/blog/publication/?id='.$idpost_ind);//перенаправление обратно в контроллер index.php
		exit();
	}

	else
	{
		/*Предварительенй просмотр*/

		$idBlog = $_POST['blogid'];

		/*Инициализация блога*/
		require_once MAIN_FILE . '/includes/blogvar.inc.php';

		/*Получение атрибутов блога для шапки */
		getBlogAtributs($idBlog);
		
		preview('publication', $idpost_ind);
		
		/*Вывод тематик(тегов)*/
		
		$metas = previewMetas('publication', 'idpublication', $idpost_ind);
		
		include '../commonfiles/preview.html.php';
		exit();
	}
}

/*Публикация материала*/

if (isset ($_POST['action']) && $_POST['action'] == 'ОПУБЛИКОВАТЬ')
{
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	$idBlog = $_POST['blogid'];

	/*Инициализация блога*/
	require_once MAIN_FILE . '/includes/blogvar.inc.php';

	/*Получение атрибутов блога для шапки */
	getBlogAtributs($idBlog);

	/*Отправка материала в премодерацию*/
	try
	{
		$sql = 'SELECT title FROM publication WHERE id = :idpublication';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpublication', $_POST['id']);//отправка значения
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
	$posttitle = $row['title'];
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
		$sql = 'UPDATE publication SET draft = "NO" WHERE id = :idpub';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpub', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

	}
	catch (PDOException $e)
	{
		$error = 'Ошибка отправки в премодерацию';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Отправка сообщений (тест)*/
	
	$titleMessage = 'Ваш материал "'. $_POST['posttitle'].'" находится в премодерации.';
	$mailMessage = 'Вами был отправлен в премодерацию материал "'. $_POST['posttitle'].'". После успешной проверки он будет опубликован';

	toEmail_1($titleMessage, $mailMessage);//отправка письма

	$title = 'Материал в премодерации';//Данные тега <title>
	$headMain = 'Материал в премодерации';
	$robots = 'noindex, nofollow';
	$descr = '';

	include '../commonfiles/successfulpub.html.php';

	// header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	// exit();
}

/*DELETE - удаление материала*/

if (isset ($_POST['action']) && $_POST['action'] == 'Del')
{	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT id, title, imghead FROM publication WHERE id = :idpublication';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpublication', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора id и заголовка promotion';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$title = 'Удаление статьи';//Данные тега <title>
	$headMain = 'Удаление статьи';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'delete';
	$posttitle = $row['title'];
	$id = $row['id'];
	$button = 'Удалить';
	
	@session_start();//Открытие сессии для сохранения названия файла изображения
	
	$_SESSION['imghead'] = $row['imghead'];
	
	include '../commonfiles/delete.html.php';
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
		$sql = 'DELETE FROM comments WHERE idpublication = :idpublication';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpublication', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации comments';
		include MAIN_FILE . '/includes/error.inc.php';
	}
		
	try
	{
		$sql = 'DELETE FROM metapost WHERE idpublication = :idpublication';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpublication', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации metapost';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	try
	{
		$sql = 'DELETE FROM votedauthor WHERE idpublication = :idpublication';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpublication', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации votedauthor';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	try
	{
		$sql = 'DELETE FROM publication WHERE id = :idpublication';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpublication', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации promotion';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	

	header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	exit();
}


/*Изменение статуса повторной премодерации */
if (isset ($_GET['addyes']))
{	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'UPDATE publication SET 
					secondpremoderation = "YES"
				WHERE id = :idpub';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpub', $_GET['idpub']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления информации blogs';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	header ('Location: //'.MAIN_URL.'/blog/publication/?id='.$_GET['idpub']);//перенаправление обратно в контроллер index.php
	exit();
}

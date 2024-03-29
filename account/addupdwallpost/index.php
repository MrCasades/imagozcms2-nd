<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

// /*команда INSERT  - добавление комментария в базу данных*/
// if (isset($_GET['addform']))//Если есть переменная addform выводится форма
// {
// 	/*Если поле комментария пустое*/
// 	if ($_POST['comment'] == '')
// 	{
// 		$title = 'Напишите текст комментария!';//Данные тега <title>
// 		$headMain = 'Напишите текст комментария!';
// 		$robots = 'noindex, nofollow';
// 		$descr = '';
// 		$error = 'Поле комментария не может быть пустым!';
// 		include 'error.html.php';
// 		exit();
// 	}
	
// 	/*Загрузка изображения на стену*/
	
// 	$fileNameScript = 'comm-'. time();//имя файла новости/статьи
// 	$filePathScript = '/images/';//папка с изображениями для новости/статьи
	
// 	/*Загрузка скрипта добавления файла*/
// 	include MAIN_FILE . '/includes/uploadfile.inc.php';
	
// 	/*Подключение к базе данных*/
// 	include MAIN_FILE . '/includes/db.inc.php';
		
// 	/*Возвращение id автора*/
		
// 	$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора
		
// 	try
// 	{
// 		$sql = 'INSERT INTO comments SET 
// 			comment = :comment,	
// 			commentdate = SYSDATE(),
// 			imgalt = :imgalt,
// 			imghead = '.'"'.$fileName.'"'.', '.
// 			'idauthor = '.$selectedAuthor.','.
// 			'idaccount = :idauthin';
// 		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
// 		$s -> bindValue(':comment', $_POST['comment']);//отправка значения
// 		$s -> bindValue(':imgalt', $_POST['imgalt']);//отправка значения
// 		$s -> bindValue(':idauthin', $_POST['idauthin']);//отправка значения
// 		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
// 	}
	
// 	catch (PDOException $e)
// 	{
// 		$error = 'Ошибка добавления информации';
// 		include MAIN_FILE . '/includes/error.inc.php';
// 	}
	
// 	header ('Location: ../../account/?id='.$_POST['idauthin']);//перенаправление обратно в контроллер index.php
// 	exit();	
// }

/*Обновление комментария*/
if (isset ($_POST['action']) && $_POST['action'] == 'Редактировать')
{		
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	try
	{
		$sql = 'SELECT * FROM comments  
		WHERE id = :idcomment';//Вверху самое последнее значение
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idcomment', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора записи';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();	
	
	$title = 'Редактирование записи | imagoz.ru';//Данные тега <title>
	$headMain = 'Редактирование записи';
	$robots = 'noindex, follow';
	$descr = 'Форма редактирования записи';
	$action = 'editform';	
	$text = $row['comment'];
	$imgalt = $row['imgalt'];
	$idAutIn = $_POST['idaut'];
	$id = $row['id'];
	$button = 'Обновить запись';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS
	
	$_GLOBALS['imghead'] = $row['imghead'];//сохранить файл изображения
	
	include 'formwall.html.php';
	exit();
}
		
/*UPDATE - обновление текста комментария*/

if (isset($_GET['editform']))//Если есть переменная editform выводится форма
{
	/*Подключение функций*/
	include_once MAIN_FILE . '/includes/func.inc.php';

	$fileNameScript = 'img-'. time();//имя файла изображения
	$filePathScript = '/images/';//папка с изображениями для новости/статьи

	$fileName = uploadImgHeadFull ($fileNameScript, $filePathScript, 'upd', 'comments', $_POST['comment']);
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'UPDATE comments SET 
			comment = :comment,
			imgalt = :imgalt,
			imghead = '.'"'.$fileName.'"'.
			' WHERE id = :idcomment';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idcomment', $_POST['id']);//отправка значения
		$s -> bindValue(':comment', $_POST['comment']);//отправка значения
		$s -> bindValue(':imgalt', $_POST['imgalt']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
		
	catch (PDOException $e)
	{
		$error = 'Ошибка обновления информации comment';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	header ('Location: ../../account/?id='.$_POST['idautin']);//перенаправление обратно в контроллер index.php
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
		$sql = 'SELECT id, imghead FROM comments WHERE id = :idcomment';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idcomment', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора id и заголовка';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$title = 'Удаление записи';//Данные тега <title>
	$headMain = 'Удаление записи';
	$robots = 'noindex, follow';
	$descr = '';
	$action = 'delete';
	$posttitle = 'Запись';
	$id = $row['id'];
	$idAutIn = $_POST['idaut'];
	$button = 'Удалить';
	
	$_GLOBALS['imghead'] = $row['imghead'];//сохранить файл изображения
	
	include 'delete.html.php';
}
	
if (isset ($_GET['delete']))
{
	/*Удаление изображения заголовка*/
	$fileName = $imghead;
	$delFile = MAIN_FILE . '/images/'.$fileName;//путь к файлу для удаления
	unlink($delFile);//удаление файла
	
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	try
	{
		$sql = 'DELETE FROM comments WHERE id = :idcomment';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idcomment', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка удаления комментария';
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
	
	header ('Location: ../../account/?id='.$_POST['idautin']);//перенаправление обратно в контроллер index.php
	exit();
}	
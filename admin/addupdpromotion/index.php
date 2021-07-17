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
if ((!userRole('Администратор')) && (!userRole('Автор')) && (!userRole('Рекламодатель')))
{
	$title = 'Ошибка доступа';//Данные тега <title>
	$headMain = 'Ошибка доступа';
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'В данный раздел доступ запрещён!';
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
	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Команда SELECT выбор цены промоушена*/
	try
	{
		$sql = 'SELECT promotionprice FROM promotionprice WHERE id = 1';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Error select book: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
	
	$promotionPrice = $row['promotionprice'];
	
	@session_start();//Открытие сессии для сохранения id задания

	$_SESSION['promotionprice'] = $promotionPrice;
	
	/*Возвращение id автора*/
	
	$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора
	
	/*Команда SELECT выбор счёа автора для сравнения*/
	try
	{
		$sql = 'SELECT score, authorpaymentstatus FROM author WHERE id = '.$selectedAuthor;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Error select book: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
	
	$score = $row['score'];
	$paymentStatus = $row['authorpaymentstatus'];
	
	if ($promotionPrice > $score)//Если на счету нет достаточной суммы для написания статьи.
	{
		$title = 'Ошибка доступа';//Данные тега <title>
		$headMain = 'Ошибка доступа';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Для написания рекламной статьи на Вашем счету должно быть сумма больше или равная '.$promotionPrice.'. Пополните счёт в своём профиле!';
		
		unset ($_SESSION['promotionprice']);
			
		include '../accessfail.html.php';
		exit();
	}
	
	elseif ($paymentStatus == 'NO')//Если ранее была сформирована заявка на вывод средств.
	{
		$title = 'Ошибка доступа';//Данные тега <title>
		$headMain = 'Ошибка доступа';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Вы ранее сформировали заявку на вывод средств. Пока она не будет подтверждена, Вы не сможете писать рекламные статьи!';
		
		unset ($_SESSION['promotionprice']);
			
		include '../accessfail.html.php';
		exit();
	}
	
	else
	{
	
		$title = 'Добавить новую статью';//Данные тега <title>
		$headMain = 'Добавить новую статью';
		$robots = 'noindex, nofollow';
		$descr = '';
		$action = 'addform';
		$promotiontitle = '';
		$translittitle = '';
		$description = '';
		$text = '';
		$imgalt = '';
		$idauthor = '';
		$videoyoutube = '';
		$idcategory = '';
		$id = '';
		$www = '';
		$button = 'Добавить статью';
		$errorForm = '';
		$authorPost = authorLogin ($_SESSION['email'], $_SESSION['password']);//возвращает имя автора
		$scriptJScode = '<script src="script.js"></script>';//добавить код JS

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
		$sql = 'SELECT id, promotion, promotiontitle, www, idauthor, imghead, imgalt, videoyoutube, promotiontitle, description, idcategory FROM promotion WHERE id = :idpromotion';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpromotion', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Error select book: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
	
	$title = 'Обновление статьи';//Данные тега <title>
	$headMain = 'Обновление статьи';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'editform';
	$text = $row['promotion'];
	$promotiontitle = $row['promotiontitle'];
	$description = $row['description'];
	$imgalt = $row['imgalt']; 
	$idcategory = $row['idcategory'];
	$videoyoutube = $row['videoyoutube'];
	$id = $row['id'];
	$www = $row['www'];
	$button = 'Обновить информацию о статье';
	$errorForm ='';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS
	
	@session_start();//Открытие сессии для сохранения названия файла изображения
	
	$_SESSION['imghead'] = $row['imghead'];
	
	
	/*Выбор автора статьи*/
	try
	{
		$result = $pdo -> query ('SELECT authorname FROM promotion INNER JOIN author ON idauthor = author.id WHERE promotion.id = '.$id);
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
	
	$authorPost = $row['authorname'];//возвращает имя автора00
	
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
		$sql = 'SELECT idmeta FROM metapost WHERE idpromotion = :idpromotion';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpromotion', $id);//отправка значения
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

	/*Подключение функций*/
	include_once MAIN_FILE . '/includes/func.inc.php';
	
	/*Возвращение id автора*/
	
	$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора
	
	if (($_POST['category'] == '') || ($_POST['text'] == '') || ($_POST['promotiontitle'] == ''))
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
		$scriptJScode = '<script src="script.js"></script>';//добавить код JS
		
		@session_start();//Открытие сессии для сохранения id автора
	
		$_SESSION['promotiontitle'] = $_POST['promotiontitle'];
		$_SESSION['imgalt'] = $_POST['imgalt'];
		$_SESSION['description'] = $_POST['description'];
		$_SESSION['text'] = $_POST['text'];
		
		$promotiontitle = $_SESSION['promotiontitle'];
		$imgalt = $_SESSION['imgalt'];
		$description = $_SESSION['description'];
		$text = $_SESSION['text'];
		
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
	
	/*INSERT - добавление информации в базу данных и списание средств со счёта*/
	
	try
	{
		$pdo->beginTransaction();//инициация транзакции
		
		$sql = 'INSERT INTO promotion SET 
			promotion = :promotion,
			promotiontitle = :promotiontitle,	
			description = :description,
			promotiondate = SYSDATE(),
			imgalt = :imgalt,
			videoyoutube = :videoyoutube,
			www = :www,
			pricetext = '.$_SESSION['promotionprice'].',
			imghead = '.'"'.$fileName.'"'.', '.
			'idauthor = '.$selectedAuthor.','.
			'idcategory = :idcategory';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':promotion', viewVideoInArticle($_POST['text']));//отправка значения
		$s -> bindValue(':promotiontitle', $_POST['promotiontitle']);//отправка значения
		$s -> bindValue(':description', $_POST['description']);//отправка значения
		$s -> bindValue(':imgalt', $_POST['imgalt']);//отправка значения
		$s -> bindValue(':videoyoutube', toEmbedInVideo($_POST['videoyoutube']));//отправка значения
		$s -> bindValue(':www', $_POST['www']);//отправка значения
		$s -> bindValue(':idcategory', $_POST['category']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		$idpost_ind = $pdo->lastInsertId();//метод возвращает число, которое MySQL назначил последней автомнкрементной записи (INSERT INTO post - в данном случае)
		
		$sql = 'UPDATE author SET score  = score - '.$_SESSION['promotionprice'].'
								  WHERE id = '.$selectedAuthor;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		
		$pdo->commit();//подтверждение транзакции
	}
	
	catch (PDOException $e)
	{
		$pdo->rollBack();//отмена транзакции
			
		$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
		$headMain = 'Ошибка данных!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка добавления информации '. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	if (isset ($_POST['metas']))
	{
		try
		{
			$sql = 'INSERT INTO metapost SET 
				idpromotion = :idpromotion, 
				idmeta = :idmeta,
				idnews = 0,
				idpost = 0';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной

			foreach	($_POST['metas'] as $idmetas)
			{		
				$s -> bindValue(':idpromotion', $idpost_ind);//отправка значения
				$s -> bindValue(':idmeta', $idmetas);//отправка значения
				$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			}
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
	
/*Предварительенй просмотр*/
	
	$select = 'SELECT promotion.id AS promotionid, author.id AS idauthor, promotion, promotiontitle, imghead, description, imgalt, promotiondate, authorname, category.id AS categoryid, categoryname FROM promotion 
			   INNER JOIN author ON idauthor = author.id 
			   INNER JOIN category ON idcategory = category.id WHERE premoderation = "NO" AND promotion.id = ';

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
		$promotions[] =  array ('id' => $row['promotionid'], 'idauthor' => $row['idauthor'],  'text' => $row['promotion'], 'promotiontitle' =>  $row['promotiontitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
							'description' => $row['description'], 'promotiondate' => $row['promotiondate'], 
						    'authorname' => $row['authorname'], 'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}	
	
	/*Вывод тематик(тегов)*/
	
	/*Команда SELECT*/
	
	try
	{
		$sql = 'SELECT meta.id, metaname FROM promotion 
				INNER JOIN metapost ON promotion.id = idpromotion 
				INNER JOIN meta ON meta.id = idmeta 
				WHERE promotion.id = '.$idpost_ind;//Вверху самое последнее значение
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
	
	$delAndUpd = "<form action = '../../admin/addupdpromotion/' method = 'post'>
			
						Редактировать материал:
						<input type = 'hidden' name = 'id' value = '".$idpost_ind."'>
						<input type = 'submit' name = 'action' value = 'Upd' class='btn btn-primary btn-sm'>
					  </form>";
	
	$title = 'Материал сохранён в черновике';//Данные тега <title>
	$headMain = 'Материал сохранён в черновике';
	$robots = 'noindex, nofollow';
	$descr = '';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS
	
	unset($_SESSION['promotionprice']);//закрытие сессии
	
	include 'premodsucc.html.php';
	exit();
}

/*UPDATE - обновление информации в базе данных*/

if (isset($_GET['editform']))//Если есть переменная editform выводится форма
{
	/*Подключение функций*/
	include_once MAIN_FILE . '/includes/func.inc.php';

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
	
	if (($_POST['category'] == '') || ($_POST['text'] == '') || ($_POST['promotiontitle'] == ''))
	{
		$title = 'В форме есть незаполненные поля!';//Данные тега <title>
		$headMain = 'В форме есть незаполненные поля!';
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Один или несколько атрибутов не указаны. Выбирете все.';
		include 'error.html.php';
		exit();
	}
	
	/*UPDATE - обновление информации в базе данных*/
	try
	{
		$sql = 'UPDATE promotion SET 
			promotion = :promotion,
			promotiontitle = :promotiontitle,
			description = :description,
			imgalt = :imgalt,
			videoyoutube = :videoyoutube,
			www = :www,
			imghead = '.'"'.$fileName.'"'.', '.
			'idcategory = :idcategory
			WHERE id = :idpromotion';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpromotion', $_POST['id']);//отправка значения
		$s -> bindValue(':promotion', viewVideoInArticle($_POST['text']));//отправка значения
		$s -> bindValue(':promotiontitle', $_POST['promotiontitle']);//отправка значения
		$s -> bindValue(':description', $_POST['description']);//отправка значения
		$s -> bindValue(':imgalt', $_POST['imgalt']);//отправка значения
		$s -> bindValue(':videoyoutube', toEmbedInVideo($_POST['videoyoutube']));//отправка значения
		$s -> bindValue(':www', $_POST['www']);//отправка значения
		$s -> bindValue(':idcategory', $_POST['category']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка обновления информации post'. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	try
	{
		$sql = 'DELETE FROM metapost WHERE idpromotion = :idpromotion';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpromotion', $_POST['id']);//отправка значения
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
				idpromotion = :idpromotion, 
				idmeta = :idmeta,
				idnews = 0,
				idpost = 0';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной

			foreach	($_POST['metas'] as $idmetas)
			{		
				$s -> bindValue(':idpromotion', $_POST['id']);//отправка значения
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
			$sql = 'UPDATE promotion SET 
					refused = "NO",
					draft = "YES"  
					WHERE id = :idpromotion';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idpromotion', $_POST['id']);//отправка значения
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
	
	$select = 'SELECT promotion.id AS promotionid, author.id AS idauthor, promotion, promotiontitle, imghead, description, imgalt, promotiondate, authorname, category.id AS categoryid, categoryname FROM promotion 
			   INNER JOIN author ON idauthor = author.id 
			   INNER JOIN category ON idcategory = category.id WHERE premoderation = "NO" AND promotion.id = ';

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
		$promotions[] =  array ('id' => $row['promotionid'], 'idauthor' => $row['idauthor'],  'text' => $row['promotion'], 'promotiontitle' =>  $row['promotiontitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
							'description' => $row['description'], 'promotiondate' => $row['promotiondate'], 
						    'authorname' => $row['authorname'], 'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}	
	
	/*Вывод тематик(тегов)*/
	
	/*Команда SELECT*/
	
	try
	{
		$sql = 'SELECT meta.id, metaname FROM promotion 
				INNER JOIN metapost ON promotion.id = idpromotion 
				INNER JOIN meta ON meta.id = idmeta 
				WHERE promotion.id = '.$idpost_ind;//Вверху самое последнее значение
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
	
	$delAndUpd = "<form action = '../../admin/addupdpromotion/' method = 'post'>
			
						Редактировать материал:
						<input type = 'hidden' name = 'id' value = '".$idpost_ind."'>
						<input type = 'submit' name = 'action' value = 'Upd' class='btn btn-primary btn-sm'>
					  </form>";
	
	$title = 'Материал сохранён в черновике';//Данные тега <title>
	$headMain = 'Материал сохранён в черновике';
	$robots = 'noindex, nofollow';
	$descr = '';
	$scriptJScode = '<script src="script.js"></script>';//добавить код JS
	
	unset($_SESSION['promotionprice']);//закрытие сессии
	
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
		$sql = 'SELECT promotiontitle FROM promotion WHERE id = :idpromotion';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpromotion', $_POST['id']);//отправка значения
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
	$posttitle = $row['promotiontitle'];
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
		$sql = 'UPDATE promotion SET draft = "NO" WHERE id = :idpromotion';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpromotion', $_POST['id']);//отправка значения
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
	$mailMessage = 'Вами был отправлен в премодерацию материал "'. $_POST['posttitle'].'". После успешной проверки он будет опубликован';

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
		$sql = 'SELECT id, promotiontitle, imghead FROM promotion WHERE id = :idpromotion';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpromotion', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Error select book: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	$row = $s -> fetch();
	
	$title = 'Удаление статьи';//Данные тега <title>
	$headMain = 'Удаление статьи';
	$robots = 'noindex, nofollow';
	$descr = '';
	$action = 'delete';
	$promotiontitle = $row['promotiontitle'];
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
		$sql = 'DELETE FROM comments WHERE idpromotion = :idpromotion';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpromotion', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка удаления информации comments'. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
		
	try
	{
		$sql = 'DELETE FROM metapost WHERE idpromotion = :idpromotion';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpromotion', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка удаления информации metapost'. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	try
	{
		$sql = 'DELETE FROM votedauthor WHERE idpromotion = :idpromotion';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpromotion', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка удаления информации voted'. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	
	try
	{
		$sql = 'DELETE FROM promotion WHERE id = :idpromotion';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idpromotion', $_POST['id']);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$robots = 'noindex, nofollow';
		$descr = '';
		$error = 'Ошибка удаления информации promotion'. ' Error: '. $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.html.php';
		exit();
	}
	

	header ('Location: //'.MAIN_URL);//перенаправление обратно в контроллер index.php
	exit();
}
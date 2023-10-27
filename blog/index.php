<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка общих переменных*/
include_once MAIN_FILE . '/includes/commonvar.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Определение нахождения пользователя в системе*/
loggedIn();

/*Загрузка содержимого статьи*/
if (isset ($_GET['id']))
{
	/*Инициализация блога*/
	require_once MAIN_FILE . '/includes/blogvar.inc.php';

	/*Получение атрибутов блога для шапки */
	getBlogAtributs($_GET['id']);

	(int) $idBlog = $_GET['id'];

	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	/*Постраничный вывод информации*/
			
	$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;// помещаем номер страницы из массива GET в переменую $page
	$onPage = 10;// количество статей на страницу
	$shift = ($page - 1) * $onPage;// (номер страницы - 1) * статей на страницу

	/*Вывод блога*/
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT 
					b.id as blogid
				
					,b.description
					,b.avatar
					,b.indexing
					,b.idauthor
					,b.blogpremoderation
					,b.subscriptioncount
					,a.authorname
				FROM blogs b
				INNER JOIN author a ON b.idauthor = a.id 
				WHERE b.id = :blogid';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':blogid', $idBlog);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка вывода информации о блоге';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	$row = $s -> fetch();
		
	$blogId = $row['blogid'];
	$authorId = $row['idauthor'];
	//$blogTitle = $row['title'];
	$blogDescr = $row['description'];
	//$imgHead = $row['imghead'];
	$avatar = $row['avatar'];
	$indexing = $row['indexing'];
	$nameAuthor = $row['authorname'];
	$premodStatus = $row['blogpremoderation'];
	$subscriptionCount = $row['subscriptioncount'];

	/*Если страница отсутствует. Ошибка 404*/
	if (!$row)
	{
		header ('Location: ../page-not-found/');//перенаправление обратно в контроллер index.php
		exit();	
	}

	/*Определение количества статей*/
	// try
	// {
	// 	$sql = "SELECT count(id) AS all_articles FROM posts WHERE premoderation = 'YES' AND zenpost = 'NO'";
	// 	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	// 	$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	// }

	// catch (PDOException $e)
	// {
	// 	$error = 'Ошибка подсчёта статей';
	// 	include MAIN_FILE . '/includes/error.inc.php';
	// }
		
	// $row = $s -> fetch();
		
	// $countPosts = $row["all_articles"];
	// $pagesCount = ceil($countPosts / $onPage);

	$selectedAuthor = (isset($_SESSION['loggIn'])) ? (int)(authorID($_SESSION['email'], $_SESSION['password'])) : '';//id автора

	$isBlocked = checkBlockedAuthor($selectedAuthor);//Проверка пользователя на бан


	/*Определение подписки на блог */

	if (isset($_SESSION['loggIn']))
	{
		/*Команда SELECT*/
		try
		{
			$sql = 'SELECT 
						idauthor
					FROM subscribers
					WHERE idblog = :blogid and idauthor = :authorid';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':blogid', $idBlog);//отправка значения
			$s -> bindValue(':authorid', $selectedAuthor);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}

		catch (PDOException $e)
		{
			$error = 'Ошибка вывода информации о блоге';
			include MAIN_FILE . '/includes/error.inc.php';
		}

		$row = $s -> fetch();

		//$isSubscribed = $row['idauthor'];
		if (!empty($row))
		{
			$subskribe = '<form action="" metod = "post" id = "ajax_form_subs">
								<input type = "hidden" name = "idblog" value = "'.$idBlog.'">
								<input type = "hidden" name = "idauthor" value = "'.$selectedAuthor.'">
								<input type = "hidden" id = "val_subs" name = "val_subs" value = "delsubs">
								<button id ="btn_subs" title="Отписаться" class="btn_3 addit-btn" value = "Отписаться">Отписаться</button> 
							</form>';
		}

		else
		{
			$subskribe = '<form action="" metod = "post" id = "ajax_form_subs">
								<input type = "hidden" name = "idblog" value = "'.$idBlog.'">
								<input type = "hidden" name = "idauthor" value = "'.$selectedAuthor.'">
								<input type = "hidden" id = "val_subs" name = "val_subs" value = "addsubs">
								<button id ="btn_subs" title="Отписаться" class="btn_4 addit-btn" value = "Подписаться">Подписаться</button> 
							</form>';
		}
	}

	else
	{
		$subskribe = '';
	}

	if ($selectedAuthor == $authorId && !$isBlocked) 
	{
		/*Подсчёт отклонённых материалов */
		try
		{		
			$sql = "SELECT count(*) AS refusedpubs FROM publication WHERE premoderation = 'NO' AND refused = 'YES' AND draft = 'NO' AND idauthor = ".$selectedAuthor;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
			
			$row = $s -> fetch();
			
			$premodPubs = $row['refusedpubs'];//статьи в премодерации
		}

		catch (PDOException $e)
		{
			$error = 'Ошибка подсчёта материалов';
			include MAIN_FILE . '/includes/error.inc.php';
		}

		$setBlAvatar = "<form action = '../blog/setavatar/' method = 'post'>
							<input type = 'hidden' name = 'id' value = '".$idBlog."'>
							<button name = 'action' class='btn_1 addit-btn' value='Обновить аватар'>Обновить аватар</button>
						</form>";

		$setHeaderIMG = "<form action = '../blog/setavatar/' method = 'post'>
						<input type = 'hidden' name = 'id' value = '".$idBlog."'>
						<button name = 'action' class='btn_1 addit-btn' value='Обновить шапку' title='Изображение для шапки'><i class='fa fa-camera' aria-hidden='true'></i></button>
					</form>";

		$editBlog = "<form action = '../blog/addupdblog/' method = 'post'>
						<input type = 'hidden' name = 'id' value = '".$idBlog."'>
						<button name = 'action' class='btn_1 addit-btn' value='Настройка'>Настройка</button>
					  </form>";
		
		$addPublication = "<form action = '../admin/addupdblogpublication/' method = 'post'>
								<input type = 'hidden' name = 'id' value = '".$idBlog."'>
								<button name = 'action' class='btn_1 addit-btn' value='Добавить статью'>Добавить статью</button>
							</form>";
		$toDraft = "<a href='//".MAIN_URL."/blog/draft?blid=".$idBlog."'><button class='btn_1 addit-btn'>Черновик</button></a>";

		$allRefusedBl = $premodPubs != 0 ? '<a href="//'.MAIN_URL.'/admin/blogpubrefused/"><i class="fa fa-exclamation-circle" aria-hidden="true" title="Отклонённые материалы"></i></a>: '.$premodPubs : '';//Отклонённые материалы
	}

	else
	{
		$setBlAvatar = '';
		$setHeaderIMG = '';
		$editBlog = '';
		$addPublication = '';
		$toDraft = '';
		$allRefusedBl = '';//Отклонённые материалы
	}

	if (userRole('Администратор'))	
	{

		/*Индексировать блог */
		if ($indexing == 'noindex, nofollow')
		{
			$indexBlog = '<form action="./blogstatuses/" metod "post">
								<input type = "hidden" name = "idblog" value = "'.$idBlog.'">
								<button title="Индексировать блог" class="btn_1 addit-btn" name="addindex">Индексировать</button> 
							</form>';
		}

		else
		{
			$indexBlog = '<form action="./blogstatuses/" metod "post">
								<input type = "hidden" name = "idblog" value = "'.$idBlog.'">
								<button  title="Индексировать блог" class="btn_2 addit-btn" name="delindex">Убрать индекс</button> 
							</form>';
		}

		/*Статус премодерации блога*/
		if ($premodStatus == 'NO')
		{
			$premodBlog = '<form action="./blogstatuses/" metod = "post">
								<input type = "hidden" name = "idblog" value = "'.$idBlog.'">
								<button name = "addyes" title="Статус премодерации" class="btn_3 addit-btn" value = "Премодерация NO">Премодерация NO</button> 
							</form>';
		}

		else
		{
			$premodBlog = '<form action="./blogstatuses/" metod = "post">
								<input type = "hidden" name = "idblog" value = "'.$idBlog.'">							
								<button name = "addno" title="Статус премодерации" class="btn_4 addit-btn" value = "Премодерация YES">Премодерация YES</button> 
							</form>';
		}

		/*Кнопка удаления блога*/

		$delBlog = "<form action = './addupdblog/' method = 'post'>			
						<input type = 'hidden' name = 'idblog' value = '".$idBlog."'>
						<input type = 'submit' name = 'action' value = 'Удалить блог' class='btn_3 addit-btn'>
					</form>";
	}

	else
	{
		$indexBlog = '';
		$premodBlog = '';
		$delBlog = '';
	}

	/*Загрузка публикаций блога*/
	/*Постраничный вывод информации*/
		
	$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;// помещаем номер страницы из массива GET в переменую $page
	$onPage = 10;// количество статей на страницу
	$shift = ($page - 1) * $onPage;// (номер страницы - 1) * статей на страницу

	/*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';

	/*Вывод публикаций блога*/
	/*Команда SELECT*/

	try
	{
		$sql = 'SELECT 
					p.id AS pubid, 
					p.text, 
					a.id AS authorid, 
					p.title, 
					p.imghead, 
					p.imgalt, 
					p.date, 
					a.authorname, 
					c.id AS categoryid, 
					c.categoryname 
				FROM publication p 
				INNER JOIN author a ON p.idauthor = a.id 
				INNER JOIN category c ON p.idcategory = c.id 
				INNER JOIN blogs b ON p.idblog = b.id
				WHERE p.premoderation = "YES" and b.id = '.$idBlog.' ORDER BY p.date DESC LIMIT '.$shift.' ,'.$onPage;//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка вывода новостей';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$pubs[] =  array ('id' => $row['pubid'], 'idauthor' => $row['authorid'], 'text' => $row['text'], 'title' =>  $row['title'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
							'date' =>  $row['date'], 'authorname' =>  $row['authorname'], 
							'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}

	/*Определение количества статей*/
	try
	{
		$sql = "SELECT count(*) AS all_articles 
				FROM publication p
				INNER JOIN blogs b ON p.idblog = b.id
				WHERE premoderation = 'YES' and b.id = ".$idBlog;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка подсчёта новостей';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	$row = $s -> fetch();

	$countPosts = $row['all_articles'];			
	$pagesCount = ceil($countPosts / $onPage);

	$title = $blogTitle.' | imagoz.ru';//Данные тега <title>
	$headMain = 'Все статьи';
	$robots = $indexing;
	$descr = 'Блог пользователя '.$nameAuthor;
	$scriptJScode = '<script src="//'.MAIN_URL.'/pubcommonfiles/script.js"></script>';//добавить код JS
	//$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
	//$breadPart2 = '<a href="//'.MAIN_URL.'/blog/">Все статьи</a> ';//Для хлебных крошек

	include 'blog.html.php';
	exit();
}
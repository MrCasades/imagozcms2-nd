<?php

/*Показ комментариев*/

function showComments($type, $typeId, $idArticle/*id автора для профиля*/)//$type - newsblock, posts, promotion, account; $typeId - idnews, idpost, idpromotion, idaccount
{
    /*Загрузка функций в шаблон*/
    include_once MAIN_FILE . '/includes/func.inc.php';

    /*Подключение к базе данных */
    include MAIN_FILE . '/includes/db.inc.php';

    /*Загрузка функций для формы входа*/
    require_once MAIN_FILE . '/includes/access.inc.php';

    $selectedAuthor = isset($_SESSION['loggIn']) ? (int)(authorID($_SESSION['email'], $_SESSION['password'])) : -1;//id автора

    /*Постраничный вывод информации*/
		
	$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;// помещаем номер страницы из массива GET в переменую $page
	$onPage = 10;// количество статей на страницу
	$shift = ($page - 1) * $onPage;// (номер страницы - 1) * статей на страницу

    $GLOBALS['page'] = $page;

	try
	{
		$sql = 'SELECT 
			cm.id, 
			a.id AS idauthor, 
			cm.comment, 
			cml.idauthorlk,  
			cml.idcomment AS idcommentlk, 
			cml.islike, 
			cml.isdislike, 
			cm.imghead, 
			cm.imgalt, 
			cm.subcommentcount, 
			cm.commentdate, 
			a.authorname, 
			cm.likescount, 
			cm.dislikescount, 
			a.avatar, 
			cm.'.$typeId.' AS idarticle 
		FROM comments cm
		INNER JOIN author a 
		ON cm.idauthor = a.id 
		LEFT JOIN 
			(SELECT idauthor AS idauthorlk, idcomment, islike, isdislike
			FROM commentlikes WHERE idauthor = '.$selectedAuthor.') cml
		ON cm.id = cml.idcomment
		WHERE cm.'.$typeId.' = '.$idArticle.' 
		ORDER BY cm.id DESC LIMIT '.$shift.' ,'.$onPage;//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора комментариев';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$GLOBALS['comments'][] =  array ('id' => $row['id'], 'idauthor' => $row['idauthor'], 'text' => $row['comment'], 'date' => $row['commentdate'], 'authorname' => $row['authorname'],
								'subcommentcount' => $row['subcommentcount'], 'imghead' => $row['imghead'], 'imgalt' => $row['imgalt'], 'avatar' => $row['avatar'],
								'idarticle' => $row['idarticle'], 'likescount' => $row['likescount'], 'dislikescount' => $row['dislikescount'], 'islike' => $row['islike'], 
								'isdislike' => $row['isdislike'], 'idcommentlk' => $row['idcommentlk'], 'idauthorlk' => $row['idauthorlk']);
	}
	
	/*Форма добавления комментария / Получение имени автора для вывода меню редактирования или удаления комментария*/
	if (isset($_SESSION['loggIn']))
	{
		$GLOBALS['addComment'] = '<textarea class = "m-content fls-textarea">Напишите свой комментарий!</textarea>
						<form class="m-content comment-form hidden" id=addcomment method = "post" enctype="multipart/form-data">               					
							<input type = "hidden" name = "idauthart" value = "'.$selectedAuthor.'"> 
							<input type = "hidden" name = "idarticle" value = "'.$idArticle.'">
							<input type = "hidden" name = "articletype" value = "'.$type.'">
							<textarea class = "comment-textarea mark-textarea" rows="10" id = "comment" name = "comment" placeholder = "Напишите свой комментарий!"></textarea>	
							<button class = "btn_1" id="push_comment">Добавить коммнтарий</button>  
						</form>';	
	}
	
	else
	{
		$GLOBALS['addComment'] = '<div class = "m-content comment-auth">
						 <a href="../admin/registration/?log">Авторизируйтесь</a> в системе или 
						 <a href="../admin/registration/?reg">зарегестрируйтесь</a> для того, чтобы оставить запись!
						</div>';//Вывод сообщения в случае невхода в систему
	}
	
	/*Определение количества статей*/
	try
	{
		$sql = 'SELECT count(*) AS all_articles FROM comments WHERE '.$typeId.' = '.$idArticle;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка подсчёта статей';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	$row = $s -> fetch();
	
	$GLOBALS['countPosts'] = $row["all_articles"];
	$GLOBALS['pagesCount'] = ceil($GLOBALS['countPosts'] / $onPage);
	$GLOBALS['previousPage'] = $GLOBALS['page'] - 1;
	$GLOBALS['nextPage'] = $GLOBALS['page'] + 1;
	$GLOBALS['secondLast'] = $GLOBALS['pagesCount'] - 1;
	$GLOBALS['additData'] = '&id='.$idArticle.'#comm_';
}
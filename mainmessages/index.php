<?php 
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

$title = 'Все диалоги | imagoz.ru';
$headMain = 'Все диалоги';
$robots = 'noindex, follow';
$descr = 'В данном разделе отображаются сообщения пользователей';
	
if (loggedIn())
{
	/*Если loggedIn = TRUE, выводится имя пользователя иначе меню авторизации*/
}

else
{
	$title = 'Ошибка доступа';//Данные тега <title>
	$headMain = 'Ошибка доступа';
	$robots = 'noindex, nofollow';
	$descr = '';
	$error = 'Доступ запрещен';
	include '//'.MAIN_URL.'/admin/accessfail.html.php';
	exit();
}

/*Возвращение id автора*/

$selectedAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));//id автора


/*Вывод имён пользователей для диалогов*/
			
/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';

/*Вывод имён пользователей, с которыми ведётся диалог*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT 
				mainmessageid, 
				unr,			
				auth.authorname AS authorname, 
				auth.id AS idauth, 
				auth.avatar AS ava,
				count(*) AS cnt
			FROM author auth 
			INNER JOIN 
				(SELECT 
					max(id) AS mainmessageid,					
					idfrom, 
					idto 
				FROM mainmessages 
				GROUP BY idfrom, idto) mmess 
			ON (mmess.idfrom = auth.id AND mmess.idfrom <> '.$selectedAuthor.') OR (mmess.idto = auth.id AND mmess.idto <> '.$selectedAuthor.') 
			LEFT JOIN 
				(SELECT 
					count(CASE WHEN unread = "YES" THEN 1 END) AS unr, 
					idfrom AS idfromunr
				FROM mainmessages WHERE idto = '.$selectedAuthor.' 
				GROUP BY idfromunr) mmess2 ON mmess2.idfromunr = auth.id
			WHERE idfrom = '.$selectedAuthor.' OR idto = '.$selectedAuthor.'
			GROUP BY authorname
			HAVING cnt > 0  
			ORDER BY mainmessageid DESC';
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка выбора сообщений';
	include MAIN_FILE . '/includes/error.inc.php';
}


/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$dialogs[] =  array ('idmess' => $row['mainmessageid'], 'authorname' => $row['authorname'], 'idauth' => $row['idauth'], 'ava' => $row['ava'], 'unr' => $row['unr']);
}
			
include 'mainmessages.html.php';
exit();
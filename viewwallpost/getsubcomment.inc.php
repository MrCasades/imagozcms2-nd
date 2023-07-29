<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка содержимого записи*/
if (isset ($_GET['id']))
{
    /*Подключение к базе данных*/
    include MAIN_FILE . '/includes/db.inc.php';

	$idComment = $_GET['id'];

	$selectedAuthor = $_GET['selauthid'];

	$typeArt = $_GET['typeart'];
	
	/*Вывод ответов*/
	
	try
	{
		$sql = 'SELECT 
			scm.id, 
			a.id AS subidauthor, 
			scm.subcomment, 
			scm.subcommentdate, 
			scm.likescount,
			scm.dislikescount, 
			a.authorname AS subauthorname,
			a.avatar AS subavatar,
			scml.islike, 
			scml.isdislike, 
			case 
				when cm.idnews is not null or cm.idnews <> 0 then cm.idnews 
				when cm.idpost is not null or cm.idpost <> 0 then cm.idpost
				when cm.idpromotion is not null or cm.idpromotion <> 0 then cm.idpromotion
				when cm.idaccount  is not null or cm.idaccount  <> 0 then cm.idaccount 
				when cm.idvideo is not null or cm.idvideo   <> 0 then cm.idvideo 
				when cm.idpublication is not null or cm.idpublication   <> 0 then cm.idpublication
			end as idart  
		FROM subcomments scm
		INNER JOIN author a
		ON scm.idauthor = a.id 
		INNER JOIN comments cm
		ON scm.idcomment = cm.id
		LEFT JOIN 
			(SELECT idauthor AS idauthorlk, idsubcomment, islike, isdislike
			FROM subcommentlikes WHERE idauthor = '.$selectedAuthor.') scml
		ON scm.id = scml.idsubcomment
		WHERE scm.idcomment = '.$idComment.' ORDER BY scm.subcommentdate DESC LIMIT 5';//Внизу самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка получения subcomments';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$subcomments[] =  array ('id' => $row['id'], 'text' => $row['subcomment'], 'date' => $row['subcommentdate'], 'subauthorname' => $row['subauthorname'],
								'subavatar' => $row['subavatar'], 'subidauthor' => $row['subidauthor'], 'likescount' => $row['likescount'], 'dislikescount' => $row['dislikescount'], 
								'islike' => $row['islike'],	'isdislike' => $row['isdislike'], 'idart' => $row['idart']);
	}
	
	include 'subcomment.html.php';
	exit();
}
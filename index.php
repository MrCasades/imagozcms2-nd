<?php

/*Загрузка главного пути*/
include_once __DIR__ . '/includes/path.inc.php';

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка общих переменных*/
include_once MAIN_FILE . '/includes/commonvar.inc.php';

/*Загрузка настроек раздела*/
$blockFolder = 'mainpage';
include_once MAIN_FILE . '/includes/blocksettings/blockset.inc.php';

/*Определение нахождения пользователя в системе*/
loggedIn();

$selectedAuthor = isset($_SESSION['loggIn']) ? (int)(authorID($_SESSION['email'], $_SESSION['password'])) : -1;//id автора

/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';

/*Последняя рекомендованная статья*/
/*Команда SELECT*/

if ($data['recommendations'] == "on")
{
	try
	{
		$sql = 'SELECT p.id AS postid, a.id AS idauthor, post, posttitle, imghead, imgalt, postdate, authorname, c.id AS categoryid, categoryname FROM posts p 
				INNER JOIN author a ON idauthor = a.id 
				INNER JOIN category c ON idcategory = c.id 
				WHERE premoderation = "YES" AND zenpost = "NO" AND recommendationdate ORDER BY recommendationdate DESC LIMIT 4';//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка вывода статей на главной странице';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$lastRecommPosts[] =  array ('id' => $row['postid'], 'idauthor' => $row['idauthor'], 'text' => $row['post'], 'posttitle' =>  $row['posttitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
							'postdate' =>  $row['postdate'], 'authorname' =>  $row['authorname'], 
							'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}
}

/*Вывод последней новости*/
/*Команда SELECT*/

// try
// {
// 	$sql = 'SELECT n.id, n.news, n.newstitle, n.newsdate, n.imghead, c.categoryname
// 		FROM newsblock n 
// 		INNER JOIN category c ON idcategory = c.id  
// 		WHERE premoderation = "YES" ORDER BY newsdate DESC LIMIT 1';//Вверху самое последнее значение
// 	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
// 	$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
// }

// catch (PDOException $e)
// {
// 	$error = 'Ошибка вывода новостей на главной странице';
// 	include MAIN_FILE . '/includes/error.inc.php';
// }

// $row = $s -> fetch();

// $lastNewsId = $row['id'];
// $lastNewsTxt = $row['news'];
// $lastNewsTitle = $row['newstitle'];
// $lastNewsDate = $row['newsdate'];
// $lastNewsImghead = $row['imghead'];
// $lastNewsCname = $row['categoryname'];

/*Вывод новостей*/
/*Команда SELECT*/

if ($data['newsblock'] == "on")
{
	try
	{
		$sql = 'SELECT n.id, n.news, n.newstitle, n.newsdate, n.imghead, c.categoryname
				FROM newsblock n 
				INNER JOIN category c ON idcategory = c.id  
				WHERE premoderation = "YES" ORDER BY newsdate DESC LIMIT 8';//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка вывода новостей на главной странице';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$newsIn[] =  array ('id' => $row['id'], 'textnews' => $row['news'], 'newstitle' =>  $row['newstitle'], 'newsdate' =>  $row['newsdate'], 'categoryname' =>  $row['categoryname'],
							'imghead' =>  $row['imghead']);
	}
}

/*Вывод видео*/
/*Команда SELECT*/
if ($data['video'] == "on")
{
	try
	{
		$sql = 'SELECT v.id, v.videotitle, v.videodate, v.imghead, v.videofile, v.viewcount, c.categoryname, a.id AS idauthor, a.authorname
				FROM video v 
				INNER JOIN category c ON v.idcategory = c.id  
				INNER JOIN author a ON v.idauthor = a.id 
				WHERE premoderation = "YES" ORDER BY videodate DESC LIMIT 6';//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода видео на главной странице';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$videos[] =  array ('id' => $row['id'], 'videotitle' =>  $row['videotitle'], 'videodate' =>  $row['videodate'], 'viewcount' =>  $row['viewcount'], 'categoryname' =>  $row['categoryname'],
							'imghead' =>  $row['imghead'], 'videofile' =>  $row['videofile'], 'idauthor' =>  $row['idauthor'], 'authorname' =>  $row['authorname']);
	}
}

/*Вывод публикаций блогов*/
/*Команда SELECT*/
if ($data['blogpubs'] == "on")
{
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
					c.categoryname,
					b.id as blogid,
					b.title as blogtitle 
				FROM publication p 
				INNER JOIN author a ON p.idauthor = a.id 
				INNER JOIN category c ON p.idcategory = c.id 
				INNER JOIN blogs b ON p.idblog = b.id
				WHERE p.premoderation = "YES" ORDER BY p.date DESC LIMIT 5';//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка вывода публикаций';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$pubs[] =  array ('id' => $row['pubid'], 'idauthor' => $row['authorid'], 'text' => $row['text'], 'title' =>  $row['title'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
								'date' =>  $row['date'], 'authorname' =>  $row['authorname'], 
								'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid'], 'blogtitle' => $row['blogtitle']);
	}

}

/*Вывод статей*/
/*Команда SELECT*/
if ($data['posts'] == "on")
{
	try
	{
		$sql = 'SELECT p.id AS postid, a.id AS idauthor, post, posttitle, imghead, imgalt, postdate, authorname, c.id AS categoryid, categoryname FROM posts p
				INNER JOIN author a ON idauthor = a.id 
				INNER JOIN category c ON idcategory = c.id 
				WHERE premoderation = "YES" ORDER BY postdate DESC LIMIT 6';//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода статей';
		include MAIN_FILE . '/includes/error.inc.php';
	}
	
	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$posts[] =  array ('id' => $row['postid'], 'idauthor' => $row['idauthor'], 'text' => $row['post'], 'posttitle' =>  $row['posttitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
							'postdate' =>  $row['postdate'], 'authorname' =>  $row['authorname'], 
							'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}
}

/*Вывод промоушена*/
/*Команда SELECT*/
if ($data['promotion'] == "on")
{
	try
	{
		$sql = 'SELECT pr.id AS promotionid, a.id AS idauthor, promotion, promotiontitle, imghead, imgalt, pr.www, promotiondate, authorname, c.id AS categoryid, categoryname FROM promotion pr
				INNER JOIN author a ON idauthor = a.id 
				INNER JOIN category c ON idcategory = c.id 
				WHERE premoderation = "YES" ORDER BY promotiondate DESC LIMIT 4';//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода промоушена';
		include MAIN_FILE . '/includes/error.inc.php';
	}



	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$promotions[] =  array ('id' => $row['promotionid'], 'idauthor' => $row['idauthor'], 'text' => $row['promotion'], 'promotiontitle' =>  $row['promotiontitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
							'promotiondate' =>  $row['promotiondate'], 'authorname' =>  $row['authorname'], 'www' =>  $row['www'],
							'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}
}

/*Вывод списка случайных тегов для новостей и статей*/

/*Команда SELECT для облака тегов*/
try
{
	$sql = 'SELECT DISTINCT metaname, m.id FROM meta m 
			INNER JOIN metapost ON idmeta = m.id 	
			ORDER BY rand() LIMIT 12';
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка выбора тегов новостей';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$metas_1[] =  array ('id' => $row['id'], 'meta' => $row['metaname']);
}

// /*Команда SELECT для тегов новостей*/
// try
// {
// 	$sql = 'SELECT DISTINCT metaname, meta.id FROM meta 
// 			INNER JOIN metapost ON idmeta = meta.id 
// 			INNER JOIN posts ON idpost = posts.id	
// 			ORDER BY rand() LIMIT 5';
// 	$result = $pdo->query($sql);
// }

// catch (PDOException $e)
// {
// 	$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
// 	$headMain = 'Ошибка данных!';
// 	$robots = 'noindex, nofollow';
// 	$descr = '';
// 	$error = 'Ошибка выбора тегов статей ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
// 	include 'error.html.php';
// 	exit();
// }

// /*Вывод результата в шаблон*/
// foreach ($result as $row)
// {
// 	$metas_2[] =  array ('id' => $row['id'], 'meta' => $row['metaname']);
// }

// /*Команда SELECT для тегов промоушена*/
// try
// {
// 	$sql = 'SELECT DISTINCT metaname, meta.id FROM meta 
// 			INNER JOIN metapost ON idmeta = meta.id 
// 			INNER JOIN promotion ON idpromotion = promotion.id	
// 			ORDER BY rand() LIMIT 5';
// 	$result = $pdo->query($sql);
// }

// catch (PDOException $e)
// {
// 	$title = 'ImagozCMS | Ошибка данных!';//Данные тега <title>
// 	$headMain = 'Ошибка данных!';
// 	$robots = 'noindex, nofollow';
// 	$descr = '';
// 	$error = 'Ошибка выбора тегов статей ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
// 	include 'error.html.php';
// 	exit();
// }

// /*Вывод результата в шаблон*/
// foreach ($result as $row)
// {
// 	$metas_3[] =  array ('id' => $row['id'], 'meta' => $row['metaname']);
// }

/*Вывод топ-5*/

/*Вывод ТОП-5 новостей*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT id, newstitle, viewcount, averagenumber, imghead, newsdate FROM newsblock WHERE premoderation = "YES" AND votecount > 1  ORDER BY averagenumber DESC, votecount DESC LIMIT 3';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка выбора новостей для рейтинга';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$newsInTOP[] =  array ('id' => $row['id'], 'newstitle' => $row['newstitle'], 'viewcount' => $row['viewcount'], 'averagenumber' => $row['averagenumber'],
							'imghead' => $row['imghead'], 'newsdate' => $row['newsdate']);
}

/*Вывод ТОП-5 статей*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT id, posttitle, viewcount, averagenumber, imghead, postdate FROM posts WHERE premoderation = "YES" AND zenpost = "NO" AND votecount > 1 ORDER BY averagenumber DESC, votecount DESC LIMIT 3';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка выбора статей для рейтинга';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$postsTOP[] =  array ('id' => $row['id'], 'posttitle' => $row['posttitle'], 'viewcount' => $row['viewcount'], 'averagenumber' => $row['averagenumber'],
						'imghead' => $row['imghead'], 'postdate' => $row['postdate']);
}

/*Вывод ТОП-5 промоушен*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT id, promotiontitle, viewcount, averagenumber, imghead, promotiondate FROM promotion WHERE premoderation = "YES" AND votecount > 1 ORDER BY averagenumber DESC, votecount DESC LIMIT 3';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка выбора промоушена для рейтинга';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$promotionsTOP[] =  array ('id' => $row['id'], 'promotiontitle' => $row['promotiontitle'], 'viewcount' => $row['viewcount'], 'averagenumber' => $row['averagenumber'],
								'imghead' => $row['imghead'], 'promotiondate' => $row['promotiondate']);
}

/*Вывод ТОП-7 авторов*/
/*Команда SELECT*/
try
{
	$sql = 'SELECT id, authorname, avatar, countposts, rating FROM author WHERE countposts > 2 AND id <> 1 ORDER BY countposts DESC LIMIT 7';//Вверху самое последнее значение
	$result = $pdo->query($sql);
}

catch (PDOException $e)
{
	$error = 'Ошибка выбора авторов для рейтинга';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($result as $row)
{
	$authorsTOP[] =  array ('id' => $row['id'], 'authorname' => $row['authorname'], 'avatar' => $row['avatar'],
						    'countposts' => $row['countposts'], 'rating' => $row['rating']);
}

/*Вывод конкурсной статистики*/
/*Команда SELECT проверка запуска конкурса*/
try
{
	$sql = 'SELECT contestpanel FROM contest WHERE id = 1';//Вверху самое последнее значение
	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
}

catch (PDOException $e)
{
	$error = 'Ошибка вывода конкурса';
	include MAIN_FILE . '/includes/error.inc.php';
}

$row = $s -> fetch();
		
$contestPanel = $row['contestpanel'];//проверка на включение конкурса

if ($contestPanel == 'YES')//Если конкурс включен, выводится блок в панели
{
	$hederContest = '<div class = "titles_main_padge"><h4 align = "center">Результаты конкурса</h4></div>';
	
	try
	{
		$sql = 'SELECT id, authorname, avatar, contestscore FROM author WHERE contestscore > 0 ORDER BY contestscore DESC LIMIT 7';//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка вывода данных конкурса';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$contestsTOP[] =  array ('id' => $row['id'], 'authorname' => $row['authorname'], 'avatar' => $row['avatar'], 'contestscore' => $row['contestscore']);
	}

}

else
{
	$hederContest = '';
}


/*Вывод изображения дня*/
/*Команда SELECT*/
if ($data['refday'] == "on")
{
	try
	{
		$sql = 'SELECT p.id AS postid, post, posttitle, imghead, imgalt, postdate, authorname, c.id AS categoryid, categoryname 
				FROM category c
				INNER JOIN posts p ON idcategory = c.id
				INNER JOIN author a ON idauthor = a.id			
				WHERE categoryname = "Изображение дня" AND premoderation = "YES" AND zenpost = "NO" ORDER BY postdate DESC LIMIT 10';//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка вывода изображения дня';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$postsIMG[] =  array ('id' => $row['postid'], 'text' => $row['post'], 'posttitle' =>  $row['posttitle'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt'],
							'postdate' =>  $row['postdate'], 'authorname' =>  $row['authorname'], 
							'categoryname' =>  $row['categoryname'], 'categoryid' => $row['categoryid']);
	}
}

/*Вывод комментариев для главной страницы*/

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
		cm.idpost,
		cm.idnews,
		cm.idpromotion,
		cm.idpublication,
		pos.posttitle,
		n.newstitle,
		pr.promotiontitle,
		pb.title
	FROM comments cm
	INNER JOIN author a 
	ON cm.idauthor = a.id 
	LEFT JOIN posts pos
	ON pos.id = idpost
	LEFT JOIN newsblock n
	ON n.id = idnews
	LEFT JOIN promotion pr
	ON pr.id = idpromotion
	LEFT JOIN posts p
	ON p.id = idpost
	LEFT JOIN publication pb
	ON pb.id = idpublication
	LEFT JOIN 
		(SELECT idauthor AS idauthorlk, idcomment, islike, isdislike
		FROM commentlikes WHERE idauthor = '.$selectedAuthor.') cml
	ON cm.id = cml.idcomment
	WHERE cm.idpost IS NOT NULL OR cm.idnews IS NOT NULL OR cm.idpromotion IS NOT NULL OR cm.idpublication IS NOT NULL
	ORDER BY cm.id DESC LIMIT 7';//Вверху самое последнее значение
	$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка вывода комменатриев на главной странице';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$comments[] =  array ('id' => $row['id'], 'idauthor' => $row['idauthor'], 'text' => $row['comment'], 'date' => $row['commentdate'], 'authorname' => $row['authorname'],
								'subcommentcount' => $row['subcommentcount'], 'imghead' => $row['imghead'], 'imgalt' => $row['imgalt'], 'avatar' => $row['avatar'],
								'likescount' => $row['likescount'], 'dislikescount' => $row['dislikescount'], 'islike' => $row['islike'], 
								'isdislike' => $row['isdislike'], 'idcommentlk' => $row['idcommentlk'], 'idauthorlk' => $row['idauthorlk'],
								'idpost' => $row['idpost'], 'idnews' => $row['idnews'], 'idpromotion' => $row['idpromotion'], 'idpublication' => $row['idpublication'],
								'posttitle' => $row['posttitle'], 'newstitle' => $row['newstitle'], 'promotiontitle' => $row['promotiontitle'], 'title' => $row['title'],
							);
	}

include 'mainpage.html.php';
exit();



	
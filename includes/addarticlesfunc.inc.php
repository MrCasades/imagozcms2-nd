<?php

/*Заполнение форм при добавлении статьи*/
function addListsInForms()
{
    /*Подключение к базе данных*/
	include MAIN_FILE . '/includes/db.inc.php';
	
	/*Список рубрик*/
	try
	{
		$result = $pdo -> query ('SELECT id, categoryname FROM category');
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода category Error: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.inc.php';
	}
	
	foreach ($result as $row)
	{
		$GLOBALS['categorys_1'][] = array('idcategory' => $row['id'], 'categoryname' => $row['categoryname']);
	}
	
	/*Список тематик*/
	try
	{
		$result = $pdo -> query ('SELECT id, metaname FROM meta ORDER BY metaname');
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода meta Error: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.inc.php';
	}
	
	foreach ($result as $row)
	{
		$GLOBALS['metas_1'][] = array('idmeta' => $row['id'], 'metaname' => $row['metaname'], 'selected' => FALSE);
	}
}

/*Функции возвращают длину текста без пробела*/
function lengthText($text)
{
	$textNonSpace=str_replace(array(" ", "<p>", "</p>", "<strong>", "</strong>", "target=", "/picsforposts", "pc-",
									"<hr>", "&nbsp", "<ul>", "</ul>", "<em>", "</em>", "_blank", "www.imagoz.ru",
									"<li>", "</li>", "<a href=", "</a>", "<h2>", "</h2>", ".gif", ".jpg", ".png",
									"<h3>", "</h3>", "<summary>", "</summary>", '<details>', '</details>',
									"<br>", "<img", "src=", "alt=", "<iframe", "</iframe>", "width=", "height=",
									 "title=", "YouTube video player", "frameborder=", "allow=", "clipboard-write;",
									"style=", "autoplay;", "clipboard-write;", "encrypted-media;", "gyroscope;",
									"picture-in-picture", "allowfullscreen", "https://www.youtube.com/embed", "https://store.steampowered.com/widget/",
									"font-family:", "font-weight:", "Arial", "Helvetica", "font-size:", "sans-serif",
									"<span", "</span>", "white-space:pre", "margin:", "text-align:", "justify;",
									"background-color:", "rel=", "nofollow", "text-decoration-line:", "text-decoration-thickness:",
									"letter-spacing:","color:", "rgb", "font-variant-caps:", "font-variant-ligatures:",
									"text-decoration-style:", "bold;", "box-sizing:", "border-box;", "white-space:", "initial;"), '', $text); //В переменной заменяем пробелы на пустоту и возвращаем в переменную $textNonSpace
    return mb_strlen($textNonSpace, 'utf-8');
}

function lengthNonSpaceText($text)
{
	echo lengthText($text);
}

/*Подсчёт стоимости текста*/
function priceText($text, $price, $bonus)
{
	$text = lengthText($text);
    return ($text * $price)/1000 + (($text * $price)/1000) * $bonus;
}

/*Определить цену статьи*/
function setArticlePrice($text, $type, $id, $queryType) //Type = pricenews or pricepost; id = idauthor or articleid	queryType = add or upd														
{
	/*Тип статьи для БД*/
	if($type === 'pricenews')
	{
		$tableType = 'newsblock';
	}

	elseif ($type === 'pricepost')
	{
		$tableType = 'posts';
	}

	/*Тип запроса для insrt или update*/
	if ($queryType === 'add')
	{
		$select = 'SELECT r.'.$type.' as price,
						 a.bonus,
						 ac.categorybonus 
						 FROM author a
					INNER JOIN rang r				
					ON a.idrang = r.id
					LEFT JOIN authorcategory ac 
					ON ac.id = a.idauthcategory
					WHERE a.id = :id';
	}

	elseif ($queryType === 'upd')
	{
		$select = 'SELECT '.$type.' as price, authorbonus as bonus FROM '.$tableType.' WHERE id = :id';
	}

	/*Подключение к базе данных*/
	include 'db.inc.php';
	
	/*Выбор цены за 1000 знаков*/
	try
	{
		$sql = $select;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':id', $id);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL		
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка выбора цены новости meta Error: ' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.inc.php';
	}
	
	$row = $s -> fetch();

	$catBonus = !empty($row['categorybonus']) ? $row['categorybonus'] : 0;

	$GLOBALS['priceTxt'] = $row['price'] + $catBonus;//цена за 1000 знаков
	$GLOBALS['bonus'] = $row['bonus'];//выбор бонуса(множителя)
	
	$GLOBALS['lengthText'] = lengthText($text);//определение длины текста
	$GLOBALS['fullPrice'] = priceText($text, $row['price'] + $catBonus, $row['bonus'], $catBonus);//полная стоимость статьи


	$GLOBALS['bonusText'] = $row['bonus'] == 0 ? '.' : ', с учётом бонуса Х'.$row['bonus'];//Если есть бонус, то выводится информация о его наличие
}

/*Конвертировать материал в статью или новость*/
function convertToPostOrNews($inData, $idData)
{
	/*Выбор входных данных статьи*/
	/*Подключение к базе данных*/
	include 'db.inc.php';
	
	try
	{
		$sql = 'SELECT * FROM '.$inData.' WHERE premoderation = "NO" AND refused = "NO" AND id = '.(int)$idData;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора характеристик материала' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.inc.php';
	}
	
	$row = $s -> fetch();
	
	if ($inData == 'newsblock')
	{
		/*наименования столбцов в БД*/
		$outData = 'posts';//название таблицы
		$dataBD = 'post';
		$datatitleBD = 'posttitle';
		$datadateBD = 'postdate';
		$datapriceBD = 'pricepost';
		
		/*Данные для конвертации*/
		$data = $row['news'];
		$datatitle = $row['newstitle'];
		$description = $row['description'];
		$videoyoutube = $row['videoyoutube'];
		$datadate = $row['newsdate'];
		$imghead = $row['imghead'];
		$imgalt = $row['imgalt'];
		$idauthor = $row['idauthor'];
		$idcategory = $row['idcategory'];
		$idtask = $row['idtask'];
		$lengthtext = $row['lengthtext'];
		$authorbonus = $row['authorbonus'];
		
		/*Персчёт цены материала*/
		try
		{
			$sql = 'SELECT pricepost FROM author INNER JOIN rang ON idrang = rang.id
									WHERE author.id = '.$idauthor;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}

		catch (PDOException $e)
		{
			$error = 'Ошибка выбора цены за 1000 знаков при конвертации' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.inc.php';
		}
		
		$row = $s -> fetch();
		
		$pricepost = $row['pricepost'];
	}
	
	elseif ($inData == 'posts')
	{
		/*наименования столбцов в БД*/
		$outData = 'newsblock';//название таблицы
		$dataBD = 'news';
		$datatitleBD = 'newstitle';
		$datadateBD = 'newsdate';
		$datapriceBD = 'pricenews';
		
		/*Данные для конвертации*/
		$data = $row['post'];
		$datatitle = $row['posttitle'];
		$description = $row['description'];
		$videoyoutube = $row['videoyoutube'];
		$datadate = $row['postdate'];
		$imghead = $row['imghead'];
		$imgalt = $row['imgalt'];
		$idauthor = $row['idauthor'];
		$idcategory = $row['idcategory'];
		$idtask = $row['idtask'];
		$lengthtext = $row['lengthtext'];
		$authorbonus = $row['authorbonus'];
		
		/*Выбор цены за 1000 знаков*/
		try
		{
			$sql = 'SELECT pricenews FROM author INNER JOIN rang ON idrang = rang.id
									WHERE author.id = '.$idauthor;
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}

		catch (PDOException $e)
		{
			$error = 'Ошибка выбора цены за 1000 знаков при конвертации' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.inc.php';
		}
		
		$row = $s -> fetch();
		
		$pricepost = $row['pricenews'];
	}	
		
	/*Пересчёт стоимости материала*/
	$pricetext = priceText($data, $pricepost, $authorbonus);
	
	/*Конвертация в другой блок*/
	try
	{
		$sql = 'INSERT INTO '.$outData.' SET 
			'.$dataBD.' = \''.$data.'\',
			'.$datatitleBD.' = \''.$datatitle.'\',
			description = \''.$description.'\',
			imgalt = \''.$imgalt.'\',	
			videoyoutube = \''.$videoyoutube.'\',
			'.$datadateBD.' = SYSDATE(),
			imghead = \''.$imghead.'\', 
			idauthor = '.$idauthor.',
			idcategory = '.$idcategory.',
			idtask = '.$idtask.' ,
			lengthtext = '.$lengthtext.', 
			'.$datapriceBD.' = '.$pricepost.', 
			authorbonus = '.$authorbonus.',
			pricetext = '.$pricetext.',
			draft = "NO"';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка добавления информации при конвертации' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.inc.php';
	}
}

/*Получение атрибутов блога */
function getBlogAtributs($idBlog)
{
	/*Подключение к базе данных*/
	include 'db.inc.php';

	try
	{
		$sql = 'SELECT 
					b.id as blogid
					,b.title
					,b.description
					,b.imghead
					,b.avatar
					,b.indexing
					,b.idauthor
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

	$GLOBALS['imgHead'] = $row['imghead'];//цена за 1000 знаков
	$GLOBALS['blogTitle'] = $row['title'];
}
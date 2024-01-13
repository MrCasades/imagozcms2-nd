<?php

/*Упрощённая замена стандарноой htmlspecialchars*/

function html($text)
{
	$turned = array( '&lt;pre&gt;', '&lt;/pre&gt;', '&lt;b&gt;', '&lt;/b&gt;', '&lt;em&gt;', '&lt;/em&gt;', '&lt;u&gt;', '&lt;/u&gt;', '&lt;ul&gt;', '&lt;/ul&gt;', '&lt;li&gt;', '&lt;/li&gt;', '&lt;ol&gt;', '&lt;/ol&gt;', '&lt;strong&gt;', '&lt;/strong&gt;' ); 
	$turn_back = array( '<pre>', '</pre>', '<b>', '</b>', '<em>', '</em>', '<u>', '</u>', '<ul>', '</ul>', '<li>', '</li>', '<ol>', '</ol>', '<strong>', '</strong>'); 
	$text = str_replace( $turned, $turn_back, $text);
	return $text;
}

function htmlecho($text)
{
	echo html($text);
}

//Быстрая сортировка
/*function quickSort(array $arr) {
    $count= count($arr);
    if ($count <= 1) {
        return $arr;
    }
 
    $first_val = $arr[0];
    $left_arr = array();
    $right_arr = array();
 
    for ($i = 1; $i < $count; $i++) {
        if ($arr[$i] <= $first_val) {
            $left_arr[] = $arr[$i];
        } else {
            $right_arr[] = $arr[$i];
        }
    }
 
    $left_arr = quickSort($left_arr);
    $right_arr = quickSort($right_arr);
 
    return array_merge($left_arr, array($first_val), $right_arr);
}
*/

/*Регулярные выражения*/

function markdown2html ($text)
{
	$text = html ($text);// Преобр. форматирование на уровне обычн текста в HTML
	
	/*Загрузка библиотеки Markdown*/
	include_once 'markdown.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/MarkdownInterface.inc.php';

	/*Полужирный текст*/
	//$text = preg_replace ('/__(.+?)__/s', '<strong>$1</strong>', $text);
	//$text = preg_replace ('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $text);
	
	/*Курсив*/
	//$text = preg_replace ('/_([^_]+)_/', '<em>$1</em>', $text);
	//$text = preg_replace ('/\*([^_]+)\*/', '<em>$1</em>', $text);
	
	/*Преобразование стиля Windows(\r\n) в Unix (\n)*/
	//$text = preg_replace ('/\r\n/', "\n", $text);
	
	/*Преобразование стиля Mac(\r) в Unix (\n)*/
	//$text = preg_replace ('/\r/', "\n", $text);
	
	/*Абзацы*/
	//$text = '<p>' . str_replace ('/\n\n/', '</p><p>', $text) . '</p>';
	
	/*Разрыв строки*/
	//$text = str_replace ('/\n/', '<br>', $text);
	
	/*Гиперссылка формат [текст ссылки](адрес)*/
	//$text = preg_replace ('/\[([^\]]+)]\(([-a-z0-9._~:\/?#@!$&\'()*+,;=%]+)\)/i', '<a href="$2">$1</a>', $text);
	
	return Markdown($text);
}

function uploadFile ($fileNameScript, $filePathScript, $typeInput)
{
	/*Загрузка файла (тест)*/
	
	/*Извлечение расширения файла*/
	
	if (preg_match ('/^image\/p?jpeg$/i', $_FILES[$typeInput]['type']))
	{
		$ext = '.jpg';
	}
		
	elseif (preg_match ('/^image\/p?gif$/i', $_FILES[$typeInput]['type']))
	{
		$ext = '.gif';
	}
		
	elseif (preg_match ('/^image\/p?png$/i', $_FILES[$typeInput]['type']))
	{
		$ext = '.png';
	}
		
	else	
	{
		$ext = '.unk';
	}
			
	$fileName = $fileNameScript . $ext;//присвоение имени файла
	$filePath = MAIN_FILE . $filePathScript . $fileName;//путь загрузки
			
	if (!is_uploaded_file($_FILES[$typeInput]['tmp_name']) || !copy($_FILES[$typeInput]['tmp_name'], $filePath))
	{
		$fileName = '';
	}

	return $fileName;
}

/*Загрузка/обновление изображения шапки*/
function uploadImgHeadFull($fileNameScript, $filePathScript, $typeAction = 'add', $typeArticle = '', $idArticle = '', $typeInput = 'upload') //Если тип upd, то функция должна принимать id статьи и typeArticle; В $typeInput - атрибут name input file (по умолчанию - upload)
{
	if ($typeAction == 'upd')
	{
		if ($typeArticle == 'author')
			$DBcol = 'avatar';
		elseif ($typeArticle == 'blogsAVA')
		{
			$DBcol = 'avatar';
			$typeArticle = 'blogs';
		}
		else
			$DBcol = 'imghead';
		
		//	$DBcol = ($typeArticle == 'author') ? 'avatar' : 'imghead';//Название колонки в зависимости от типа публикации

		/*Подключение к базе данных*/
		include 'db.inc.php';

		/*Команда SELECT*/
		try
		{
			$sql = 'SELECT '.$DBcol.' FROM '.$typeArticle.' WHERE id = :idart';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idart', $idArticle);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}

		catch (PDOException $e)
		{
			$error = 'Ошибка выбора изображения';
			include 'error.inc.php';
		}

		$row = $s -> fetch();

		if (!is_uploaded_file($_FILES[$typeInput]['tmp_name']))//если файл не загружен, оставить старое имя
		{
			$fileName = $row[$DBcol];
		}
		
		else
		{
			/*Удаление старого файла изображения*/
			$fileName = $row[$DBcol];
			$delFile = MAIN_FILE . $filePathScript.$fileName;//путь к файлу для удаления
			unlink($delFile);//удаление файла
			
			$fileName = uploadFile($fileNameScript, $filePathScript, $typeInput);
		}
	}

	else
	{
		$fileName = uploadFile($fileNameScript, $filePathScript, $typeInput);
	}
	
	return $fileName;
}

/*Обновление лого сайта*/
function uploadSiteLogo($fileNameScript, $filePathScript, $typeInput = 'upload') //$typeLogo = main or adpt
{
	$fileName = uploadFile($fileNameScript, $filePathScript, $typeInput);

	return $fileName;
}

/*Добавление класса галереи к изображениям публикации*/
function imgForGallery($text)
{
	$element_1 = 'img '; //искомый элемент
	$replace_1 = 'img class = "pic-for-gallery"'; //на что меняем
		
	
	$findSt = strpos ($text, $element_1);
	
	if ($findSt != '')
	{
		$text = str_replace($element_1, $replace_1, $text);
	}
		
	else
	{
		$text = $text;
	}
	
	//$video = $findSt != '' ? str_replace($element, $replace, $video) : $video;
	
	return $text;
}

/*Добавление тега Figure при необходимости*/
function isertTagFigure($text)
{
	$element_1 = '/<img[^>]+>/i'; //искомый элемент
	$element_2 = '/<iframe[^>]*src\s*=\s*"?https?:\/\/[^\s"\/]*youtube.com(?:\/[^\s"]*)?"?[^>]*>.*?<\/iframe>/i';//искомый элемент
	//$element_3 = '<details>(.+?)</details>';//искомый элемент
	
	$replace_1 = '<figure>${0}</figure>'; //на что меняем
	//$replace_2 = '<div data-pulse-component="gallery" data-pulse-component-name="pulse_gallery">${0}</div>'; //на что меняем
			
	$text = preg_replace($element_1, $replace_1, $text);
	$text = preg_replace($element_2, $replace_1, $text);
	//$text = preg_replace($element_3, $replace_2, $text);
	//$text = preg_replace($element_3, $replace_1, $text);
	
	return $text;
}

/*Добавление галереи для psspulse и замена виджета Steam на ссылку TEST*/
function delDetails($text)
{
	$element_1 = '|<details>(.+)</details>|isU';//искомый элемент
	$element_2 = '|<summary>(.+)</summary>|isU';//искомый элемент

	$replace_1 = '<p>${1}</p>'; //на что меняем
	$replace_2 = '<h4>${1}</h4>'; //на что меняем

	$text = preg_replace($element_1, $replace_1, $text);
	$text = preg_replace($element_2, $replace_2, $text);


	//Замена виджета Steam на ссылку	                 
    $text = str_replace('<iframe src="https://store.steampowered.com/widget', '<a href="https://store.steampowered.com/app', $text);
	$text = str_replace('/" frameborder="0" width="85%" height="190"></iframe>', '"> Страница игры в Steam</a>', $text);
			
return $text;
}

/*markdown2html в одобренных публикациях*/
function markdown2html_pub ($text)
{
	/*Загрузка библиотеки Markdown*/
	include_once 'markdown.php';
	
	return imgForGallery(Markdown($text));
	
}

function echomarkdown_pub ($text)
{
	echo markdown2html_pub ($text);
}

/*markdown2html для использования в шаблоне*/
	
function echomarkdown ($text)
{
	echo markdown2html ($text);
}

function searchPagesNum($page, $count, $pages_count, $show_link)
{
	// $show_link - это количество отображаемых ссылок;
	// нагляднее будет, когда это число будет парное
	// Если страница всего одна, то вообще ничего не выводим

	if ($pages_count == 1) return false;

	$sperator = ' '; // Разделитель ссылок; например, вставить "|" между ссылками

	// Для придания ссылкам стиля

	$style = 'style="color: #808000; text-decoration: none;"';
	$begin = $page - intval($show_link / 2);
	unset($show_dots); // На всякий случай :)

	// Сам постраничный вывод
	// Если количество отображ. ссылок больше кол. страниц

	if ($pages_count <= $show_link + 1) $show_dots = 'no';

	// Вывод ссылки на первую страницу
	if (($begin > 2) && !isset($show_dots) && ($pages_count - $show_link > 2)) 
	{
		echo '<a '.$style.' href='.$_SERVER['php_self'].'?page=1> |< </a> ';
	}

	for ($j = 0; $j < $page; $j++) 
	{
		// Если страница рядом с концом, то выводить ссылки перед идущих для того,
		// чтобы количество ссылок было постоянным
	
		if (($begin + $show_link - $j > $pages_count) && ($pages_count-$show_link + $j > 0)) 
		{
			$page_link = $pages_count - $show_link + $j; // Номер страницы
	
			// Если три точки не выводились, то вывести
			if (!isset($show_dots) && ($pages_count-$show_link > 1)) 
			{
				echo ' <a '.$style.' href='.$_SERVER['php_self'].'?page='.($page_link - 1).'><b>...</b></a> ';
				// Задаем любое значение для того, чтобы больше не выводить в начале "..." (три точки)
				$show_dots = "no";
			}

		// Вывод ссылки
			echo ' <a '.$style.' href='.$_SERVER['php_self'].'?page='.$page_link.'>'.$page_link.'</a> '.$sperator;
		} 

		else continue;
	}

	for ($j = 0; $j <= $show_link; $j++) // Основный цикл вывода ссылок
	{
		$i = $begin + $j; // Номер ссылки
		// Если страница рядом с началом, то увеличить цикл для того,
		// чтобы количество ссылок было постоянным
	
		if ($i < 1) 
		{
			$show_link++;
			continue;
		}
	
		// Подобное находится в верхнем цикле
		if (!isset($show_dots) && $begin > 1) 
		{
			echo ' <a '.$style.' href='.$_SERVER['php_self'].'?page='.($i-1).'><b>...</b></a> ';
			$show_dots = "no";
		}
	
		// Номер ссылки перевалил за возможное количество страниц
		if ($i > $pages_count) break;

		if ($i == $page) 
		{
			echo ' <a '.$style.' ><b>'.$i.'</b></a> ';
		} 

		else 
		{
			echo ' <a '.$style.' href='.$_SERVER['php_self'].'?page='.$i.'>'.$i.'</a> ';
		}

		// Если номер ссылки не равен кол. страниц и это не последняя ссылка
		if (($i != $pages_count) && ($j != $show_link)) echo $sperator;

		// Вывод "..." в конце
		if (($j == $show_link) && ($i < $pages_count)) 
		{
			echo ' <a '.$style.' href='.$_SERVER['php_self'].'?page='.($i+1).'><b>...</b></a> ';
		}
	}

	// Вывод ссылки на последнюю страницу
	if ($begin + $show_link + 1 < $pages_count) 
	{
		echo ' <a '.$style.' href='.$_SERVER['php_self'].'?page='.$pages_count.'> >| </a>';
	}

	return true;
} 

/*Функция проверки капчи*/
function SiteVerify($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 15);
    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36");
    $curlData = curl_exec($curl);
    curl_close($curl);
    return $curlData;
}

/*Добавить / удалить конкурсные очки*/
function delOrAddContestScore($type, $pointsName)//$type - add or del, $pointsName - votingpoints, commentpoints or favouritespoints
{
	/*Загрузка функций для формы входа*/
	require_once 'access.inc.php';
			
			
	$selectPoints = 'SELECT '.$pointsName.' FROM contest WHERE id = 1';//тип добавляемых конкурсных очков
		
	/*Изменение очков в зависимости от типа действия*/
	if ($type == 'add') 
	{
		$updContestScore = 'UPDATE author SET contestscore = contestscore + ';
	}
		
	elseif ($type == 'del') 
	{
		$updContestScore = 'UPDATE author SET contestscore = contestscore - ';
	}

	/*Подключение к базе данных*/
	include 'db.inc.php';
		
	/*Выбор idauthor в зависимости от аргументов*/
	if (($type == 'del') && ($pointsName == 'commentpoints'))
	{
		/*Подключение к базе данных*/
		include 'db.inc.php';
			
		try
		{
			$sql = 'SELECT idauthor FROM comments WHERE id = :idcomment';
			$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
			$s -> bindValue(':idcomment', $_POST['id']);//отправка значения
			$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
		}
			
		catch (PDOException $e)
		{
			$error = 'Ошибка выбора idauthor для contest' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
			include 'error.inc.php';		
		}	
			
		$row = $s -> fetch();
			
		$idAuthor = (int)$row['idauthor'];//проверка на включение конкурса
	}
		
	else
	{
		$idAuthor = (int)(authorID($_SESSION['email'], $_SESSION['password']));
	}

	/*Обновить конкурсный счёт*/
	try
	{
		$pdo->beginTransaction();//инициация транзакции

		$sql = $selectPoints;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

		$row = $s -> fetch();

		$points = $row[$pointsName];//проверка на включение конкурса
			
		$sql = $updContestScore.$points.' WHERE id = '.$idAuthor;//обновление конкурсного счёта
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL

		$pdo->commit();//подтверждение транзакции			
	}

	catch (PDOException $e)
	{
		$pdo->rollBack();//отмена транзакции

		$error = 'Error transaction при изменении конкурсного счёта' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.inc.php';		
	}	
}

/*Данные по умолчанию для формы регистрации*/
function defaultRegFormData()
{
	$GLOBALS ['title'] = 'Регистрация нового пользователя';//Данные тега <title>
	$GLOBALS ['headMain'] = 'Регистрация';
	$GLOBALS ['robots'] = 'noindex, nofollow';
	$GLOBALS ['descr'] = 'Регистрация нового пользователя в системе';
	$GLOBALS ['action'] = 'addform';
	$GLOBALS ['authorname'] = '';
	$GLOBALS ['email'] = '';
	$GLOBALS ['www'] = '';
	$GLOBALS ['idauthor'] = '';
	$GLOBALS ['password'] = '';
	$GLOBALS ['password2'] = '';
	$GLOBALS ['accountinfo'] = '';
	$GLOBALS ['button'] = 'Регистрация';
	$GLOBALS ['scriptJScode'] = '<script src="script.js"></script>';//добавить код JS
	
	$GLOBALS ['reCapchaAPI'] = '<script src="https://www.google.com/recaptcha/api.js"></script>'; //для ReCapcha
}

/*Добавление микроразметки*/
function dataMarkup ($title = '' , $description = '', $imghead = '', $imgalt = '', $id = '', $date = '', 
					 $author = '', $averagenumber = '', $votecount = '', $videoDuration = '', $videoFile = '',  $articleType) //$articleType - viewpost, viewnews, video																												viewpromotion
{
	if ($votecount == 0) 
	{
		$votecount = 1;
		$averagenumber = 5;
	}

	if ($articleType !== 'video')
		return '
		
				<meta name="twitter:card" content="summary_large_image">
				<meta name="twitter:site" content="@Arseni_Pol">
				<meta name="twitter:title" content="'.substr($title, 0, 70).'">
				<meta name="twitter:description" content="'.substr($description, 0, 200).'">
				<meta name="twitter:image" content="https://'.$_SERVER['SERVER_NAME'].'/images/'.$imghead.'">	
				<meta name="twitter:image:alt" content="'.$imgalt.'">
				
				
				<meta name="og:url" content="https://'.$_SERVER['SERVER_NAME'].'/'.$articleType.'/?id='.$id.'">
				<meta name="og:type" content="article">
				<meta name="og:title" content="'.$title.'">
				<meta name="og:description" content="'.substr($description, 0, 200).'">
				<meta name="og:image" content="https://'.$_SERVER['SERVER_NAME'].'/images/'.$imghead.'">
				
				
				<script type="application/ld+json">
				{
					"@context": "http://schema.org",
					"@type": "Article",
					"mainEntityOfPage": {
						"@type": "WebPage",
						"@id": "https://'.$_SERVER['SERVER_NAME'].'/'.$articleType.'/?id='.$id.'"
						},
					"headline": "'.$title.'",
					"image": {
						"@type": "ImageObject",
						"url": "https://'.$_SERVER['SERVER_NAME'].'/images/'.$imghead.'",
						"width": 800,
						"height": 600
						},
					"datePublished": "'.$date.'",
					"dateModified": "'.$date.'",
					"author": {
						"@type": "Person",
						"name": "'.$author.'"
						},
					"publisher": {
						"@type": "Organization",
						"name": "IMAGOZ",
						"logo": {
							"@type": "ImageObject",
							"url": "https://'.$_SERVER['SERVER_NAME'].'/logomain.png",
							"width": 500,
							"height": 500
							}
						},
					"description": "'.$description.'",
					"aggregateRating": {
						"@type": "AggregateRating",
						"itemReviewed": "Thing",
						"bestRating": 5,
						"ratingValue": '.$averagenumber.',
						"ratingCount": '.$votecount.'
						}
					}
				</script>';
	else
		return '

			<meta name="twitter:card" content="summary_large_image">
			<meta name="twitter:site" content="@Arseni_Pol">
			<meta name="twitter:title" content="'.substr($title, 0, 70).'">
			<meta name="twitter:description" content="'.substr($description, 0, 200).'">
			<meta name="twitter:image" content="https://'.$_SERVER['SERVER_NAME'].'/images/'.$imghead.'">	
			<meta name="twitter:image:alt" content="'.$imgalt.'">
			
			
			<meta property="og:title" content="'.$title.'">
			<meta property="og:url" content="https://'.$_SERVER['SERVER_NAME'].'/'.$articleType.'/?id='.$id.'">
			<meta property="og:video" content="https://'.$_SERVER['SERVER_NAME'].'/videofiles/'.$videoFile.'"/> 
			<meta property="og:description" content="'.substr($description, 0, 200).'">
			<meta property="video:duration" content="'.$videoDuration.'"/>
			<meta property="og:image" content="https://'.$_SERVER['SERVER_NAME'].'/images/'.$imghead.'">
			<meta property="ya:ovs:upload_date" content="'.$date.'"/>
			<meta property="ya:ovs:adult" content="false"/>
			<meta property="og:type" content="video.other">		
			<meta property="og:video:type" content="flash">	
			';
}

/*Данные для обновления комментариев*/
function updCommentData($id, $idArticle)
{
	/*Подключение к базе данных*/
	include 'db.inc.php';
	
	try
	{
		$sql = 'SELECT * FROM comments  
		WHERE id = :idcomment';//Вверху самое последнее значение
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idcomment', $id);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора комментария для обновления' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.inc.php';
	}
	
	$row = $s -> fetch();	
	
	$GLOBALS ['title'] = 'Редактирование комментария | imagoz.ru';//Данные тега <title>
	$GLOBALS ['headMain'] = 'Редактирование комментария';
	$GLOBALS ['robots'] = 'noindex, follow';
	$GLOBALS ['descr'] = 'Форма редактирования комментария';
	$GLOBALS ['action'] = 'editform';	
	$GLOBALS ['text'] = $row['comment'];
	$GLOBALS ['id'] = $row['id'];
	$GLOBALS ['idArticle'] = $idArticle;
	$GLOBALS ['button'] = 'Обновить комментарий';
	$GLOBALS ['scriptJScode'] = '<script src="script.js"></script>';//добавить код JS
}

/*Обновление комментариев*/
function updComment($id, $comment, $idArticle, $type) //news, post, promotion
{
	/*Подключение к базе данных*/
	include 'db.inc.php';
	
	try
	{
		$sql = 'UPDATE comments SET 
			comment = :comment
			WHERE id = :idcomment';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idcomment', $id);//отправка значения
		$s -> bindValue(':comment', $comment);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
		
	catch (PDOException $e)
	{
		$error = 'Ошибка обновления информации comment' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.inc.php';
	}

	if ($type == 'publication')
		$folder = $type;
	else
		$folder = 'view'.$type;

	header ('Location: ../'.$folder.'/?id='.$idArticle);//перенаправление обратно в контроллер index.php
	exit();
}

/*Данные для удаления комментариев*/
function delCommentData($id, $idArticle)
{
	/*Подключение к базе данных*/
	include 'db.inc.php';
	
	/*Команда SELECT*/
	try
	{
		$sql = 'SELECT id FROM comments WHERE id = :idcomment';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':idcomment', $id);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора id комментария' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.inc.php';
	}
	
	$row = $s -> fetch();
	
	$GLOBALS ['title'] = 'Удаление комментария';//Данные тега <title>
	$GLOBALS ['headMain'] = 'Удаление комментария';
	$GLOBALS ['robots'] = 'noindex, follow';
	$GLOBALS ['descr'] = 'Форма удаления комментария';
	$GLOBALS ['action'] = 'delete';
	$GLOBALS ['idArticle'] = $idArticle;
	$GLOBALS ['posttitle'] = 'Комментарий';
	$GLOBALS ['id'] = $row['id'];
	$GLOBALS ['button'] = 'Удалить';
}

/*Замена watch?v= на embed в видео*/
function toEmbedInVideo($video)
{
	$element_1 = 'watch?v='; //искомый элемент
	$replace_1 = 'embed/'; //на что меняем
	
	$element_2 = 'youtu.be'; //искомый элемент
	$replace_2 = 'www.youtube.com/embed'; //на что меняем

	$element_3 = 'shorts'; //искомый элемент
	$replace_3 = 'embed'; //на что меняем
	
	$findStWatch = strpos ($video, $element_1);
	$findStYoutube = strpos ($video, $element_2);
	$findStShort = strpos ($video, $element_3);
	
	if ($findStWatch != '')
	{
		$video = str_replace($element_1, $replace_1, $video);
	}
	
	elseif ($findStYoutube != '')
	{
		$video = str_replace($element_2, $replace_2, $video);
	}

	elseif ($findStShort != '')
	{
		$video = str_replace($element_3, $replace_3, $video);
	}
	
	else
	{
		$video = $video;
	}
	
	//$video = $findSt != '' ? str_replace($element, $replace, $video) : $video;
	
	return $video;
}


/*Корректное отображение видео в статьях*/
function viewVideoInArticle ($text)
{
	$element_1 = "/http(s)?:\/\/youtu\.be\/([^\40\t\r\n\<]+)/i"; //искомый элемент
	$element_2 = "#(https?)://www\.youtube\.com\/watch\?v=([-_a-z0-9]{11})#i"; //искомый элемент
	$element_3 = "#(https?)://www\.youtube\.com\/shorts\/([A-Za-z0-9_-]{11})#i"; //искомый элемент
	$element_4 = 'width="646"';//для виджета Steam

	$replace_1 = '<iframe width="85%" height="400" src="https://www.youtube.com/embed/${2}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'; //на что меняем
	$replace_2 = 'width="85%"';

	$text = preg_replace($element_1, $replace_1, $text);
	$text = preg_replace($element_2, $replace_1, $text);
	$text = preg_replace($element_3, $replace_1, $text);
	$text = str_replace($element_4, $replace_2, $text);

	return $text;
	
}

/*Предварительенй просмотр*/

function preview($type, $idArticle)//$type - newsblock, posts, promotion
{
	if ($type == 'newsblock')
	{
		$select = 'SELECT newsblock.id AS articleid, author.id AS idauthor, news AS articledata, newstitle AS title, imghead, imgalt, videoyoutube, newsdate AS articledate, authorname, category.id AS categoryid, categoryname FROM newsblock 
				INNER JOIN author ON idauthor = author.id 
				INNER JOIN category ON idcategory = category.id WHERE premoderation = "NO" AND newsblock.id = ';

		$forDelUpd = 'addupdnews';
	}
	
	elseif ($type == 'posts')
	{
		$select = 'SELECT posts.id AS articleid, author.id AS idauthor, post AS articledata, posttitle AS title, imghead, imgalt, videoyoutube, postdate AS articledate, authorname, category.id AS categoryid, categoryname FROM posts 
			   INNER JOIN author ON idauthor = author.id 
			   INNER JOIN category ON idcategory = category.id WHERE premoderation = "NO" AND posts.id = ';

		$forDelUpd = 'addupdpost';
	}

	elseif ($type == 'promotion')
	{
		$select = 'SELECT promotion.id AS articleid, author.id AS idauthor, promotion AS articledata, promotiontitle AS title, imghead, imgalt, videoyoutube, promotiondate AS articledate, authorname, category.id AS categoryid, categoryname FROM promotion 
			   INNER JOIN author ON idauthor = author.id 
			   INNER JOIN category ON idcategory = category.id WHERE premoderation = "NO" AND promotion.id = ';

		$forDelUpd = 'addupdpromotion';
	}

	elseif ($type == 'video')
	{
		$select = 'SELECT video.id AS articleid, author.id AS idauthor, post AS articledata, videotitle AS title, imghead, imgalt, videoyoutube, videofile, videodate AS articledate, authorname, category.id AS categoryid, categoryname FROM video 
			   INNER JOIN author ON idauthor = author.id 
			   INNER JOIN category ON idcategory = category.id INNER JOIN category ON idcategory = category.id WHERE premoderation = "NO" AND video.id = ';

		$forDelUpd = 'addupdvideo';
	}

	elseif ($type == 'publication')
	{
		$select = 'SELECT publication.id AS articleid, author.id AS idauthor, text AS articledata, title, imghead, imgalt, idblog, videoyoutube, date AS articledate, authorname, category.id AS categoryid, categoryname FROM publication 
			   INNER JOIN author ON idauthor = author.id 
			   INNER JOIN category ON idcategory = category.id WHERE premoderation = "NO" AND publication.id = ';

		$forDelUpd = 'addupdblogpublication';
	}

	include MAIN_FILE . '/includes/db.inc.php';
 
	try
	{
		$sql = $select.$idArticle ;
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка данных для превью' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.inc.php';
	}

	$row = $s -> fetch();

	$GLOBALS['articleId'] = $row['articleid'];
	$GLOBALS['authorId'] = $row['idauthor'];
	$GLOBALS['articleText'] = $row['articledata'];
	$GLOBALS['imgHead'] = $row['imghead'];
	$GLOBALS['imgAlt'] = $row['imgalt'];
	$GLOBALS['date'] = $row['articledate'];
	$GLOBALS['nameAuthor'] = $row['authorname'];
	$GLOBALS['categoryName'] = $row['categoryname'];
	$GLOBALS['categoryId'] = $row['categoryid'];
	$GLOBALS['posttitle'] = $row['title'];
	$GLOBALS['videoFile'] = (isset($row['videofile'])) && ($row['videofile'] != '') ? $row['videofile'] : '';
	$GLOBALS['idblog'] = (isset($row['idblog'])) && ($row['idblog'] != '') ? $row['idblog'] : '';


	/*Вывод видео в статью*/
	if ((isset($row['videoyoutube'])) && ($row['videoyoutube'] != ''))
	{
		$GLOBALS['video'] = '<iframe width="85%" height="320px" src="'.$row['videoyoutube'].'" frameborder="0" allowfullscreen></iframe>';
	}

	else
	{
		$GLOBALS['video'] = '';
	}

	$GLOBALS['delAndUpd'] = "<form action = '../../admin/".$forDelUpd."/' method = 'post'>

								Редактировать материал:
								<input type = 'hidden' name = 'id' value = '".$idArticle."'>
								<input type = 'submit' name = 'action' value = 'Upd' class='btn_2'>
							</form>";

	$GLOBALS['title'] = 'Материал сохранён в черновике';//Данные тега <title>
	$GLOBALS['headMain'] = 'Материал сохранён в черновике';
	$GLOBALS['robots'] = 'noindex, nofollow';
	$GLOBALS['descr'] = '';
	$GLOBALS['scriptJScode'] = '<script src="script.js"></script>';//добавить код JS					
}

/*Вывод тематик(тегов) для превью*/
	
function previewMetas($type, $typeId, $idArticle)//$type - newsblock, posts, promotion, video; $typeId - idnews, idpost, idpromotion
{
	include MAIN_FILE . '/includes/db.inc.php';

	try
	{
		$sql = 'SELECT meta.id, metaname FROM '.$type.' 
			INNER JOIN metapost ON '.$type.'.id = '.$typeId.' 
			INNER JOIN meta ON meta.id = idmeta 
			WHERE '.$type.'.id = '.$idArticle;//Вверху самое последнее значение
		$result = $pdo->query($sql);
	}

	catch (PDOException $e)
	{
		$error = 'Ошибка выбора тега' . $e -> getMessage();// вывод сообщения об ошибке в переменой $e
		include 'error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$metas[] =  array ('id' => $row['id'], 'metaname' => $row['metaname']);
	}

	return $metas;
}

/*Вывод аналогичных публикаций*/
function similarPublication($type, $categoryID) //$type = news, post, promotion ...
{
	if($type == 'news')
		$select = 'SELECT id, newstitle as title, imghead, imgalt FROM newsblock WHERE idcategory = '.$categoryID.' AND premoderation = "YES" ORDER BY rand() LIMIT 6';
	elseif ($type == 'post')
		$select = 'SELECT id, posttitle as title, imghead, imgalt FROM posts WHERE idcategory = '.$categoryID.' AND premoderation = "YES" ORDER BY rand() LIMIT 6';
	elseif ($type == 'promotion')
		$select = 'SELECT id, promotiontitle as title, imghead, imgalt FROM promotion WHERE idcategory = '.$categoryID.' AND premoderation = "YES" ORDER BY rand() LIMIT 6';
	elseif ($type == 'publication')
		$select = 'SELECT p.id, p.title, p.imghead, p.imgalt FROM publication p INNER JOIN subscribers s ON s.idauthor = p.idauthor AND s.idblog = p.idblog WHERE p.premoderation = "YES" ORDER BY rand() LIMIT 6';

		/*Подключение к базе данных*/
	include 'db.inc.php';

	try
	{
		$sql = $select;
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода заголовка похожей новости';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$GLOBALS['similarPub'][] =  array ('id' => $row['id'], 'title' =>  $row['title'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt']);
	}	
}

/*Вывод аналогичных публикаций*/
function randomSubscriptions ($idAuthor)
{

	$select = 'SELECT p.id, p.title, p.imghead, p.imgalt FROM publication p LEFT JOIN subscribers s ON s.idblog = p.idblog WHERE p.premoderation = "YES" and s.idauthor = '.$idAuthor.' ORDER BY rand() LIMIT 6';

	/*Подключение к базе данных*/
	include 'db.inc.php';

	try
	{
		$sql = $select;
		$result = $pdo->query($sql);
	}
	
	catch (PDOException $e)
	{
		$error = 'Ошибка вывода заголовка похожей новости';
		include MAIN_FILE . '/includes/error.inc.php';
	}

	/*Вывод результата в шаблон*/
	foreach ($result as $row)
	{
		$GLOBALS['similarPub'][] =  array ('id' => $row['id'], 'title' =>  $row['title'], 'imghead' =>  $row['imghead'], 'imgalt' =>  $row['imgalt']);
	}	
}
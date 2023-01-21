<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';

/*Выбор  новостей для дайджеста*/
/*Команда SELECT*/

$content = '';
$preview = '';
$where = '';
$forSearch = array();//массив заполнения запроса

/*Выбор рубрики*/
if ($_POST['category'] != '')//Если выбрана рубрика
{
	$where = " AND idcategory = :idcategory ";
	$forSearch[':idcategory'] = $_POST['category'];
}

try
{
	$sql = 'SELECT  
                news, 
                newstitle, 
                newsdate,  
                videoyoutube 
            FROM newsblock
            WHERE 
                premoderation = "YES"
                and lengthtext < '.$_POST['lengthtext'].' 
                and newsdate >= "'.$_POST['dt1'].'" 
                and newsdate <= "'.$_POST['dt2'].'"'.$where.'
            
            ORDER BY newsdate DESC';//Вверху самое последнее значение
    $s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
    $s -> execute($forSearch);// метод дает инструкцию PDO отправить запрос MySQL. Т. к. массив $forSearch хранит значение всех псевдопеременных 
                                          // не нужно указывать их по отдельности с помощью bindValue	
}

catch (PDOException $e)
{
	$error = 'Ошибка выбора для генератора новоситей';
	include MAIN_FILE . '/includes/error.inc.php';
}

/*Вывод результата в шаблон*/
foreach ($s as $row)
{
	$newsMain[] =  array ('textnews' => $row['news'], 'newstitle' =>  $row['newstitle'], 'newsdate' =>  $row['newsdate'], 'videoyoutube' =>  $row['videoyoutube']);
}

if (!empty($newsMain))
{
    /*Сборка статьи*/
    foreach ($newsMain as $news)
    {
        

        $preview .= '<b>'.$news['newsdate'].' '.$news['newstitle'].'</b><br>';

        $video = $news['videoyoutube'] != '' ? '<br><figure><iframe width="560" height="315" src="'.$news['videoyoutube'].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></figure>' : '';
        $textSet = markdown2html_pub($news['textnews']);

        $content .= '<h2>'.$news['newstitle'].'</h2>'.delDetails(isertTagFigure($textSet)).$video;

    }

    $isPulse = !empty($_POST['ispulse']) ? 1 : 0;

    $isDzen = !empty($_POST['isdzen']) ? 1 : 0;

    $content = 'Публикация на тему '.$content;

    if ($isPulse == 1 && $isDzen == 1)
        $blogType = 'Пульс и Дзен. ';
    elseif ($isPulse == 1 && $isDzen == 0)
        $blogType = 'Пульс. ';
    elseif ($isPulse == 0 && $isDzen == 1)
        $blogType = 'Дзен. ';
    else
        $blogType = 'Разное. ';

    $interval = $_POST['dt1'].' - '.$_POST['dt2'];

    $titleSet = $blogType.'Новостной дайджест '.$interval;

    try
    {
        $sql = 'INSERT INTO newsset SET 
                date = SYSDATE(),
                intervalofset = :intervalofset,
				authorname = :authorname,
                categoryname = :categoryname,	
                title = :title,
                text = :text,
                ispulse = :ispulse,
                isdzen = :isdzen';
		$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
		$s -> bindValue(':intervalofset', $interval);//отправка значения
        $s -> bindValue(':authorname', $_POST['authorname']);//отправка значения
        $s -> bindValue(':categoryname', 'Подборка новостей');//отправка значения
        $s -> bindValue(':title', $titleSet);//отправка значения
        $s -> bindValue(':text', $content);//отправка значения
        $s -> bindValue(':ispulse', $isPulse);//отправка значения
        $s -> bindValue(':isdzen', $isDzen);//отправка значения
		$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка генерации дайджеста';
		include MAIN_FILE . '/includes/error.inc.php';
	}

    // Формируем массив для JSON ответа
    $result = array('res' => 'generated',
                    'preview' => $preview);

    // Переводим массив в JSON
    echo json_encode($result);
}

else 
{
    // Формируем массив для JSON ответа
    $result = array('res' => 'no_generate');

    // Переводим массив в JSON
    echo json_encode($result);
}


?>
<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Вывод текста о сотрудничестве*/

$title = 'Ссылки на на наши соцсети | imagoz.ru';//Данные тега <title>
$headMain = 'Ссылки';
$robots = 'all';
$descr = 'Здесь представлены ссылки на соцсети и другие проекты imagoz.ru';

$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
$breadPart2 = '<a href="//'.MAIN_URL.'/links">Ссылки</a> ';//Для хлебных крошек

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';
	
/*Определение нахождения пользователя в системе*/
loggedIn();

/*Текст о сотрудничестве*/

$links = '<p>На данной странице перечислены ссылки на все основные официальные проекты и социальные сети, связанные с порталом <strong>imagoz.ru</strong>.
<br>
<br><a href="https://mt.imagoz.ru/" target="_blank"><strong>Мир тесен</strong></a>  – страница нашего портала в рекомендательной сети. Здесь публикуются основные новости и статьи сайта практически параллельно с главным порталом
<br>
<br><a href="https://dzen.ru/imagoz" target="_blank"><strong>Канал на Дзен</strong></a> – существует с сентября 2019 года. Тут публикуется много уникальных материалов, которых нет на портале imagoz.ru, также новостные подборки и статьи с сайта. Многие видео (В том числе рубрика Негромкие анонсы) изначально публикуются здесь.
<br>
<br><a href="https://pulse.mail.ru/imagoz-igry-i-tehnologii/" target="_blank"><strong>Канал на Пульс</strong></a> – тут публикуются статьи и некоторые новости почти одновременно с основным сайтом. Также выкладываются подборки новостей и некоторые ролики. 
<br>
<br><a href="https://www.youtube.com/channel/UCYAlQfGJQC4de8gEmZwF9Yg" target="_blank"><strong>Канал на YouTube</strong></a> – здесь публикуются ролики нашего производства, также планируются трансляции. Видео короткого формата выходят изначально здесь
<br>
<br><a href="https://rutube.ru/channel/17038820/" target="_blank"><strong>Канал на RuTube</strong></a> – здесь также периодически выходят наши ролики
<br>
<br><a href="https://vk.com/imagoz" target="_blank"><strong>Группа Вконтакте</strong></a> – существует со времён первой версии сайта imagoz.ru. Создана в 2013 году. Здесь помимо всего прочего периодически дублируются статьи и новости сайта.
<br>
<br><a href="https://likee.video/@imagoz.ru" target="_blank"><strong>Likee</strong></a> и <a href="https://yappy.media/profile/c12b313b5bf44495b8ad6eaf032901df" target="_blank"><strong>Yappy</strong></a> – здесь периодически выходят наши короткие видео
</p>';
				
include 'links.html.php';
exit();	
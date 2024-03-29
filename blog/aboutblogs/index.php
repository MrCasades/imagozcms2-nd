<?php
/*Загрузка главного пути*/
include_once '../../includes/path.inc.php';

/*Вывод текста о сотрудничестве*/

$title = 'О блогах | imagoz.ru';//Данные тега <title>
$headMain = 'О блогах';
$robots = 'all';
$descr = 'Информация о сервисе блогов imagoz.ru';

$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
$breadPart2 = '<a href="//'.MAIN_URL.'/blogs/">Блоги</a> >>';//Для хлебных крошек
$breadPart3 = '<a href="//'.MAIN_URL.'/blog/aboutblogs">О блогах</a> ';//Для хлебных крошек

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';
	
/*Определение нахождения пользователя в системе*/
loggedIn();

/*Текст о сотрудничестве*/

$aboutBlogs = '<p>Добро пожаловать в сервис блогов <strong>imagoz.ru</strong>. Пишите интересные и полезные заметки, делитесь личным опытом из разных сфер нашей жизни.</p>

				<p>На в блогах <strong>imagoz.ru</strong> приветствуются следующие темы: информационные технологии (IT), программирование, компьютерная техника, комплектующие, электроника, высокие технологии (Hi-Tech), разные интересные гаджеты, компьютерные игры, консоли, игровая индустрия, популярная наука и другие подобные этим. Но не против и иных тем.</p>

				<p>Главное, пишите грамотно интересно и полезно для других людей, и тогда ваши публикации будут индексироваться и попадать в поисковики. Ваши заметки будут доступны для огромной аудитории! Также общайтесь, пишите комментарии, оценивайте и поднимайте статьи в рейтинге, подписывайтесь на блоги других авторов.</p>
								
				<p>Начать публиковаться на <strong>imagoz.ru</strong> просто. Заходите в раздел  <a href = "//'.MAIN_URL.'/myblogs"><strong>Мои блоги</strong></a> и начинайте творить! Главное соблюдайте законы, не разжигайте национальную и политическую вражду, будьте интересны окружающим и Вас ждёт успех в нашем сервисе блогов.</p>';
				
include 'aboutblogs.html.php';
exit();	
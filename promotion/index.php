<?php
/*Загрузка главного пути*/
include_once '../includes/path.inc.php';

/*Вывод текста о промоушене*/

$title = 'Промоушен, рекламные статьи | imagoz.ru';//Данные тега <title>
$headMain = 'Промоушен';
$robots = 'all';
$descr = 'Предложение по размещению рекламных статей на портале imagoz.ru';

$breadPart1 = '<a href="//'.MAIN_URL.'">Главная страница</a> >> '; //Для хлебных крошек
$breadPart2 = '<a href="//'.MAIN_URL.'/promotion">Промоушен</a> ';//Для хлебных крошек

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';
	
/*Определение нахождения пользователя в системе*/
loggedIn();

/*Подключение к базе данных*/
include MAIN_FILE . '/includes/db.inc.php';
	
/*Команда SELECT выбор цены промоушена*/
try
{
	$sql = 'SELECT promotionprice FROM promotionprice WHERE id = 1';
	$s = $pdo->prepare($sql);// подготавливает запрос для отправки в бд и возвр объект запроса присвоенный переменной
	$s -> execute();// метод дает инструкцию PDO отправить запрос MySQL
}

catch (PDOException $e)
{
	$error = 'Ошибка выбора цены промоушена';
	include MAIN_FILE . '/includes/error.inc.php';
}
	
$row = $s -> fetch();
	
$promotionPrice = $row['promotionprice'];

/*Текст о сотрудничестве*/

$forPromotions = '<p>Портал <strong>IMAGOZ.RU</strong> даёт Вам возможность продвижения своего сайта, продукта, идеи и т. п. с помощью платных статей, заметок или пресс-релизов. Промоушен при помощи рекламных статей - хороший способ для повышения узнаваемости Вашего бренда или продукта, также мощный инструмент <strong>SEO-оптимизпции</strong>. </p>

<p><strong>Главное требование</strong> в контексте нашего портала - <strong>публикация должна вписываться в тематики сайта</strong>. Это компьютеры, игры, консоли, ретро-игры, гаджеты, высокие технологии (HI-TECH), искусственный интеллект, популярная наука, научные разработки и все подобные смежные области. </p> 

<p>Воспользоваться данной услугой проще простого! <a href="/admin/registration/?reg">Регистрируйтесь</a> на нашем портале, выполняйте <a href="/admin/registration/?log">вход</a>, кликайте на ваше имя вверху страницы под логотипом, зайдя тем самым в профиль, нажимайте на кнопку "Стать рекламодателем". Затем принимайте условия публикаций и пополняйте баланс на сумму, достаточную для написания статьи, которая на данный момент составляет <strong>'.$promotionPrice.' рубля</strong>.</p>

<p>Все материалы отправляются на премодерацию, проверяются на уникальность и соответствие тематике портала <strong>IMAGOZ.RU</strong>. <strong>Ключевой момент</strong> успешной публикации - грамотный русский язык и высокая уникальность (90 - 100%). Желательный объём - от 1000 знаков. В случае отклонения материала, деньги вернуться на Ваш счёт на потрале, откуда могут быть выведены обратно, с помощью платёжных систем <strong>Qiwi или Яндекс.Деньги</strong>, или использованы для повторной попытки публикации.</p>
<p><h6>По всем вопросам:</h6>
		  	<ul>			  
			  <li>E-mail: imagozman@gmail.com</li>
			</ul>
		  </p>';
	
include 'promotion.html.php';
exit();	
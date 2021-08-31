<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "headers-places"> 
		<div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?></h1></div>
	</div>
	<div class = "main-headers-line"></div>
</div>

<div class = "m-content addupd-post">
    <a href="//<?php echo MAIN_URL;?>/admin/authorpremoderation/#bottom"><button class="btn_2"><strong>В ПРЕМОДЕРАЦИИ</strong></button></a>
    <a href="//<?php echo MAIN_URL;?>/admin/refused/#bottom"><button class="btn_2"><strong>ОТКЛОНЁННЫЕ МАТЕРИАЛЫ ("<?php echo $allRefusedMP;?>")</strong></button></a>
    <a href="//<?php echo MAIN_URL;?>/admin/viewalldraft/#bottom"><button class="btn_2"><strong>ЧЕРНОВИК ("<?php echo $allDraft;?>")</strong></button></a>
    <a href="//<?php echo MAIN_URL;?>/admin/addupdpromotion/?add"><button class="btn_2"><strong>НАПИСАТЬ РЕКЛАМНУЮ СТАТЬЮ</strong></button></a>
    <?php if (userRole('Автор')):?>
        <a href="//<?php echo MAIN_URL;?>/admin/viewallauthortask/#bottom"><button class="btn_2"><strong>МОИ ЗАДАНИЯ ("<?php echo $myTasks;?>")</strong></button></a>
        <a href="//<?php echo MAIN_URL;?>/admin/viewalltask/#bottom"><button class="btn_2"><strong>ПОЛУЧИТЬ ЗАДАНИЕ</strong></button></a>
        <?php if (userRole('Супер-автор')):?>
            <a href="//<?php echo MAIN_URL;?>/admin/addupdpost/?add"><button class="btn_1">ДОБАВИТЬ СТАТЬЮ</button></a>
            <a href="//<?php echo MAIN_URL;?>/admin/addupdnews/?add"><button class="btn_1">ДОБАВИТЬ НОВОСТЬ</button></a> 
            <p>Режим супер-автора позволяет раз в двое суток делать свободные публикации (в рамках тематики портала) без необходимости предварительно брать задание. Тариф обычный для статей и новостей. 
			Согласуйте тему и приблизительный объём с администратором в личном сообщении или через форму <strong><a href="//<?php echo MAIN_URL;?>/admin/adminmail/?addmessage#bottom">обратной связи</a></strong>.</p>
            <?php echo $viewTimer; ?> 
        <?php endif;?>
    <?php elseif (userRole('Администратор')):?>
        <a href="//<?php echo MAIN_URL;?>/admin/addupdpost/?add"><button class="btn_2">Добавить статью</button></a>
        <a href="//<?php echo MAIN_URL;?>/admin/addupdnews/?add"><button class="btn_2">Добавить новость</button></a>
        <a href="//<?php echo MAIN_URL;?>/admin/addtask/?add"><button class="btn_2">Добавить задание</button></a>
        <a href="//<?php echo MAIN_URL;?>/admin/viewalltask/"><button class="btn_2">Получить задание</button></a>
        <a href="//<?php echo MAIN_URL;?>/admin/"><button class="btn_4">Редактирование списков</button></a>
        <a href="//<?php echo MAIN_URL;?>/admin/premoderation/?posts"><button class="btn_2">Премодерация статей ("<?php echo $premodPosts;?>")</button></a>
        <a href="//<?php echo MAIN_URL;?>/admin/premoderation/?news"><button class="btn_2">Премодерация новостей ("<?php echo $premodNews;?>")</button></a>
        <a href="//<?php echo MAIN_URL;?>/admin/premoderation/?promotion"><button class="btn_2">Премодерация промоушена ("<?php echo $premodPromotion;?>")</button></a>
        <a href="//<?php echo MAIN_URL;?>/admin/payment/viewallpayments/"><button class="btn_2">Заявки на выплату ("<?php echo $paymentsCount;?>")</button></a>
        <a href="//<?php echo MAIN_URL;?>/admin/adminmail/viewallmessages/"><button class="btn_2">Обратная связь ("<?php echo $unread;?>")</button></a> 
    <?php endif;?>
</div>


<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
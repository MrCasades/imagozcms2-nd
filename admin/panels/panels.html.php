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
    <a href="//<?php echo MAIN_URL;?>/admin/refused/#bottom' class='btn btn-danger btn-sm"><strong>ОТКЛОНЁННЫЕ МАТЕРИАЛЫ ("<?php echo $myrefusedPromotions;?>")</strong></a>
    <a href="//<?php echo MAIN_URL;?>/admin/viewalldraft/#bottom" class='btn btn-success btn-sm'><strong>ЧЕРНОВИК ("<?php echo $allDraft;?>")</strong></a>
    <a href="//<?php echo MAIN_URL;?>/admin/addupdpromotion/?add" class='btn btn-warning btn-sm'><strong>НАПИСАТЬ РЕКЛАМНУЮ СТАТЬЮ</strong></a>
    <?php if (userRole('Автор')):?>
        <a href="//<?php echo MAIN_URL;?>/admin/viewallauthortask/#bottom" class='btn btn-primary btn-sm'><strong>МОИ ЗАДАНИЯ ("<?php echo $myTasks;?>")</strong></a>
        <a href="//<?php echo MAIN_URL;?>/admin/viewalltask/#bottom" class='btn btn-info btn-sm'><strong>ПОЛУЧИТЬ ЗАДАНИЕ</strong></a>
        <?php if (userRole('Супер-автор')):?>
            <a href="//<?php echo MAIN_URL;?>/admin/addupdpost/?add" class='btn btn-primary btn-sm'>Добавить статью</a>
            <a href="//<?php echo MAIN_URL;?>/admin/addupdnews/?add" class='btn btn-primary btn-sm'>Добавить новость</a> 
        <?php endif;?>
    <?php elseif (userRole('Администратор')):?>
        <a href="//<?php echo MAIN_URL;?>/admin/addupdpost/?add" class='btn btn-primary btn-sm'>Добавить статью</a>
        <a href="//<?php echo MAIN_URL;?>/admin/addupdnews/?add" class='btn btn-primary btn-sm'>Добавить новость</a>
        <a href="//<?php echo MAIN_URL;?>/admin/addtask/?add" class='btn btn-primary btn-sm'>Добавить задание</a>
        <a href="//<?php echo MAIN_URL;?>/admin/viewalltask/" class='btn btn-primary btn-sm'>Получить задание</a>
        <a href="//<?php echo MAIN_URL;?>/admin/" class='btn btn-primary btn-sm'>Редактирование списков</a>
    <?php endif;?>
</div>


<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
    	<h2><?php htmlecho ($headMain); ?></h2>
		<div class = "main-headers-line"></div>
	</div>
</div>

<?php if (empty ($messages))
		 {
			 echo 'Новости отсутствуют';
		 }
		 
		 else
			 
		 foreach ($messages as $message): ?> 
		  
		<div class="adm-news-pl m-content">
			<h3 class="for-info-txt"><?php htmlecho($message['messagedate']); ?> | <?php htmlecho($message['messagetitle']); ?></h3>
			<p><?php echomarkdown (implode(' ', array_slice(explode(' ', strip_tags($message['text'])), 0, 50))); ?> [...]</p>
			<p><a href="../../../admin/adminmail/viewnews/?idadminnews=<?php htmlecho($message['id']); ?>"><button class="btn_2">Подробнее</button></a></p>
		</div>

		 <?php endforeach; ?>
		
<?php 
/*Загрузка пагинации*/
include_once MAIN_FILE . '/pubcommonfiles/pagination.inc.php';?>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
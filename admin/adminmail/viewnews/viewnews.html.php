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

<?php foreach ($messages as $message): ?> 
	<div class="adm-news-pl m-content">
	<?php echo $delAndUpdNews; ?>
		<h3 class="for-info-txt"><?php htmlecho($message['messagedate']); ?>
			<p><a href="../../../admin/adminmail/viewadminnews/"><button class="btn_2">Все новости</button></a></p>
		</h3>
		<p><?php echomarkdown ($message['text']); ?></p>
	</div>			
<?php endforeach; ?>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
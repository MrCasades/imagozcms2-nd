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

<?php foreach ($messages as $message): ?> 
	<div class="adm-news-pl m-content">
	<?php echo $delAndUpdNews; ?>
		<h3 class="for-info-txt"><?php htmlecho($message['messagedate']); ?>
			<p><a href="../../../admin/adminmail/viewadminnews/" class="btn btn-info btn-sm">Все новости</a></p>
		</h3>
		<p><?php echomarkdown ($message['text']); ?></p>
	</div>			
<?php endforeach; ?>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
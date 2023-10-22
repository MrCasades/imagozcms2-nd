<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?> | <a href="#" onclick="history.back();">Назад</a></h1></div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<div class="m-content">
	<p class = "for-info-txt"><a href="../../../admin/addadminnews/?addmessage"><button class="btn_4">Добавить новость от администрации</button></a> | 
								<a href="../../../admin/adminmail/viewadminnews/"><button class="btn_2">Все новости администрации</button></a>
	</p>
	<?php if (empty ($messages))
		 {
			 echo '<p class = "for-info-txt" align = "center">Сообщения отсутствуют</p>';
		 }
		 
		 else
			 
		 foreach ($messages as $message): ?> 
		 <div class="task-pl">
			<div class="task-pl-header">
				<?php echo ($message['messagedate']. ' | Автор: <a href="../../../account/?id='.$message['idauthor'].'">'.$message['authorname']).'</a>';?>
				<p>E-mail: <?php echo $message['email'];?></p>			 
			</div>
			<div class="task-txt">
				<form action = " " method = "post" class = "del-mess">
					<input type = "hidden" name = "idmessage" value = "<?php echo $message['id']; ?>">
					<input type = "submit" name = "action" value = "X" class="btn_3">
		      	</form>
				<h5 class = "for-info-txt"><?php htmlecho ($message['messagetitle']); ?></h5>
				<p><?php echomarkdown (implode(' ', array_slice(explode(' ', strip_tags($message['text'])), 0, 50))); ?> [...]</p>
				<a href="../../../admin/adminmail/viewmessage/?id=<?php htmlecho ($message['id']); ?>"><button class="btn_2">Далее</button></a>
			</div>
		 </div>
		<?php endforeach; ?>

<?php 
/*Загрузка пагинации*/
include_once MAIN_FILE . '/pubcommonfiles/pagination.inc.php';?>
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>


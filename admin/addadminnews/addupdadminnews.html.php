<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
		<h2><?php htmlecho ($headMain); ?> | <a href="#" onclick="history.back();">Назад</a></h2>
		<div class = "main-headers-line"></div>
	</div>
</div>

<div class="m-content add-main-form">
<p class="for-info-txt"><strong><?php htmlecho($errorForm); ?></strong></p>	
	<form action = "?<?php htmlecho($action); ?> " method = "post">
	<table style="text-align: left;">
	 <div>
	  <tr>
		<th><label for = "author"> Автор:</label></th>
		<td>
		 <?php echo $authorMessage;?>
		</td>
	  </tr>
	 </div>
	<div>
	  <tr>
		<th><label for = "messagetitle">Введите заголовок </label></th>
		<td><input type = "messagetitle" name = "messagetitle" id = "messagetitle" value = "<?php htmlecho($messagetitle);?>"></td>
	  </tr>	
	</div>	
	 </table>
	 <div>
		<label for = "message"><strong>Введите текст сообщения:</strong></label><br>
		<textarea class = "descr mark-textarea" id = "message" name = "message" rows = "3" cols = "40"><?php htmlecho($text);?></textarea>	
	 </div>
	  <div>
		<input type = "hidden" name = "id" value = "<?php htmlecho($id); ?>">
		<input type = "submit" value = "<?php htmlecho($button); ?>" class="btn_2">
	  </div>	  
	</form>	
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	
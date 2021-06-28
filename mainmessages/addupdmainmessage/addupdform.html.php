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

<div class="m-content form-pl">
	<p class="error-log"><?php htmlecho($errorForm); ?></p>
	
	<form action = "?<?php htmlecho($action); ?> " method = "post" enctype="multipart/form-data" autocomplete="on">
	<table>
	  <tr>
		<td><strong> Автор:</strong></td>
		<td>
		 <?php echo $authorPost;?>
		</td>
	  </tr>
	  <tr>
		<td><strong>Загрузите файл изображения</strong><input type = "file" name = "upload" id = "upload"></td>
		<td><input type = "hidden" name = "action" value = "upload"></td>
	  </tr>		 
	</table>	
		<p><strong>Введите текст сообщения</strong></p>
		<textarea class = "descr" id = "text" name = "text" data-provide="markdown" rows="10"><?php htmlecho($text);?></textarea>	 
		<input type = "hidden" name = "idto" value = "<?php htmlecho($idto); ?>">
		<input type = "hidden" name = "id" value = "<?php htmlecho($id); ?>">
		<p><input type = "submit" value = "<?php htmlecho($button); ?>" class="btn_2 addit-btn">
		<a href="#" onclick="history.back();"><button type="button" class="btn_1 addit-btn">Назад</button></a></p>	
	</form>	
	<p><a name="bottom"></a></p>	
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	
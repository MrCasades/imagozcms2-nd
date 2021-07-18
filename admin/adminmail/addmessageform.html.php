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
<p class="for-info-txt"><strong><?php htmlecho($errorForm); ?></strong></p>	
	<form action = "?<?php htmlecho($action); ?> " method = "post">
		<label for = "messagetitle"><strong>Введите заголовок </strong></label>
		<br/><input type = "messagetitle" name = "messagetitle" id = "messagetitle" value = "<?php htmlecho($messagetitle);?>">
		<br/>
		<br/><label for = "message"><strong>Введите текст сообщения:</strong></label><br>
		<textarea class = "descr mark-textarea" id = "message" name = "message" rows="10"><?php htmlecho($text);?></textarea>	
	 <hr/>	
	  <div>
		<input type = "hidden" name = "id" value = "<?php htmlecho($id); ?>">
		<input type = "submit" value = "<?php htmlecho($button); ?>" class="btn_2">
	  </div>	  
	</form>
	<p><a name="bottom"></a></p>
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	
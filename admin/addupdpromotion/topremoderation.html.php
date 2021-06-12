<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>
	
	<div class = "maincont"> 
	 <div class = "post" align="center">
		<p>Отправить в премодерацию материал "<?php htmlecho($posttitle); ?>"?</p>
		<p><form action = "?<?php htmlecho($action); ?> " method = "post">
		  <input type = "hidden" name = "id" value = "<?php htmlecho($id); ?>">
          <input type = "hidden" name = "posttitle" value = "<?php htmlecho($posttitle); ?>">
		  <input type = "submit" name = "delete" class="btn btn-primary btn-sm" value = "<?php htmlecho($button); ?>">
          <a href='../viewalldraft/' class='btn btn-success btn-sm'>В черновик</a>
		</form></p>
	 </div>	 
	</div>	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
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

	  <div class = "maincont"> 
	   <div class = "post" align = "center">
		  <p><?php htmlecho($taskYes); ?> "<?php htmlecho($tasktitle); ?>"?</p>
		  <p>
		   <form action = "?<?php htmlecho($action); ?> " method = "post">
		     <input type = "hidden" name = "id" value = "<?php htmlecho($id); ?>">
		     <input type = "submit" name = "delete" class="btn btn-primary btn-sm" value = "<?php htmlecho($button); ?>">
	       </form>
	      </p>
	      <p><a href="#" onclick="history.back();" class="btn btn-primary btn-sm">Назад</a></p>
	   </div>
	</div>	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
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

<div class = "error-pl">
	<p class = "for-info-txt">Отправить в премодерацию материал "<?php htmlecho($posttitle); ?>"?</p>
		<p><form action = "?<?php htmlecho($action); ?> " method = "post">
		  <input type = "hidden" name = "id" value = "<?php htmlecho($id); ?>">
          <input type = "hidden" name = "posttitle" value = "<?php htmlecho($posttitle); ?>">
          <input type = "hidden" name = "price" value = "<?php htmlecho($price); ?>">
		  <input type = "submit" name = "delete" class="btn_2" value = "<?php htmlecho($button); ?>">
          <a href='../viewalldraft/'><button class='btn_1' type="button">В черновик</button></a>
		</form></p>
	 </div>	 
	</div>	
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
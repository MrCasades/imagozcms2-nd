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

<div class = "error-pl">
	<p class = "for-info-txt">Отправить в премодерацию материал "<?php htmlecho($posttitle); ?>"?</p>
		<p><form action = "?<?php htmlecho($action); ?> " method = "post">
		  <input type = "hidden" name = "id" value = "<?php htmlecho($id); ?>">
          <input type = "hidden" name = "posttitle" value = "<?php htmlecho($posttitle); ?>">
          <input type = "hidden" name = "price" value = "<?php htmlecho($price); ?>">
		  <input type = "submit" name = "delete" class="btn_2" value = "<?php htmlecho($button); ?>">
		  <?php if ($pubFolder != 'publication'):?>
			<a href='../viewalldraft/'><button class='btn_1' type="button">В черновик</button></a>
		  <?php else:?>
            <a href='//<?php htmlecho(MAIN_URL); ?>/blog/draft/?blid=<?php htmlecho($idBlog); ?>'><button class='btn_1' type="button">В черновик</button></a>
		  <?php endif;?>
		</form></p>
	 </div>	 
	</div>	
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
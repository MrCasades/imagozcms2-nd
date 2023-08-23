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

<div class="m-content">
<p class="for-info-txt"><strong><?php htmlecho($errorForm); ?></strong></p>
	
	<form action = "?<?php htmlecho($action); ?> " method = "post" enctype="multipart/form-data">
	<div>
	 <label for = "blogtitle">Введите заголовок <span style = "color: red"> *</span></label>
	 <br><input type = "blogtitle" name = "blogtitle" id = "blogtitle" value = "<?php htmlecho($blogtitle);?>">
	 <p><span id="counttitlelen">0</span> / 100	</p>
	</div>
	<hr/>
	<div>
	    <h3>Выберете файл изображения для шапки</h3>
		<input type = "file" name = "upload" id = "upload">
		<input type = "hidden" name = "action" value = "upload">
	</div>
	<hr/>
	<div>
	    <h3>Выберете файл изображения для аватара</h3>
		<input type = "file" name = "uploadavatar" id = "uploadavatar">
		<input type = "hidden" name = "action" value = "uploadavatar">
	</div>
	<hr/>
	<div>
		<label for = "description">Добавьте описание своего блога</label><br>
		<textarea class = "mark-textarea" id = "description" name = "description" rows="10"><?php htmlecho($description);?></textarea>	
	 </div>
	 <hr/>
	 <p style="color: red"><strong>Прежде чем создать блог, ознакомьтесь с правилами. Их несоблюдение может привести к удалению блога и блокировке учётной записи!</strong></p>
	 <input type="checkbox" name="iagree" value="iagree" id="iagree"> Я ознакомился с правилами
	 <hr/>
	  <div>
		<input type = "hidden" name = "id" value = "<?php htmlecho($id); ?>">
		<input type = "submit" value = "<?php htmlecho($button); ?>" class="btn_2" id="confirm">
	  </div>	  
	</form>	
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	
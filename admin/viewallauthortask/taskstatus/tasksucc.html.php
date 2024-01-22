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
	<p class="for-info-txt">
		Вы успешно взяли задание! Перейдите в раздел "Мои задания" в профиле, для того, чтобы выполнить его.
	</p>
	<a href="/admin/viewallauthortask/" class="btn btn-primary btn-sm">К заданиям.</a>
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
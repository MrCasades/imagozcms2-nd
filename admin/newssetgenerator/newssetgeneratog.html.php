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

<div class = "m-content">
    <form id="generate_form">
        Дата от: <input type="date" id="dt1" name="dt1"> до <input type="date" id="dt2" name="dt2">
        <input type = "hidden" value = "<?php htmlecho ($authorInSystem); ?>" name="authorname">
        <button id="generate" class="btn_2" type="button">Сгенерировать</button>
    </form>
    <br><div id="succ_form"></div>
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
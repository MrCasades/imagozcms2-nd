<?php
/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
		<h2><?php htmlecho ($headMain); ?> | <a href="#" onclick="history.back();">Назад</a></h2>
		<div class = "main-headers-line"></div>
	</div>
</div>

<div class="m-content addupd-post">
	<button id="sitemap" class="btn_2 rss_btn" value = "sitemap">Обновить карту сайта</button>	
	<button id="rsssmi" class="btn_2 rss_btn" value = "rsssmi">Обновить ленту СМИ</button>
	<button id="rsspulse" class="btn_2 rss_btn">Обновить ленту Пульс</button>
	<button id="rssvk" class="btn_2 rss_btn">Обновить ленту VK</button>
</div>
<div id="result"></div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
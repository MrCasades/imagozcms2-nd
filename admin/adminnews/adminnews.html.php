<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
    <a class = "main-headers-place" href="./admin/adminmail/viewadminnews/"><h2>Новости администрации</h2></a>
		<div class = "main-headers-line"></div>
	</div>
</div>

<div class="adm-news-pl m-content">
    <h3 class="for-info-txt"><?php htmlecho($messageDate); ?> | <?php htmlecho($messageTitle); ?></h3>
	<p><?php echomarkdown (implode(' ', array_slice(explode(' ', strip_tags($messageText)), 0, 50))); ?> [...]</p>
	<p><a href="./admin/adminmail/viewnews/?idadminnews=<?php echo $idnews; ?>"><button class="btn_2">Подробнее</button></a></p>
</div>

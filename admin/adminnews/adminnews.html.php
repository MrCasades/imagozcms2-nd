<div class = "main-headers">
    <div class = "headers-places"> 
        <a class = "main-headers-place" href="./admin/adminmail/viewadminnews/"><h3>Новости администрации</h3></a>
    </div>
    <div class = "main-headers-line"></div>
</div>

<div class="adm-news-pl m-content">
    <h3 class="for-info-txt"><?php htmlecho($messageDate); ?> | <?php htmlecho($messageTitle); ?></h3>
	<p><?php echomarkdown (implode(' ', array_slice(explode(' ', strip_tags($messageText)), 0, 50))); ?> [...]</p>
	<p><a href="./admin/adminmail/viewnews/?idadminnews=<?php echo $idnews; ?>"><button class="btn_2">Подробнее</button></a></p>
</div>

<div class = "main-headers">
	<div class = "headers-places"> 
		<div class = "main-headers-txtplace"><h2>Новости администрации</h2></div>
	</div>
	<div class = "main-headers-line"></div>
</div>

<div class="adm-news-pl m-content">
    <h3 class="for-info-txt"><?php htmlecho($messageDate); ?> | <?php htmlecho($messageTitle); ?></h3>
    <?php echomarkdown($messageText); ?>
</div>

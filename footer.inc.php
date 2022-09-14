
  </main>

  <footer>
  	<div class="header-line"></div>
	<div class="footer">
		<?php 
			/*Загрузка главного меню*/
			include MAIN_FILE . '/mainmenu/mainmenu.inc.php'; ?>

		<p><a href="<?php echo '//'.MAIN_URL;?>/sitemap/">Карта сайта</a>
			<a href="<?php echo '//'.MAIN_URL;?>/cooperation/">Сотрудничество</a>
			<a href="<?php echo '//'.MAIN_URL;?>/promotion/">Промоушен</a>
		</p>
		<p>Copyright © 2019-2021 MrCasades. All rights reserved.</p>
	</div>
	<div class="counts">
		  
	</div>
  </footer>	
			
    <script src="<?php echo '//'.MAIN_URL.'/anime.min.js';?>"></script>
    <script src="<?php echo '//'.MAIN_URL.'/OwlCarousel/dist/owl.carousel.min.js';?>"></script>
	<script src="<?php echo '//'.MAIN_URL.'/script-nd2.js';?>"></script>	
	<script src="<?php echo '//'.MAIN_URL.'/Trumbowyg-main/dist/trumbowyg.min.js';?>"></script>
	<script src="<?php echo '//'.MAIN_URL.'/Trumbowyg-main/dist/plugins/emoji/trumbowyg.emoji.min.js';?>"></script>
	<script src="<?php echo '//'.MAIN_URL.'/Trumbowyg-main/dist/plugins/upload/trumbowyg.upload.min.js';?>"></script>

	<?php 
		//Дополнительный код
		echo $scriptJScode = $scriptJScode ?? ''; ?>		

</body>
</html>	
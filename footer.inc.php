
  </main>

  <footer>
  	<div class="header-line"></div>
	  	<?php if ($data_common['mainmenu_foot'] == "on"):?>
			<div class="foot-menu">
				<?php 
					/*Загрузка главного меню*/
					include MAIN_FILE . '/mainmenu/mainmenu.inc.php'; ?>
			</div>
		<?php endif;?>

		<?php if ($data_common['difflinks_foot'] == "on")
			/*Загрузка ссылок шапки*/
			include_once MAIN_FILE . '/includes/diffblocks/difflinksfooter.inc.html.php';
		?>
		<p>Copyright © 2019-2021 MrCasades. All rights reserved.</p>
	<div class="counts">
		  
	</div>
  </footer>	
			
    <script src="<?php echo '//'.MAIN_URL.'/anime.min.js';?>"></script>
    <script src="<?php echo '//'.MAIN_URL.'/OwlCarousel/dist/owl.carousel.min.js';?>"></script>
	<script src="<?php echo '//'.MAIN_URL.'/scripts.js';?>"></script>	
	<script src="<?php echo '//'.MAIN_URL.'/Trumbowyg-main/dist/trumbowyg.min.js';?>"></script>
	<script src="<?php echo '//'.MAIN_URL.'/Trumbowyg-main/dist/plugins/emoji/trumbowyg.emoji.min.js';?>"></script>
	<script src="<?php echo '//'.MAIN_URL.'/Trumbowyg-main/dist/plugins/upload/trumbowyg.upload.min.js';?>"></script>

	<?php 
		//Дополнительный код
		echo $scriptJScode = $scriptJScode ?? ''; ?>		

</body>
</html>	
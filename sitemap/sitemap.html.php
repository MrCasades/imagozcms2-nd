<?php 

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "maincont_for_view">
	<div align = "center" ><script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
	<script src="//yastatic.net/share2/share.js"></script>
	<div class="ya-share2" data-services="collections,vkontakte,facebook,odnoklassniki,moimir,twitter,lj"></div></div>
<div class = "post">
 <div class = "posttitle"><h6>Рубрики</h6></div>
	 <?php if (!isset($categorysSM))
		 {
			 $noPosts = '<p align = "center">Нет категорий</p>';
			 echo $noPosts;
			 $categorysSM = null;
		 }
		 
		 else
		
		foreach ($categorysSM as $category): ?> 
		  
		<div>  
			<a href="../viewcategory/?id=<?php echo $category['id']; ?>"> <strong><?php echomarkdown ($category['category']); ?></strong></a> 	
		</div>	   	
		<?php endforeach; ?> 
		<p><a href="../cooperation/"> <strong>Сотрудничество</strong></a></p>
	    <p><a href="../promotion/"> <strong>Промоушен</strong></a></p>
	    <p><a href="../admin/adminmail/?addmessage"> <strong>Обратная связь</strong></a></p>
</div>		

<div class = "post">	 
 <div class = "posttitle"><h6>Новости</h6></div>
	 <?php if (!isset($newsInSM))
		 {
			 $noPosts = '<p align = "center">Новости отсутствуют</p>';
			 echo $noPosts;
			 $newsInSM = null;
		 }
		 
		 else
			 
		 foreach ($newsInSM as $news): ?> 
		  
			<div>
				<a href="../viewnews/?id=<?php htmlecho ($news['id']); ?>"><?php htmlecho ($news['newstitle']); ?></a>  
			</div>			
		 <?php endforeach; ?>
</div>

<div class = "post">		 
 <div class = "posttitle"><h6>Статьи</h6></div>
	 <?php if (!isset($postsSM))
		 {
			 $noPosts = '<p align = "center">Статьи отсутствуют</p>';
			 echo $noPosts;
			 $postsSM = null;
		 }
		 
		 else
			 
		 foreach ($postsSM as $post): ?> 
		  
			<div>
				<a href="../viewpost/?id=<?php htmlecho ($post['id']); ?>"><?php htmlecho ($post['posttitle']); ?></a>  
			</div>			
		 <?php endforeach; ?>
</div>		 
</div>		 
		 
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>		 
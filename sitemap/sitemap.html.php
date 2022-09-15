<?php 

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-content">
		<h2><?php htmlecho ($headMain); ?></h2>
	</div>
</div>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
		<h2>Рубрики</h2>
		<div class = "main-headers-line"></div>
	</div>
</div>

<div class="m-content">
	<?php if (empty ($categorysSM))
	{ 
		echo '<p>Нет категорий</p>';
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

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
		<a class = "main-headers-place" href="../viewallnews/"><h2>Новости</h2></a>
		<div class = "main-headers-line"></div>
		<div class = "sub-header"><?php htmlecho ($subHeaderNews); ?></div>
	</div>
</div>

<div class="m-content">
	<?php if (empty($newsInSM))
	{
		echo '<p>Новости отсутствуют</p>';
	}
		 
	else
			 
	foreach ($newsInSM as $news): ?> 
		  
	<div>
		<a href="../viewnews/?id=<?php htmlecho ($news['id']); ?>"><?php htmlecho ($news['newstitle']); ?></a>  
	</div>			
	<?php endforeach; ?>
</div>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
		<a class = "main-headers-place" href="../viewallpromotion/"><h2>Промоушен</h2></a>
		<div class = "main-headers-line"></div>
		<div class = "sub-header"><?php htmlecho ($subHeaderPromotion); ?></div>
	</div>
</div>

<div class="m-content">

	<?php if (empty($promotionsSM))
	{
		echo '<p>Статьи отсутствуют</p>';
	}
		 
	else
			 
	foreach ($promotionsSM as $promotion): ?> 
		  
	<div>
		<a href="../viewpromotion/?id=<?php htmlecho ($promotion['id']); ?>"><?php htmlecho ($promotion['promotiontitle']); ?></a>  
	</div>			
	<?php endforeach; ?>
</div>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
		<a class = "main-headers-place" href="../viewallposts/"><h2>Статьи</h2></a>
		<div class = "main-headers-line"></div>
		<div class = "sub-header"><?php htmlecho ($subHeaderPost); ?></div>
	</div>
</div>

<div class="m-content">

	<?php if (empty($postsSM))
	{
		echo '<p>Статьи отсутствуют</p>';
	}
		 
	else
			 
	foreach ($postsSM as $post): ?> 
		  
	<div>
		<a href="../viewpost/?id=<?php htmlecho ($post['id']); ?>"><?php htmlecho ($post['posttitle']); ?></a>  
	</div>			
	<?php endforeach; ?>
</div>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
		<a class = "main-headers-place" href="../viewallvideos/"><h2>Видео</h2></a>
		<div class = "main-headers-line"></div>
		<div class = "sub-header"><?php htmlecho ($subHeaderVideo); ?></div>
	</div>
</div>

<div class="m-content">

	<?php if (empty($videossSM))
	{
		echo '<p>Видео отсутствуют</p>';
	}
		 
	else
			 
	foreach ($videossSM as $videos): ?> 
		  
	<div>
		<a href="../video/?id=<?php htmlecho ($videos['id']); ?>"><?php htmlecho ($videos['videotitle']); ?></a>  
	</div>			
	<?php endforeach; ?>
</div>
		 
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>		 
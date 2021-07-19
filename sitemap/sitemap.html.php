<?php 

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?></h1></div>
    </div>
</div>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace">Рубрики</div>
    </div>
    <div class = "main-headers-line"></div>
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
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace">Новости</div>
    </div>
    <div class = "main-headers-line"></div>
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
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace">Статьи</div>
    </div>
    <div class = "main-headers-line"></div>
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
		 
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>		 
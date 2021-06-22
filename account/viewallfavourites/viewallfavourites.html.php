<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?></h1></div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<div class = "main-post m-content">
	<?php if (empty($favourites))
	 {
		echo '<p align = "center">Статьи отсутствуют</p>';
		$favourites = '';
	 }
		 
	 else
			 
	 foreach ($favourites as $favourite): ?>
    <a href="<?php htmlecho ($favourite['url']); ?>" class = "post-place-2" style="background-image: url(../../images/<?php echo $favourite['imghead']; ?>)">
        <div class = "post-top-1">
            <p><?php echo date("Y.m.d H:i", strtotime($favourite['date'])); ?></p>
			<span class="post-rubrics"><?php htmlecho ($favourite['categoryname']); ?></span>
        </div>
        <div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($favourite['title'])), 0, 7)))); ?>...</div>
	</a>
		
	<?php endforeach; ?>
	
</div>

<div class="page-output">	
		 <?php
			/*Постраничный вывод информации*/
			for ($i = 1; $i <= $pagesCount; $i++) 
			{
				// если текущая старница
				if($i == $page)
				{
					echo "<a href='index.php?page=$i&id=$idAuthor'><button class='btn_2'>$i</button></a> ";
				} 
				else 
				{
					echo "<a href='index.php?page=$i&id=$idAuthor'><button class='btn_1'>$i</button></a> ";
				}
			}?>
</div>	
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>

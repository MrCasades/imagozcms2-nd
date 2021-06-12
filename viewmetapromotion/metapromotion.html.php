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
		<?php if (empty($metas_1))
		{
			echo '<p align = "center">Статьи отсутствуют</p>';
		}
				
		else
					
		foreach ($metas_1 as $meta_1): ?>
		<a href="../viewpromotion/?id=<?php htmlecho ($meta_1['id']); ?>" class = "post-place-2" style="background-image: url(../images/<?php echo $meta_1['imghead']; ?>)">
			<div class = "post-top-1">
				<p><?php echo date("Y.m.d H:i", strtotime($meta_1['promotiondate'])); ?></p>
				<span class="post-rubrics"><?php htmlecho ($meta_1['categoryname']); ?></span>
			</div>
			<div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($meta_1['promotiontitle'])), 0, 7)))); ?>...</div>
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
						echo "<a href='index.php?page=$i&metaid=$idMeta'><button class='btn_2'>$i</button></a> ";
					} 
					else 
					{
						echo "<a href='index.php?page=$i&metaid=$idMeta'><button class='btn_1'>$i</button></a> ";
					}
				}?>
	</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
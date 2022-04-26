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
		<?php if (empty($videos))
		{
			echo '<p align = "center">Видео отсутствуют</p>';
		}
				
		else
					
		foreach ($videos as $video): ?>
		<a href="../video/?id=<?php htmlecho ($video['id']); ?>" class = "post-place-2" style="background-image: url(../images/<?php echo $video['imghead']; ?>)">
			<div class = "post-top-1">
				<p><?php echo date("Y.m.d H:i", strtotime($video['videodate'])); ?></p>
			</div>
			<div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($video['videotitle'])), 0, 7)))); ?>...</div>
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
						echo "<a href='index.php?page=$i&id=$idCategory'><button class='btn_2'>$i</button></a> ";
					} 
					else 
					{
						echo "<a href='index.php?page=$i&id=$idCategory'><button class='btn_1'>$i</button></a> ";
					}
				}?>
	</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
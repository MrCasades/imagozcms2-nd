<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

	<div class = "main-headers">
		<div class = "main-headers-circle"></div>
		<div class = "main-headers-content">
			<h2><?php htmlecho ($headMain); ?></h2>
			<div class = "main-headers-line"></div>
			<div class = "sub-header"><?php htmlecho ($subHeaderPost); ?></div>
		</div>
	</div>

	<div class = "main-post m-content">
		<?php if (empty($metas_1))
		{
			echo '<p align = "center">Статьи отсутствуют</p>';
		}
			
		else
				
		foreach ($metas_1 as $meta_1): ?>
		<a href="//<?php htmlecho (MAIN_URL); ?>/blog/publication/?id=<?php htmlecho ($meta_1['id']); ?>" class = "post-place-2" style="background-image: url(//<?php htmlecho (MAIN_URL); ?>/images/<?php echo $meta_1['imghead']; ?>)">
			<div class = "post-top-1">
				<p><?php echo date("Y.m.d H:i", strtotime($meta_1['date'])); ?></p>
				
			</div>
			<div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($meta_1['title'])), 0, 7)))); ?>...</div>
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
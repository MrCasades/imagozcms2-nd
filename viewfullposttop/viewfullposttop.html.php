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
		<?php if (empty($posts))
		{
			echo '<p align = "center">Статьи отсутствуют</p>';
		}
			
		else
				
		foreach ($posts as $post): ?>
		<a href="../viewpost/?id=<?php htmlecho ($post['id']); ?>" class = "post-place-2" style="background-image: url(../images/<?php echo $post['imghead']; ?>)">
			<div class = "post-top-1">
				<p><?php echo date("Y.m.d H:i", strtotime($post['postdate'])); ?></p>
				<div class="article-rating">
                    <i class="fa fa-eye" aria-hidden="true" title="Просмотры"></i> <?php htmlecho ($post['viewcount']); ?> 
				    <i class="fa fa-heartbeat" aria-hidden="true" title="Оценка"></i> <?php htmlecho ($post['averagenumber']); ?>
                </div>
			</div>
			<div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($post['posttitle'])), 0, 7)))); ?>...</div>
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
						echo "<a href='index.php?page=$i'><button class='btn_2'>$i</button></a> ";
					} 
					else 
					{
						echo "<a href='index.php?page=$i'><button class='btn_1'>$i</button></a> ";
					}
				}?>	
	</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>

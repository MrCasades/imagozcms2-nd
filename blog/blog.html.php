<?php 

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<article>
	<div class="article-row">
		<div class="left-side">
			<div class = "main-headers">
				<div class = "main-headers-circle"></div>
				<div class = "main-headers-content">
					<a href = "../viewallnews/"><h2>Блог</h2></a>
					<div class = "main-headers-line"></div>
					<div class = "sub-header"><?php htmlecho ($subHeaderNews); ?></div>
				</div>
			</div>
			<div class = "article-head m-content" style="background-image: url(../blog/headersimages/<?php echo $imgHead; ?>)">
				<!-- <div class = "article-head-top"> 
					<div class ="article-info">
						<p><span class="post-rubrics"><a href="../viewcategory/?id=<?php echo $categoryId; ?>"><?php echo $categoryName;?></a></span></p>
					</div>
				<div class="article-rating">
						<i class="fa fa-eye" aria-hidden="true" title="Просмотры"></i> <?php htmlecho ($viewCount); ?>  
						<i class="fa fa-heartbeat" aria-hidden="true" title="Оценка"></i> <?php htmlecho (round($averageNumber, 2, PHP_ROUND_HALF_DOWN)); ?>
						<i class="fa fa-check-square-o" aria-hidden="true" title="Добавили в избранное"></i> <?php htmlecho ($favouritesCount); ?>
				</div> -->
			</div>
			
			</div>
			<h1 class="m-content"><?php htmlecho ($headMain); ?></h1>
			<!-- <div class="article-head-bottom m-content">
				<a href="../account/?id=<?php echo $authorId;?>"><?php echo $nameAuthor;?></a>
				<br><?php echo $date;?>
			</div> -->
			<!-- <div class="tags-place-m m-content"> 
				<?php if (empty($metas))
				{
					echo '';
				}
						
				else
						
				foreach ($metas as $meta): ?> 
					
					<a href="../viewallmetas/?metaid=<?php echo $meta['id']; ?>"><?php echomarkdown ($meta['metaname']); ?></a>
						
				<?php endforeach; ?>

			</div> -->

				<!-- <div class="m-content">
					Место для рекламы
				</div> -->

				
		<div class="right-side">

			<!-- <div class="zen-c-m">
				<div class = "main-headers">
					<div class = "main-headers-content">
						<h2 class="no-link-header">Наш Дзен-канал</h2>
						<div class = "main-headers-line"></div>				
					</div>
				</div>
				<div class="zen-link-m">
					<a href="https://zen.yandex.ru/imagoz"><img src="./zen-icon.png" alt="Наш Дзен-канал" title="zen.yandex.ru/imagoz"></a>
				</div>
			</div> -->
		</div>
	</div>
</article>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
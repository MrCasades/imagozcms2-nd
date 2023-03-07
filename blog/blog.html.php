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
					<h2><?php echo $blogTitle;?></h2>
					<div class = "main-headers-line"></div>
				</div>
			</div>

			<div class="blog-m m-content">	
				<div class="blog-ava-pl">				
					<?php if ($avatar !== ''): ?>
						<img src="../avatars/<?php echo $avatar;?>" alt="<?php echo $authorName;?>">
					<?php else: ?>
						<i class="fa fa-user-circle" aria-hidden="true" title="Аватар блога"></i>
					<?php endif; ?>
					<?php echo $editBlog; ?>
				</div> 
				<div class="blog-info-pl">
		
					<h3 class="acc-header">Инфо</h3>
					<?php if ($blogDescr != ''): ?>
						<div>
							<?php echomarkdown ($blogDescr);?>
						</div>
					<?php endif;?>							
				</div>   
			</div> 
			
			<!-- <div class = "article-head m-content" style="background-image: url(../blog/headersimages/<?php echo $imgHead; ?>)">

			</div> -->
			
		</div>
		<h1 class="m-content"><?php htmlecho ($headMain); ?></h1>
			

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
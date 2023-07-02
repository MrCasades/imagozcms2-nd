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
						<img src="../blog/avatars/<?php echo $avatar;?>" alt="avatar">
					<?php else: ?>
						<i class="fa fa-user-circle" aria-hidden="true" title="Аватар блога"></i>
					<?php endif; ?>
					<?php echo $editBlog; ?>
					<?php echo $addPublication; ?>
					<?php echo $toDraft; ?>
				</div> 
				<div class="blog-info-pl">
		
					<h3 class="acc-header">Инфо</h3>
					<?php if ($blogDescr != ''): ?>
						<div>
							<?php echomarkdown ($blogDescr);?>
						</div>
					<?php endif;?>							
				</div>
				
				<?php if (!empty ($newsIn)): ?>

				<div class = "main-headers">
					<div class = "main-headers-circle"></div>
					<div class = "main-headers-content">
					<a class = "main-headers-place" href = "../account/allauthornews/?id=<?php htmlecho ($idAuthor); ?>"><h2>Новости автора</h2></a>
						<div class = "main-headers-line"></div>
					</div>
				</div>

				<?php endif; ?>

				<div class = "main-post">
					<?php  if (empty ($newsIn))
						{
							echo '<p>Автор не написал ни одной новости</p>';
						}
						
						else

						foreach ($newsIn as $news): ?>
						
						<a href="../viewnews/?id=<?php htmlecho ($news['id']); ?>" class = "post-place-2" style="background-image: url(../images/<?php echo $news['imghead']; ?>)">
							<div class = "post-top-1">
								<span class="post-rubrics"><?php htmlecho ($news['categoryname']); ?></span>
							</div>
							<div class = "post-bottom-1">
								<span class="post-header-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($news['newstitle'])), 0, 7)))); ?>...</span>
								<br><span class="post-date-1"><?php echo date("Y.m.d H:i", strtotime($news['newsdate'])); ?></span>
							</div>
						</a>

					<?php endforeach; ?>
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
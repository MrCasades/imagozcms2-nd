<?php 

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<main>
	<div class="article-row">
		<div class="left-side">
			<div class="blog-m m-content">	
				<div class="blog-ava-pl">
					<?php echo $delBlog; ?>				
					<?php if ($avatar !== ''): ?>
						<img src="../blog/avatars/<?php echo $avatar;?>" alt="avatar">
					<?php else: ?>
						<i class="fa fa-user-circle" aria-hidden="true" title="Аватар блога"></i>
					<?php endif; ?>
					<br>
					<strong>Подписчики: <?php echo $subscriptionCount; ?></strong>
					<?php echo $subskribe; ?>
					<?php echo $editBlog; ?>
					<?php echo $addPublication; ?>
					<?php echo $toDraft; ?>
					<?php echo $indexBlog; ?>
					<?php echo $premodBlog; ?>
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

			<?php if (!empty ($pubs)): ?>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
		<h2>Недавние публикации блога</h2>
		<div class = "main-headers-line"></div>
	</div>
</div>

<?php endif; ?>

<div class = "main-post">
	<?php  if (empty ($pubs))
		{
			echo '<p>Автор ничего не опубликовал</p>';
		}
		
		else

		foreach ($pubs as $pub): ?>
		
		<a href="./publication/?id=<?php htmlecho ($pub['id']); ?>" class = "post-place-2" style="background-image: url(../images/<?php echo $pub['imghead']; ?>)">
			<div class = "post-top-1">
				<span class="post-rubrics"><?php htmlecho ($pub['categoryname']); ?></span>
			</div>
			<div class = "post-bottom-1">
				<span class="post-header-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($pub['title'])), 0, 7)))); ?>...</span>
				<br><span class="post-date-1"><?php echo date("Y.m.d H:i", strtotime($pub['date'])); ?></span>
			</div>
		</a>

	<?php endforeach; ?>
</div>
			
			<!-- <div class = "article-head m-content" style="background-image: url(../blog/headersimages/<?php echo $imgHead; ?>)">

			</div> -->
			
		</div>
		
			

				<!-- <div class="m-content">
					Место для рекламы
				</div> -->

				
		<div class="right-side">
		<?php
			/*Загрузка компонента последних публикаций блогов*/
			include_once MAIN_FILE . '/blog/blogspublicationinrightside/blogspublicationinrightside.inc.php';?>
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
	</main>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
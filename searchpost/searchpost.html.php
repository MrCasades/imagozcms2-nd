<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';?>

<?php if (empty($posts) && empty($newsIn) && empty($promotions) && empty($pubs) && empty($blogs)): ?>

	<p class = "for-info-txt">Поиск не дал результата</p>

<?php endif;?>

<?php if (isset ($posts)):?>

	<?php foreach ($posts as $post): ?>

		<a href="//<?php htmlecho (MAIN_URL); ?>/viewpost/?id=<?php htmlecho ($post['id']); ?>"><h3><?php htmlecho ($post['posttitle']); ?></h3></a>
		<p>Рубрика: <a href="//<?php htmlecho (MAIN_URL); ?>/viewcategory/?id=<?php echo $post['categoryid']; ?>"><?php echo $post['categoryname'];?></a></p>
		<p><?php echomarkdown (implode(' ', array_slice(explode(' ', strip_tags($post['text'])), 0, 50))); ?> [...]</p>
	<?php endforeach; ?>

<?php elseif (isset ($newsIn)):?>

	<?php foreach ($newsIn as $news): ?>

		<a href="//<?php htmlecho (MAIN_URL); ?>/viewnews/?id=<?php htmlecho ($news['id']); ?>"><h3><?php htmlecho ($news['newstitle']); ?></h3></a>
		<p>Рубрика: <a href="//<?php htmlecho (MAIN_URL); ?>/viewcategory/?id=<?php echo $news['categoryid']; ?>"><?php echo $news['categoryname'];?></a></p>
		<p><?php echomarkdown (implode(' ', array_slice(explode(' ', strip_tags($news['textnews'])), 0, 50))); ?> [...]</p>
	<?php endforeach; ?>

<?php elseif (isset ($promotions)):?>

	<?php foreach ($promotions as $promotion): ?>

		<a href="//<?php htmlecho (MAIN_URL); ?>/viewpromotion/?id=<?php htmlecho ($promotion['id']); ?>"><h3><?php htmlecho ($promotion['promotiontitle']); ?></h3></a>
		<p>Рубрика: <a href="//<?php htmlecho (MAIN_URL); ?>/viewcategory/?id=<?php echo $promotion['categoryid']; ?>"><?php echo $promotion['categoryname'];?></a></p>
		<p><?php echomarkdown (implode(' ', array_slice(explode(' ', strip_tags($promotion['text'])), 0, 50))); ?> [...]</p>
	<?php endforeach; ?>

<?php elseif (isset ($pubs)):?>

			<div class = "main-headers">
				<div class = "main-headers-circle"></div>
				<div class = "main-headers-content">
					<h2>Результат поиска</h2>
					<div class = "main-headers-line"></div>				
				</div>
			</div>
		
			<div class = "newsblock m-content">			 
				<?php foreach ($pubs as $pub): ?> 
				<a href = "//<?php htmlecho (MAIN_URL); ?>/blog/publication?id=<?php htmlecho ($pub['id']); ?>" class = "post-place-1" style="background-image: url(../images/<?php echo $pub['imghead']; ?>)">
					<div class = "post-top-1">
						<p><?php echo date("Y.m.d H:i", strtotime($pub['date'])); ?></p>
						<span class="post-rubrics"><?php htmlecho ($pub['categoryname']); ?></span>
					</div>
					<div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($pub['title'])), 0, 7)))); ?>...</div>
				</a>
				<?php endforeach; ?>
			</div>

<?php elseif (isset ($blogs)):?>

	<div class = "main-headers">
		<div class = "main-headers-circle"></div>
		<div class = "main-headers-content">
			<h2>Поиск блогов</h2>
			<div class = "main-headers-line"></div>				
		</div>
	</div>

	<div class = "main-post m-content">
		<?php foreach ($blogs as $blog): ?>
			<a href="//<?php htmlecho (MAIN_URL); ?>/blog/?id=<?php htmlecho ($blog['id']); ?>" class = "post-place-2" style="background-image: url(//<?php htmlecho (MAIN_URL); ?>/blog/avatars/<?php echo $blog['avatar']; ?>)">				
				<div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($blog['title'])), 0, 7)))); ?>...</div>
			</a>
				
		<?php endforeach; ?>
	</div>

<?php endif;?>

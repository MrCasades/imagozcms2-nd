<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';?>

<?php if (empty($posts) && empty($newsIn) && empty($promotions)): ?>

	<p>Поиск не дал результата</p>

<?php endif;?>

<?php if (isset ($posts)):?>

	<?php foreach ($posts as $post): ?>

		<a href="../viewpost/?id=<?php htmlecho ($post['id']); ?>"><h3><?php htmlecho ($post['posttitle']); ?></h3></a>
		<p>Рубрика: <a href="../viewcategory/?id=<?php echo $post['categoryid']; ?>"><?php echo $post['categoryname'];?></a></p>
		<p><?php echomarkdown (implode(' ', array_slice(explode(' ', strip_tags($post['text'])), 0, 50))); ?> [...]</p>
	<?php endforeach; ?>

	<?php elseif (isset ($newsIn)):?>

		<?php foreach ($newsIn as $news): ?>

		<a href="../viewnews/?id=<?php htmlecho ($news['id']); ?>"><h3><?php htmlecho ($news['newstitle']); ?></h3></a>
		<p>Рубрика: <a href="../viewcategory/?id=<?php echo $news['categoryid']; ?>"><?php echo $news['categoryname'];?></a></p>
		<p><?php echomarkdown (implode(' ', array_slice(explode(' ', strip_tags($news['textnews'])), 0, 50))); ?> [...]</p>
	<?php endforeach; ?>

	<?php elseif (isset ($promotions)):?>

	<?php foreach ($promotions as $promotion): ?>

		<a href="../viewpromotion/?id=<?php htmlecho ($promotion['id']); ?>"><h3><?php htmlecho ($promotion['promotiontitle']); ?></h3></a>
		<p>Рубрика: <a href="../viewcategory/?id=<?php echo $promotion['categoryid']; ?>"><?php echo $promotion['categoryname'];?></a></p>
		<p><?php echomarkdown (implode(' ', array_slice(explode(' ', strip_tags($promotion['text'])), 0, 50))); ?> [...]</p>
	<?php endforeach; ?>

<?php endif;?>

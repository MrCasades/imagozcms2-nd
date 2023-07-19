<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
		<h2><?php htmlecho ($headMain); ?> | <a href="#" onclick="history.back();">Назад</a></h2>
		<div class = "main-headers-line"></div>
		<div class = "sub-header"></div>
	</div>
</div>

<div class = "main-post m-content">
		<?php if (empty($pubs))
		{
			echo '<p>Статьи отсутствуют</p>';
		}
				
		else
					
		foreach ($pubs as $pub): ?>
		<a href="./viewdraftpublication/?id=<?php htmlecho ($pub['pubid']); ?>" class = "post-place-2" style="background-image: url(../../images/<?php echo $pub['imghead']; ?>)">
			<div class = "post-top-1">
				<p><?php echo date("Y.m.d H:i", strtotime($pub['date'])); ?></p>
			</div>
			<div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($pub['title'])), 0, 7)))); ?>...</div>
		</a>
			
		<?php endforeach; ?>			
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>		
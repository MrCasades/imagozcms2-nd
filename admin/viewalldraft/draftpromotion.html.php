<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-post m-content">
		<?php if (empty($promotions))
		{
			echo '<p>Статьи отсутствуют</p>';
		}
				
		else
					
		foreach ($promotions as $promotion): ?>
		<a href="./viewdraftpromotion/?id=<?php htmlecho ($promotion['id']); ?>" class = "post-place-2" style="background-image: url(../../images/<?php echo $promotion['imghead']; ?>)">
			<div class = "post-top-1">
				<p><?php echo date("Y.m.d H:i", strtotime($promotion['promotiondate'])); ?></p>
				<span class="post-rubrics"><?php htmlecho ($promotion['categoryname']); ?></span>
			</div>
			<div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($promotion['promotiontitle'])), 0, 7)))); ?>...</div>
		</a>
			
		<?php endforeach; ?>			
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>		
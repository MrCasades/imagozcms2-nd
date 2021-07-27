<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?> | <a href="#" onclick="history.back();">Назад</a></h1></div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<div class="m-content">
	<div>
		<h3>Статьи</h3>
			
		<?php if (empty ($posts))
		{ 
			echo '<p>Материалы отсутствуют</p>';
		}
			
		else
			
		foreach ($posts as $post): ?> 
				<div>
					<h3><?php echo $post['postdate'];?> <?php echo $post['posttitle'];?></h3>		  	
				</div> 			
			<?php endforeach; ?> 
	</div>	
			
	<hr/>
	<div>
		<h3>Новости</h3>
			
		<?php if (empty ($newsIn))
		{ 
			echo '<p>Материалы отсутствуют</p>';
		}
			
		else
			
		foreach ($newsIn as $news): ?> 
				<div>
					<h3><?php echo $news['newsdate'];?> | <?php echo $news['newstitle'];?></h3>		  	
				</div> 			
			<?php endforeach; ?> 
	</div>	
			
	<hr/>
	<div>
		<h3>Промоушен</h3>
			
		<?php if (empty ($promotions))
		{ 
			echo '<p>Материалы отсутствуют</p>';
		}
			
		else
			
		foreach ($promotions as $promotion): ?> 

				<div>
					<h3><?php echo $promotion['promotiondate'];?> | <?php echo $promotion['promotiontitle'];?></h3>		  	
				</div> 			
			<?php endforeach; ?> 
	</div>	
	<p><a name="bottom"></a></p>
</div>
		
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>		
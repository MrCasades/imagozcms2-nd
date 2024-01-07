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
	</div>
</div>

<div class="m-content">
<div>
	<h3>Промоушен</h3>
		  
	<?php if (empty ($promotions))
	{ 
		echo '<p>Материалы отсутствуют</p>';
	}
		 
	else
		  
	foreach ($promotions as $promotion): ?> 
		<div>		
			<h3><?php echo $promotion['promotiondate']. '</a>';?> | <?php echo $promotion['promotiontitle'];?></h3>		  	
		</div>			
	<?php endforeach; ?> 
	</div>	
	<p><a name="bottom"></a></p>
</div>
		
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>		
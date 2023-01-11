<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
    	<h2><?php htmlecho ($headMain); ?></h2>
		<div class = "main-headers-line"></div>
	</div>
</div>

<div class = "m-content shop-comp">
	<?php if (empty ($gamesView))
		{
			echo '<p align = "center">Товары отсутствуют</p>';
		}
		 
		else
			 
		foreach ($gamesView as $game): ?> 

		<div class="goods-place">
			<p><a href="<?php htmlecho ($game['url']);?>" rel = "nofollow"><img src="<?php echo $game['images'];?>"></a></p>
			<p><strong><a href="<?php htmlecho ($game['url']); ?>" rel = "nofollow">Купить <?php htmlecho ($game['title']); ?></a></strong></p>
			<p><?php if ($game['price'] == 0)
						{
							echo '<strong>Ожидается</strong>';
						}
							
						elseif ($game['old_price'] == '')
						{
							echo '<strong style = "color: green">'.$game['price'].' руб.</strong>';
							//echo '<strong style = "color: green">'.$game['price'].' руб.</strong> (<strike>'.$game['old_price'].' руб.</strike>)';
						}
								
						else 
						{
							echo '<strong style = "color: green">'.$game['price'].' руб.</strong> (<strike>'.$game['old_price'].' руб.</strike>)';
						}?></p>
			</div>
		 <?php endforeach; ?>
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	
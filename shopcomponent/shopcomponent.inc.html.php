<div class = "main-headers">
    <div class = "headers-places"> 
            <div class = "main-headers-place"><a href="https://playo.ru/?s=c4a1r15p" rel = "nofollow">Купить лицензионные ключи игр</a></div>
            <div class = "main-headers-txtplace"><i class="fa fa-reply" aria-hidden="true"></i> Больше игр здесь!</div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<div class = "m-content shop-comp">
	<?php if (empty ($gamesView))
		{
			echo '<p align = "center">Игры отсутствуют</p>';
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
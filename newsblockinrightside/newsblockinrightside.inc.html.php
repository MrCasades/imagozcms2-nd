<div class="newsblock-rs">	
	<div class = "main-headers">
		<div class = "main-headers-content">
			<h2 class="no-link-header">Последние новости</h2>
			<div class = "main-headers-line"></div>				
		</div>
	</div>

	<div class = "similar-art">
		<?php if (empty($newsInRs))
				{
					echo '<p align = "center">Новости отсутствуют</p>';
				}
					
				else
						
				foreach ($newsInRs as $news_rs): ?>
					
		<a href = "../viewnews/?id=<?php htmlecho ($news_rs['id']); ?>" class = "post-place-grid" style="background-image: url(../images/<?php echo $news_rs['imghead']; ?>)">
			<div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($news_rs['newstitle'])), 0, 7)))); ?>...</div>
		</a> 
		<?php endforeach; ?>
	</div>
</div>
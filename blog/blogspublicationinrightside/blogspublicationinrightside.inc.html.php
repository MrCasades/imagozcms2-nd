<div class="newsblock-rs">	
	<div class = "main-headers">
		<div class = "main-headers-content">
			<h2 class="no-link-header">Последние записи блогов</h2>
			<div class = "main-headers-line"></div>				
		</div>
	</div>

	<div class = "similar-art">
		<?php if (empty($blogsRs))
				{
					echo '<p align = "center">Записи отсутствуют</p>';
				}
					
				else
						
				foreach ($blogsRs as $blogs_rs): ?>
					
		<a href = "../blog/publication/?id=<?php htmlecho ($blogs_rs['id']); ?>" class = "post-place-grid" style="background-image: url(../images/<?php echo $blogs_rs['imghead']; ?>)">
			<div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($blogs_rs['title'])), 0, 7)))); ?>...</div>
		</a> 
		<?php endforeach; ?>
	</div>
</div>
<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
	    <h2>Блоги автора</h2>
		<div class = "main-headers-line"></div>
	</div>
</div>

<?php if ($selectedAuthor == $idAuthor): ?>
	<form action = "../blog/addupdblog/" method = "post">
		<input type = "hidden" name = "id" value = "<?php echo $idAuthor;?>'">
		<input type = "submit" name = "action" class="btn_2 addit-btn" value = "Создать блог">
	</form> 
<?php endif;?> 


<div class = "main-post">
	<?php  if (empty ($blogs))
		 {
			 echo '<p>У автора пока нет блогов</p>';
		 }
		 
		 else

		 foreach ($blogs as $blog): ?>
		
		<a href="../blog/?id=<?php htmlecho ($blog['id']); ?>" class = "post-place-2" style="background-image: url(../blog/avatars/<?php echo $blog['avatar']; ?>)">
			<!-- <div class = "post-top-1">
				<span class="post-rubrics"><?php htmlecho ($news['categoryname']); ?></span>
			</div> -->
			<div class = "post-bottom-1">
				<span class="post-header-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($blog['title'])), 0, 7)))); ?>...</span>
				<!-- <br><span class="post-date-1"><?php echo date("Y.m.d H:i", strtotime($news['newsdate'])); ?></span> -->
			</div>
		</a>

	<?php endforeach; ?>
</div>


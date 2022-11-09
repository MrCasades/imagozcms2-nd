<?php if (!empty ($newsIn)): ?>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
	<a class = "main-headers-place" href = "../account/allauthornews/?id=<?php htmlecho ($idAuthor); ?>"><h2>Новости автора</h2></a>
		<div class = "main-headers-line"></div>
	</div>
</div>

<?php endif; ?>

<div class = "main-post">
	<?php  if (empty ($newsIn))
		 {
			 echo '<p>Автор не написал ни одной новости</p>';
		 }
		 
		 else

		 foreach ($newsIn as $news): ?>

		<a href = "../viewnews/?id=<?php htmlecho ($news['id']); ?>" class = "post-place-2" style="background-image: url(../images/<?php htmlecho ($news['imghead']); ?>)">
			<div class = "post-top-1"><?php htmlecho ($news['newsdate']); ?></div>
				<div class = "post-bottom-1"><?php htmlecho ($news['newstitle']); ?></div>
		</a>

	<?php endforeach; ?>
</div>

<?php if (!empty ($posts)): ?>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
		<a class = "main-headers-place" href = "../account/allauthorpost/?id=<?php htmlecho ($idAuthor); ?>"><h2>Статьи автора</h2></a>
		<div class = "main-headers-line"></div>
	</div>
</div>

<?php endif; ?>

<div class = "main-post">
	<?php  if (empty ($posts))
		 {
			 echo '<p>Автор не написал ни одной статьи</p>';
		 }
		 
		 else

		 foreach ($posts as $post): ?>

		<a href = "../viewpost/?id=<?php htmlecho ($post['id']); ?>" class = "post-place-2" style="background-image: url(../images/<?php htmlecho ($post['imghead']); ?>)">
			<div class = "post-top-1"><?php htmlecho ($post['postdate']); ?></div>
				<div class = "post-bottom-1"><?php htmlecho ($post['posttitle']); ?></div>
		</a>

	<?php endforeach; ?>
</div>
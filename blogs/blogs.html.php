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

	<div class = "m-content about-blogs">
		<p>Делитесь своими мыслями, пишите заметки и статьи в сервисе блогов от <strong>imagoz.ru</strong>! Пишите интересные и полезные материалы, и Вы будете известны огромной аудитории.</b>
		<p>Приветствуются блоги по IT-тематике, дизайну, компьютерным играм, высоким технологиям, гаджетам и науке. Но в целом принимаются любые темы, главное, чтобы это было интересно большой аудитории.</b>
		<p>Чтобы создать свой блог и делать публикации переходите в раздел <a href = "../myblogs"><strong>Мои блоги</strong></a>. Присоеденяйтесь к числу авторов нашего сообщества <strong>imagoz.ru</strong>!</p>
	</div>

	<?php if (!empty ($pubs)): ?>
		<div class = "main-headers">
			<div class = "main-headers-circle"></div>
			<div class = "main-headers-content">
				<h2>Недавние публикации</h2>
				<div class = "main-headers-line"></div>				
			</div>
		</div>
	
		<div class = "newsblock m-content">			 
			<?php foreach ($pubs as $pub): ?> 
			<a href = "../blog/publication?id=<?php htmlecho ($pub['id']); ?>" class = "post-place-1" style="background-image: url(../images/<?php echo $pub['imghead']; ?>)">
				<div class = "post-top-1">
					<p><?php echo date("Y.m.d H:i", strtotime($pub['date'])); ?></p>
					<span class="post-rubrics"><?php htmlecho ($pub['categoryname']); ?></span>
				</div>
				<div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($pub['title'])), 0, 7)))); ?>...</div>
			</a>
			<?php endforeach; ?>
		</div>

		<div class = "main-headers">
			<div class = "main-headers-circle"></div>
			<div class = "main-headers-content">
				<h2>Блоги</h2>
				<div class = "main-headers-line"></div>				
			</div>
		</div>

		<div class = "main-post m-content">
			<?php foreach ($blogs as $blog): ?>
			<a href="../blog/?id=<?php htmlecho ($blog['id']); ?>" class = "post-place-2" style="background-image: url(//<?php htmlecho (MAIN_URL); ?>/blog/avatars/<?php echo $blog['avatar']; ?>)">				
				<div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($blog['title'])), 0, 7)))); ?>...</div>
			</a>
			
			<?php endforeach; ?>
		</div>			

	<?php endif; ?>	

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
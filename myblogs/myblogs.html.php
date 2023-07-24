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
			<div class = "sub-header"><?php htmlecho ($subHeaderPost); ?></div>
		</div>
	</div>
    <div class = "main-post m-content">
        <form action = "//<?php htmlecho (MAIN_URL); ?>/blog/addupdblog/" method = "post">
            <input type = "hidden" name = "id" value = "<?php echo $idAuthor;?>'">
            <input type = "submit" name = "action" class="btn_2 addit-btn" value = "Создать блог">
        </form> 
    </div>
	<div class = "main-post m-content">
		<?php if (empty($blogs))
		{
			echo '<p>Статьи отсутствуют</p>';
		}
			
		else
				
		foreach ($blogs as $blog): ?>
		<a href="//<?php htmlecho (MAIN_URL); ?>/blog/?id=<?php htmlecho ($blog['id']); ?>" class = "post-place-2" style="background-image: url(//<?php htmlecho (MAIN_URL); ?>/blog/avatars/<?php echo $blog['avatar']; ?>)">			
			<div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($blog['title'])), 0, 7)))); ?>...</div>
		</a>
			
		<?php endforeach; ?>
		
	</div>
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
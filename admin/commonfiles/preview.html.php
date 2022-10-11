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

<?php if(!empty($pubFolder)):?>
	<div class = "error-pl">
		<p class = "for-info-txt">Материал сохранён в черновике! Если хотите отправить его сразу на проверку редактору, нажмите на кнопку ниже.</p>
			
		<?php if (!empty($fullPrice)): ?>
			<p class = "for-info-txt">Число знаков в статье (без пробелов) <?php echo $lengthText;?> | Стоимость  <?php echo $fullPrice.$bonusText;?></p>
		<?php endif; ?>
		<form action = "../../admin/<?php echo $pubFolder; ?>/" method = "post" id = "confirmok">
			<input type = "hidden" name = "id" value = "<?php echo $idpost_ind; ?>">
			<input type = "submit" name = "action" value = "ОПУБЛИКОВАТЬ" class= "btn_3">
		</form>
	</div>
<?php endif;?>

<article>
<div class="article-row">
		<div class="left-side">
			<div class = "article-head m-content" style="background-image: url(<?php echo '//'.MAIN_URL; ?>/images/<?php echo $imgHead; ?>)">
				<div class = "article-head-top"> 
					<div class ="article-info">
						<p><span class="post-rubrics"><a href="<?php echo '//'.MAIN_URL; ?>/viewcategory/?id=<?php echo $categoryId; ?>"><?php echo $categoryName;?></a></span></p>
					</div>
				<div class="article-rating">
						<i class="fa fa-eye" aria-hidden="true" title="Просмотры"></i> 0  
						<i class="fa fa-heartbeat" aria-hidden="true" title="Оценка"></i> 0
						<i class="fa fa-check-square-o" aria-hidden="true" title="Добавили в избранное"></i> 0
				</div>
			</div>
			
			</div>
			<h1 class="m-content"><?php htmlecho ($posttitle); ?></h1>
			<div class="article-head-bottom m-content">
				<a href="<?php echo '//'.MAIN_URL; ?>/account/?id=<?php echo $authorId;?>"><?php echo $nameAuthor;?></a>
				<br><?php echo $date;?>
			</div>
			<div class="tags-place-m m-content"> 
				<?php if (empty($metas))
				{
					echo '';
				}
						
				else
						
				foreach ($metas as $meta): ?> 
					
					<a href="<?php echo MAIN_URL; ?>/viewallmetas/?metaid=<?php echo $meta['id']; ?>"><?php echomarkdown ($meta['metaname']); ?></a>
						
				<?php endforeach; ?>

			</div>

				<!-- <div class="m-content">
					Место для рекламы
				</div> -->

				<div class="pub-pl">
					<div class="a-line"></div>
					<div class="a-content">
						<?php echomarkdown_pub ($articleText); ?>
						<p class="a-video"><?php echo $video; ?></p>
					</div>								
				</div>

		<div class = "m-content">
			<p><?php echo $delAndUpd; ?></p>
		</div>

</div>

</article>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?></h1></div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<div class = "error-pl">
	<p class = "for-info-txt">Материал сохранён в черновике! Если хотите отправить его сразу на проверку редактору, нажмите на кнопку ниже.</p>
		
	<p class = "for-info-txt">Число знаков в статье (без пробелов) <?php echo $lengthText;?> | Стоимость  <?php echo $fullPrice;?>, с учётом бонуса Х<?php echo $bonus;?></p>
	<form action = "../../admin/addupdnews/" method = "post" id = "confirmok">
		<input type = "hidden" name = "id" value = "<?php echo $idpost_ind; ?>">
		<input type = "submit" name = "action" value = "ОПУБЛИКОВАТЬ" class= "btn_3">
	</form>
</div>

<article>
    <div class = "article-head m-content" style="background-image: url(../../images/<?php echo $imgHead; ?>)">
        <div class = "article-head-top"> 
            <div class ="article-info">
                <p><?php echo $date;?> | Автор: <a href="../../account/?id=<?php echo $authorId;?>"><?php echo $nameAuthor;?></a></p>
                <p>Рубрика: <span class="post-rubrics"><a href="../../viewcategory/?id=<?php echo $categoryId; ?>"><?php echo $categoryName;?></a></span></p>
            </div>
        <div class="article-rating">
                <i class="fa fa-eye" aria-hidden="true" title="Просмотры"></i> 0  
				<i class="fa fa-heartbeat" aria-hidden="true" title="Оценка"></i> 0
				<i class="fa fa-check-square-o" aria-hidden="true" title="Добавили в избранное"></i> 0
        </div>
    </div>
    </div>

	<div class="m-content">


		<div class="a-content m-content">
			<?php echomarkdown_pub ($articleText); ?>
			<p class="a-video"><?php echo $video; ?></p>
			<div class="tags-place-m"> 
				<?php if (empty($metas))
				{
					echo '';
				}
				
				else
				
				foreach ($metas as $meta): ?> 
			
					<a href="../../viewallmetas/?metaid=<?php echo $meta['id']; ?>"><?php echomarkdown ($meta['metaname']); ?></a>
				
				<?php endforeach; ?>

			</div>
        </div>

		<div class = "m-content">
			<p><?php echo $delAndUpd; ?></p>
			<p><?php echo $premoderation; ?></p>
		</div>

</div>

</article>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
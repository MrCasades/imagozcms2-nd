<?php 

/*Загрузка функций для формы входа*/
require_once MAIN_FILE . '/includes/access.inc.php';

/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><a href="#" onclick="history.back();">Назад</a></h1></div>
    </div>
    <div class = "main-headers-line"></div>
</div>

<article>
    <div class = "article-head m-content" style="background-image: url(../../../images/<?php echo $imgHead; ?>)">
        <div class = "article-head-top"> 
            <div class ="article-info">
                <p><?php echo $date;?> | Автор:</p>
                <p>Рубрика:</p>
            </div>
        <div class="article-rating">
                <i class="fa fa-eye" aria-hidden="true" title="Просмотры"></i> 0  
				<i class="fa fa-heartbeat" aria-hidden="true" title="Оценка"></i> 0
				<i class="fa fa-check-square-o" aria-hidden="true" title="Добавили в избранное"></i> 0
        </div>
    </div>
    <h1><?php htmlecho ($headMain); ?></h1>
    </div>

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
			
					<a href="../viewallmetas/?metaid=<?php echo $meta['id']; ?>"><?php echomarkdown ($meta['metaname']); ?></a>
				
				<?php endforeach; ?>

			</div>
			<p><?php echo $delAndUpd; ?></p>
			<p><?php echo $premoderation; ?></p>
        </div>
</article>
				
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
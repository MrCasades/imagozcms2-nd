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
		<div class = "sub-header"><?php htmlecho ($subHeaderNews); ?></div>
	</div>
</div>

<div class = "main-post m-content">
	<?php if (empty($newsIn))
	 {
		echo '<p align = "center">Статьи отсутствуют</p>';
	 }
		 
	 else
			 
	 foreach ($newsIn as $news): ?>
    <a href="../viewnews/?id=<?php htmlecho ($news['id']); ?>" class = "post-place-2" style="background-image: url(../images/<?php echo $news['imghead']; ?>)">
        <div class = "post-top-1">
            <p><?php echo date("Y.m.d H:i", strtotime($news['newsdate'])); ?></p>
			<div class="article-rating">
                <i class="fa fa-eye" aria-hidden="true" title="Просмотры"></i> <?php htmlecho ($news['viewcount']); ?> 
				<i class="fa fa-heartbeat" aria-hidden="true" title="Оценка"></i> <?php htmlecho ($news['averagenumber']); ?>
            </div>
        </div>
        <div class = "post-bottom-1"><?php htmlecho ((implode(' ', array_slice(explode(' ', strip_tags($news['newstitle'])), 0, 7)))); ?>...</div>
	</a>
		
	<?php endforeach; ?>
	
</div>

<?php 
/*Загрузка пагинации*/
include_once MAIN_FILE . '/pubcommonfiles/pagination.inc.php';?>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>

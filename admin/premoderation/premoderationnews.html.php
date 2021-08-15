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

<div class = "m-content">
<table class = "for-tables-premod">
		  <tr>
				<th>#id</th>
				<th>Дата публикации</th>
				<th>Заголовок</th>	
				<th>Автор</th>
				<th>E-mail</th>				
		  </tr> 
		  
		   <?php if (empty ($newsIn))
		 {
			 echo '<p class = "for-info-txt">Материалы для премодерации отсутствуют</p>';
		 }
		 
		 else
			 
		 foreach ($newsIn as $news): ?> 
		  <tr>
				<td><?php echo '# '.$news['id'];?></td>
				<td><?php echo $news['newsdate'];?></td>
				<td><a href="../../admin/premoderation/viewpremodnews/?news=<?php echo $news['id'];?>"><?php echo $news['newstitle'];?></a></td>
				<td><?php echo $news['authorname'];?></td>
				<td><?php echo $news['email'];?></td>
		  </tr> 				
		 <?php endforeach; ?> 
		</table>
</div>
		
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	
<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
	<div class = "main-headers-circle"></div>
	<div class = "main-headers-content">
    	<h2><?php htmlecho ($headMain); ?> | <a href="#" onclick="history.back();">Назад</a></h2>
		<div class = "main-headers-line"></div>
	</div>
</div>

<div class = "m-content">
	<table class = "for-tables-premod">
		  <tr>
				<th>#id</th>
				<th>Дата публикации</th>				
				<th>Блог</th>
				<th>Автор</th>
				<th>E-mail</th>				
		  </tr> 
		  
		   <?php if (empty ($publications))
		 {
			 echo '<p class = "for-info-txt">Материалы для премодерации отсутствуют</p>';
		 }

		 else
			 
		 foreach ($publications as $publication): ?> 
		  <tr>
				<td><?php echo '# '.$publication['id'];?></td>
				<td><?php echo $publication['upddate'];?></td>
				<td><a href="//<?php echo MAIN_URL ;?>/blog/publication/?id=<?php echo $publication['id'];?>" target="blank_"><?php echo $publication['title'];?></a></td>
				<td><?php echo $publication['authorname'];?></td>
				<td><?php echo $publication['email'];?></td>
		  </tr> 				
		 <?php endforeach; ?> 
	</table>
</div>	
		
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	
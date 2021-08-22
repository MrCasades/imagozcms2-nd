<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "main-headers">
    <div class = "headers-places"> 
        <div class = "main-headers-txtplace"><h1><?php htmlecho ($headMain); ?> | <a href="#" onclick="history.back();">Назад</a></h1></div>
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

		  <?php if (empty ($posts))
		 {
			 echo '<p class = "for-info-txt">Материалы для премодерации отсутствуют</p>';
		 }
		 
		 else

		 foreach ($posts as $post): ?> 
			<tr>
				  <td><?php echo '# '.$post['id'];?></td>
				  <td><?php echo $post['postdate'];?></td>
				  <td><a href="../../admin/premoderation/viewpremodpost/?post=<?php echo $post['id'];?>"><?php echo $post['posttitle'];?></a></td>
				  <td><?php echo $post['authorname'];?></td>
				  <td><?php echo $post['email'];?></td>
			</tr> 				
		   <?php endforeach; ?> 
	</table>	
</div>
		
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>		
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
				<th>Имя</th>
				<th>E-mail</th>
				<th>Размер счёта</th>	
				<th>Бонус</th>
				<th>Опубликовано</th>
			  	<th>В работе</th>
		  </tr> 
		 <?php foreach ($authors as $author): ?> 
			<div>
		  <tr>
				<td><a href="../../account/?id=<?php htmlecho($author['id'])?>"><?php htmlecho($author['authorname']);?></a></td>
				<td><?php htmlecho($author['email']);?></td>
				<td><?php htmlecho($author['score']);?></td>
				<td><?php htmlecho($author['bonus']);?></td>
				<td><?php htmlecho($author['countposts']);?></td>
				<td><?php htmlecho($author['taskcount']);?></td>	
		  </tr>
			</div>	
		 <?php endforeach; ?>	
	</table>
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
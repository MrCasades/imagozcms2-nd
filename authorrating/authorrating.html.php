<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>

<div class = "maincont">
	<div>
	  	
		<table align = "center" border = "1">
		  <tr>
				<th>Имя</th>
			    <th>Рейтинг</th>
				<th></th>
			    <th>Действие</th>
			  	<th>Число статей</th>
		  </tr> 
		 <?php foreach ($authors as $author): ?> 
			<div>
		<form action = "?add" method = "post">
		  <tr>
				<td><a href="../account/?id=<?php htmlecho($author['id']);?>"><?php htmlecho($author['authorname']);?></a>
			  		<input type = "hidden" name = "authorid" value = "<?php htmlecho($author['id']);?>" >
			  		<input type = "hidden" name = "countposts" value = "<?php htmlecho($author['countposts']);?>" ></td>
			  	<td><?php htmlecho($author['rating']);?></td>
				<td><input type = "text" name = "points" value = "0" ></td>
			  	<td><input type = "submit" value = "add"></td>
			    <td><?php htmlecho($author['countposts']);?></td>
		  </tr>
		  </form>	
		</div>	
			
		 <?php endforeach; ?>	
		</table>
		  	
	</div>	
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
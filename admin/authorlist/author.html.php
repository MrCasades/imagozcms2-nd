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

<div class="m-content">
	<hr/>
	<p><a href = '../../admin/authors/'>Список авторов портала</a></p>
	<hr/>
		<table>
		<tr><th>Имя</th><th>Возможные действия</th></tr>
		 <?php foreach ($authors as $author): ?> 
			<tr> 
			  <form action = " " method = "post">
			   <div>
				<td><a href="../../account/?id=<?php htmlecho($author['idauthor'])?>"><?php htmlecho($author['authorname']);?></a></td>
				<td>
				<input type = "hidden" name = "idauthor" value = "<?php echo $author['idauthor']; ?>">
				<input type = "submit" name = "action" value = "Upd" class="btn_1">
				<input type = "submit" name = "action" value = "Del" class="btn_2" id = "delauthor" onclick = "return confirm('Вы уверены?')">
				</td>
			   </div>
		      </form>
			 </tr>  
		 <?php endforeach; ?>	
		</table>
</dev>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>


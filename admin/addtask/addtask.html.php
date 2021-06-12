<?php 
/*Загрузка функций в шаблон*/
include_once MAIN_FILE . '/includes/func.inc.php';

/*Загрузка header*/
include_once MAIN_FILE . '/header.inc.php';?>
	
	<div class = "maincont">
	<div class = "post">
	
	<p align = "center"><strong><?php htmlecho($errorForm); ?></strong></p>
	
	<form action = "?<?php htmlecho($action); ?> " method = "post">
	<table>
	 <div>
	  <tr>
		<td><label for = "author"> Автор:</label></td>
		<td>
		 <?php echo $authorPost;?>
		</td>
	  </tr>
	 </div>
	<div>
	  <tr>
		<td><label for = "tasktitle">Введите заголовок </label></td>
		<td><input type = "tasktitle" name = "tasktitle" id = "tasktitle" value = "<?php htmlecho($tasktitle);?>"></td>
	  </tr>	
	</div>
	 <div>
	   <tr>
		<td><label for = "tasktype"> Тип задания:</label></td>
		<td>
		<select name = "idtasktype" id = "idtasktype">
		  <option value = "">Тип</option>
			<?php foreach ($tasktypes_1 as $tasktype): ?>
			 <option value = "<?php htmlecho($tasktype['idtasktype']); ?>"
			 <?php if ($tasktype['idtasktype'] == $idtasktype)
			 {
				 echo 'selected';
			 }				 
			  ?>><?php htmlecho($tasktype['tasktypename']); ?></option>
			<?php endforeach; ?> 
		</select>
		</td>
		</tr>		
	 </div>
	 <div>
	   <tr>
		<td><label for = "rang"> Ранг задания:</label></td>
		<td>
		<select name = "idrang" id = "idrang">
			<?php foreach ($rangs_1 as $rangs): ?>
			 <option value = "<?php htmlecho($rangs['idrang']); ?>"
			 <?php if ($rangs['idrang'] == $idrang)
			 {
				 echo 'selected';
			 }				 
			  ?>><?php htmlecho($rangs['rangname']); ?></option>
			<?php endforeach; ?> 
		</select>
		</td>
		</tr>		
	 </div>	
	 </table>
	<div>
		<label for = "description">Добавьте техническое задание</label><br>
		<textarea class = "descr" id = "description" name = "description" data-provide="markdown" rows="10"><?php htmlecho($description);?></textarea>	
	 </div>
	 <hr/>
	  <div>
		<input type = "hidden" name = "id" value = "<?php htmlecho($id); ?>">
		<input type = "submit" value = "<?php htmlecho($button); ?>" class="btn btn-primary btn-sm">
	  </div>	  
	</form>	
	</div>
	</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	
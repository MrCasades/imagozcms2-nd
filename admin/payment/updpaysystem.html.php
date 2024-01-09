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

<div class = "error-pl">
	<p>
	<p><strong><?php htmlecho($errorForm); ?></strong></p>
	
	<form action = "?<?php htmlecho($action); ?> " method = "post">
	<table>	
		<div>
		<tr>
			<td><label for = "paysystem"> Платёжная система:</label></td>
			<td>
			<select name = "paysystem" id = "paysystem">
			<option value = "">Выбрать: </option>
				<?php foreach ($paysystems as $paysystem): ?>
				<option value = "<?php htmlecho($paysystem['idpaysystem']); ?>"
				<?php if ($paysystem['idpaysystem'] == $idpaysystem)
				{
					echo 'selected';
				}				 
				?>><?php htmlecho($paysystem['paysystemname']); ?></option>
				<?php endforeach; ?> 
			</select>
			</td>
			</tr>		
		</div>	
		<div>
		<tr>
			<td><label for = "ewallet">Номер кошелька: </label></td>
			<td><input type = "ewallet" name = "ewallet" id = "ewallet" value = "<?php htmlecho($ewallet);?>"></td>
		</tr>	
		</div>
		</table>
		<div>
			<input type = "hidden" name = "id" value = "<?php htmlecho($id); ?>">
			<input type = "submit" value = "<?php htmlecho($button); ?>" class="btn_2 addit-btn">
			<a href="#" onclick="history.back();"><button type="button" class="btn_1 addit-btn">Назад</button></a>
		</div>    	  
	</form>	
	</p>
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	
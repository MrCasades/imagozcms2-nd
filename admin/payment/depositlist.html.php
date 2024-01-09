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
<h3 class = "for-info-txt">Внесённые платежи</h3>
		<table class = "for-tables-premod">
		  <tr>
				<th width = "70 px">#id</th>
				<th width = "300 px">id в системе Яндекс.Деньги</th>
				<th width = "200 px">Сумма платежа</th>	
				<th width = "120 px">Дата</th>
				<th width = "200 px">Статус</th>
		  </tr> 
		  
		  <?php if (empty ($deposits))
		 {
			 echo '<p class = "for-info-txt">Операции отсутствуют</p>';
		 }
		 
		 else
		  
		 foreach ($deposits as $deposit): ?> 
		  <tr>
				<td><?php echo '# '.$deposit['id'];?></td>
				<td><?php echo $deposit['idoperation'];?></td>
				<td><?php echo $deposit['deposit'];?></td>
				<td><?php echo $deposit['depositdate'];?></td>
				<td><?php echo $deposit['depositstatus'];?></td>
		  </tr> 				
		 <?php endforeach; ?> 
		</table> 
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>
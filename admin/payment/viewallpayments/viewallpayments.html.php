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
				<th>#id заявки</th>
				<th>Дата создания</th>	
				<th>Автор</th>
				<th>E-mail</th>	
			    <th>Сумма</th>
			    <th>Платёжная система</th>	
			    <th>Кошелёк</th>
			    <th>Просмотр</th>
		  </tr> 
		  
		   <?php if (empty ($payments))
		 {
			 echo '<p class = "for-info-txt">Заявки отсутствуют</p>';
		 }
		 
		 else
			 
		 foreach ($payments as $payment): ?> 
		  <tr>
				<td><?php echo '# '.$payment['id'];?></td>
				<td><?php echo $payment['creationdate'];?></td>
			    <td><?php echo $payment['authorname'];?></td>
				<td><?php echo $payment['email'];?></td>
			    <td><?php echo $payment['payment'];?></td>
			    <td><?php echo $payment['paysystemname'];?></td>
				<td><?php echo $payment['ewallet'];?></td>
				<td><a href="../../../admin/payment/viewpayment/?id=<?php echo $payment['id'];?>"><button class="btn_2">Просмотр</button></a></td>
		  </tr> 				
		 <?php endforeach; ?> 
	</table>
</div>
		
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	
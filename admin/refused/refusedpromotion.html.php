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

<div class="m-content">
		<h3>Промоушен</h3>
			
		<?php if (empty ($promotions))
		{ 
			echo '<p>Отклонённые материалы отсутствуют</p>';
		}
			
		else
			
		foreach ($promotions as $promotion): ?> 
		<div class = "post">
			<div class = "posttitle">
					<?php echo ($promotion['promotiondate']. ' | Автор: <a href="../../account/?id='.$promotion['idauthor'].'" style="color: white" >'.$promotion['authorname']).'</a>';?>
				</div>
				<div>
					<h3><?php echo $promotion['promotiontitle'];?></h3>		  	
				</div> 
				<div class = "posttitle" align="center">
					Причина отказа
				</div>
				<div>
					<p><?php echomarkdown ($promotion['reasonrefusal']);?></p>
					<form action = "../../admin/addupdpromotion/" method = "post">
							<input type = "hidden" name = "id" value = "<?php echo $promotion['id'];?>">
							<input type = "submit" name = "action" value = "Переделать" class="btn_2">
							<input type = "submit" name = "action" value = "Del" class="btn_1">
						</form>
				</div>
			</div>			
			<?php endforeach; ?> 
		</div>	
		<p><a name="bottom"></a></p>
</div>

<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>		
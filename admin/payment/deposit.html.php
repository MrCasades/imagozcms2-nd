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
	<p>Пополнение счёта на сайте IMAGOZ.RU осуществляется при помощи сервиса Яндекс.Деньги. Ваш счёт баллов будет пополнен мгновенно после совершения операции. 
	В случае возникновения проблем с платежом, если счёт не был пополнен и т. п. пишите в <a href='/admin/adminmail/?addmessage'>форму</a> обратной связи в меню сайта. Пополнить можно на любую сумму. По-умолчанию
	предлагается цена 1-й публикации рекламной статьи на сайте.</p>
	
	<form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml">
	 <table>
		 <tr>
		  <div>
			<th>Введите сумму: </th><td><input type="input" name="sum"  data-type="number" value="99"></td>
		  </div>
		</tr>
		 <tr>
		  <div> 
			  <th>Выбор способа пополнения: </th>
				<td><input type="radio" name="paymentType" value="PC">Яндекс.Деньгами</input>
				<input type="radio" name="paymentType" value="AC">Банковской картой</input></td>
	  	 </div>
		</tr>
	 </table>	
		<input type="hidden" name="receiver" value="410015600659745">
		<input type="hidden" name="formcomment" value="Пополнение счёта IMAGOZ">
		<input type="hidden" name="short-dest" value="Пополнение счёта IMAGOZ">
		<input type="hidden" name="label" value="<?php htmlecho ($idauthor); ?>">
		<input type="hidden" name="quickpay-form" value="donate">
		<input type="hidden" name="targets" value="Пополнение счёта IMAGOZ">
		<input type="hidden" name="comment" value="Пополненить счёт IMAGOZ" >
		<input type="hidden" name="need-fio" value="false"> 
		<input type="hidden" name="need-email" value="false" >
		<input type="hidden" name="need-phone" value="false">
		<input type="hidden" name="need-address" value="false">
			
		<input type="submit" name="submit-button" value="Перевести" class="btn_2 addit-btn">
		<a href="#" onclick="history.back();"><button type="button" class="btn_1 addit-btn">Назад</button></a>
	</form>
</div>
	
<?php 
/*Загрузка footer*/
include_once MAIN_FILE . '/footer.inc.php';?>	
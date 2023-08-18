<form action = "../account/blockedbuttons/blockedbuttons.inc.php" method = "post">
	<div>
		<input type = "hidden" name = "idauthor" value = "<?php htmlecho ($idAuthor); ?>">
        <input type = "hidden" name = "banterm" value = "1">
		<button name = "action" class="btn_3 addit-btn" value="Заблокировать">Бан 1 день</button>
	</div>
</form>

<form action = "../account/blockedbuttons/blockedbuttons.inc.php" method = "post">
	<div>
		<input type = "hidden" name = "idauthor" value = "<?php htmlecho ($idAuthor); ?>">
        <input type = "hidden" name = "banterm" value = "3">
		<button name = "action" class="btn_3 addit-btn" value="Заблокировать">Бан 3 дня</button>
	</div>
</form>

<form action = "../account/blockedbuttons/blockedbuttons.inc.php" method = "post">
	<div>
		<input type = "hidden" name = "idauthor" value = "<?php htmlecho ($idAuthor); ?>">
        <input type = "hidden" name = "banterm" value = "7">
		<button name = "action" class="btn_3 addit-btn" value="Заблокировать">Бан 7 дней</button>
	</div>
</form>

<form action = "../account/blockedbuttons/blockedbuttons.inc.php" method = "post">
	<div>
		<input type = "hidden" name = "idauthor" value = "<?php htmlecho ($idAuthor); ?>">
        <input type = "hidden" name = "banterm" value = "30">
		<button name = "action" class="btn_3 addit-btn" value="Заблокировать">Бан 30 дней</button>
	</div>
</form>

<form action = "../account/blockedbuttons/blockedbuttons.inc.php" method = "post">
	<div>
		<input type = "hidden" name = "idauthor" value = "<?php htmlecho ($idAuthor); ?>">
        <input type = "hidden" name = "banterm" value = "alltime">
		<button name = "action" class="btn_3 addit-btn" value="Заблокировать">Бан навсегда</button>
	</div>
</form>
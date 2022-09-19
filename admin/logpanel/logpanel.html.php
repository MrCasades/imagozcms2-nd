<?php if (!isset($_SESSION['loggIn'])): ?>
	
<?php else:?>
	<div class = "logpanel">   
		<?php echo $payForms.$panel;?>
		<?php echo $allPosts.$allRefused;?>
	</div>
	
<?php endif;?>

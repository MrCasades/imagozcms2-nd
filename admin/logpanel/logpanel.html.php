<?php if (!isset($_SESSION['loggIn'])): ?>
	
<?php else:?>
	<div class = "logpanel">   
		<?php echo $payForms;?>
		<?php echo $allPosts.$allRefused;?>
	</div>
	
<?php endif;?>

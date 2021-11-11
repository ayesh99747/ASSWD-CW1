<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>
<title><?php echo $name ?></title>
<p class="h1 d-flex justify-content-center"><?php echo $name ?></p><br>

<?php if (isset($isSuccess)): ?>
	<?php if ($isSuccess): ?>
		<!--If the email verification was successful-->
		<div class="alert alert-success">
			<?php echo 'Email Verification Successful!'; ?>
		</div>
		<p class="h3"> Your email has been successfully verified, you can now proceed to the <a
					href="<?php echo base_url() ?>index.php/login">login page.</a></p><br>
	<?php else: ?>
		<!--If the email verification was unsuccessful-->
		<div class="alert alert-danger">
			<?php echo 'Email Verification Fail! Please try again later.'; ?>
		</div>
		<p class="h3"> Your email has not been successfully verified, please try again later!</p><br>
	<?php endif; ?>
<?php else: ?>
	<?php if ($code == 1): ?>
		<!--If the email verification was already completed-->
		<div class="alert alert-danger">
			<?php echo 'Email Verification already completed!'; ?>
		</div>
		<p class="h3"> Your email has already been verified, you can proceed to the <a
					href="<?php echo base_url() ?>index.php/login">login page.</a></p><br>
	<?php else: ?>
		<!--If the email verification failed-->
		<div class="alert alert-danger">
			<?php echo 'Email Verification Fail!'; ?>
		</div>
		<p class="h3"> The verification key provided does not exist!</p><br>
	<?php endif; ?>

<?php endif; ?>




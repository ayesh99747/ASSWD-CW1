<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>
<!--TODO: Style this page -->
<title>Login Page</title>
<p class="h1 d-flex justify-content-center">Login Page</p><br>

<?php $attributes = array('id' => 'login_form', 'class' => 'row g-3') ?>

<?php if ($this->session->flashdata('loginErrors')): ?>
	<div class="alert alert-danger print-error-msg">
		<?php echo $this->session->flashdata('loginErrors'); ?>
		<?php  unset($_SESSION['loginErrors']);?>
	</div>
<?php endif; ?>

<?php if ($this->session->userdata('is_logged_in') == true): ?>
	<div class="alert alert-danger print-error-msg">
		<?php echo "You have already logged in!"; ?>
	</div>
<?php endif; ?>

<?php echo form_open('Authentication/login', $attributes); ?>


<!-- Username Input -->
<div class="form-group">
	<?php

	echo form_label('Username');
	$data = array(
			'class' => 'form-control',
			'name' => 'username',
			'placeholder' => 'Enter Username',

	);
	echo form_input($data);
	?>
</div>


<!-- Password Input -->
<div class="form-group">
	<?php

	echo form_label('Password');
	$data = array(
			'class' => 'form-control',
			'name' => 'password',
			'placeholder' => 'Enter Password',

	);
	echo form_password($data);
	?>
</div>


<!-- Login Button-->
<?php if ($this->session->userdata('is_logged_in') == true): ?>
	<div class="form-group">
		<?php
		$data = array(
				'class' => 'btn btn-primary disabled',
				'name' => 'submit',
				'value' => 'Login',

		);
		echo form_submit($data);
		?>
	</div>
<?php else: ?>
	<div class="form-group">
		<?php
		$data = array(
				'class' => 'btn btn-primary',
				'name' => 'submit',
				'value' => 'Login',

		);
		echo form_submit($data);
		?>
	</div>
<?php endif; ?>




<?php echo form_close(); ?>



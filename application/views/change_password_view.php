<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>
<!--TODO: Style this page -->
<title>Change Password Page</title>
<p class="h1 d-flex justify-content-center">Change Password Page</p><br>

<?php $attributes = array('id' => 'change_password_form', 'class' => 'row g-3') ?>

<?php if ($this->session->flashdata('changePasswordErrors') !== null): ?>
	<div class="alert alert-danger print-error-msg">
		<?php echo $this->session->flashdata('changePasswordErrors'); ?>
		<?php unset($_SESSION['changePasswordErrors']); ?>
	</div>
<?php endif; ?>



<?php echo form_open('Authentication/changePassword', $attributes); ?>

<!-- Old Password Input -->
<div class="form-group">
	<?php

	echo form_label('Old Password');
	$data = array(
			'class' => 'form-control',
			'name' => 'existingPassword',
			'placeholder' => 'Enter Old Password',

	);
	echo form_password($data);
	?>
</div>

<!-- New Password Input -->
<div class="form-group">
	<?php

	echo form_label('New Password');
	$data = array(
			'class' => 'form-control',
			'name' => 'newPassword',
			'placeholder' => 'Enter New Password',

	);
	echo form_password($data);
	?>
</div>

<!-- New Password Confirm Input -->
<div class="form-group">
	<?php

	echo form_label('Confirm New Password');
	$data = array(
			'class' => 'form-control',
			'name' => 'confirmNewPassword',
			'placeholder' => 'Confirm New Password',

	);
	echo form_password($data);
	?>
</div>


<!-- Signup Button-->
<div class="form-group">
	<?php
	$data = array(
			'class' => 'btn btn-primary',
			'name' => 'submit',
			'value' => 'Change Password',

	);
	echo form_submit($data);
	?>
</div>


<?php echo form_close(); ?>

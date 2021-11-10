<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>
<!--TODO: Style this page -->
<title>Signup Page</title>
<p class="h1">Registration Form</p><br>

<?php $attributes = array('id' => 'signup_form', 'class' => 'row g-3') ?>

<?php if ($this->session->flashdata('registrationErrors') !== null): ?>
	<div class="alert alert-danger print-error-msg">
		<?php echo $this->session->flashdata('registrationErrors'); ?>
		<?php unset($_SESSION['registrationErrors']); ?>
	</div>
<?php endif; ?>

<?php if ($this->session->flashdata('registrationFailMessage') !== null): ?>
	<div class="alert alert-danger print-error-msg">
		<?php echo $this->session->flashdata('registrationFailMessage'); ?>
		<?php unset($_SESSION['registrationFailMessage']); ?>
	</div>
<?php endif; ?>

<?php if ($this->session->userdata('is_logged_in') == true): ?>
	<div class="alert alert-danger print-error-msg">
		<?php echo "You have already logged in!"; ?>
	</div>
<?php endif; ?>

<?php echo form_open_multipart('Authentication/registrationConfirmation', $attributes); ?>


<!-- Firstname Input -->
<div class="form-group">
	<?php

	echo form_label('First Name');
	$data = array(
			'class' => 'form-control',
			'name' => 'firstname',
			'placeholder' => 'Enter First name',
			'value' => set_value('firstname')
	);
	echo form_input($data);
	?>
</div>

<!-- Lastname Input -->
<div class="form-group">
	<?php

	echo form_label('Last Name');
	$data = array(
			'class' => 'form-control',
			'name' => 'lastname',
			'placeholder' => 'Enter Last Name',
			'value' => set_value('lastname')
	);
	echo form_input($data);
	?>
</div>
<!-- Username Input -->
<div class="form-group">
	<?php

	echo form_label('Username');
	$data = array(
			'class' => 'form-control',
			'name' => 'username',
			'placeholder' => 'Enter Username',
			'value' => set_value('username')
	);
	echo form_input($data);
	?>
</div>

<!-- Email Input -->
<div class="form-group">
	<?php

	echo form_label('Email Address');
	$data = array(
			'class' => 'form-control',
			'name' => 'email_address',
			'placeholder' => 'Enter Email Address',
			'value' => set_value('email_address')
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

<!-- Password Confirm -->
<div class="form-group">
	<?php

	echo form_label('Confirm Password');
	$data = array(
			'class' => 'form-control',
			'name' => 'confirm_password',
			'placeholder' => 'Confirm Password',

	);
	echo form_password($data);
	?>
</div>

<!-- File Upload -->
<div class="form-group">
	<?php

	echo form_label('Image Upload');
	$data = array(
			'class' => 'form-control',
			'name' => 'imageUpload',
			'placeholder' => 'Avatar Image',
			'value' => set_value('imageUpload')
	);
	echo form_upload($data);
	?>
</div>

<!-- Genre Selection -->
<div class="form-group">
	<?php

	echo form_label('Favourite Genre');
	echo "<p class='text-danger'>*Please hold control when selecting more than one genre.</p>";

	$options = array(
			'1' => 'Alternative Rock',
			'2' => 'Blues',
			'3' => 'Classical',
			'4' => 'Country',
			'5' => 'Disco',
			'6' => 'Dubstep',
			'7' => 'Electronic',
			'8' => 'Electronic Dance',
			'9' => 'Folk',
			'10' => 'Funk',
			'11' => 'Heavy Metal',
			'12' => 'Hip Hop',
			'13' => 'House',
			'14' => 'Instrumental',
			'15' => 'Jazz',
			'16' => 'Opera',
			'17' => 'Orchestral',
			'18' => 'Pop',
			'19' => 'Punk Rock',
			'20' => 'Reggae',
			'21' => 'Rhythm and Blues',
			'22' => 'Rock',
			'23' => 'Soul',
			'24' => 'Techno',
	);
	$selected = array('01', '02');


	echo form_multiselect('genreSelection[]', $options, $selected);
	?>
</div>

<!-- Signup Button-->
<?php if ($this->session->userdata('is_logged_in') == true): ?>
	<div class="form-group">
		<?php
		$data = array(
				'class' => 'btn btn-primary disabled',
				'name' => 'submit',
				'value' => 'Signup',

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
				'value' => 'Signup',

		);
		echo form_submit($data);
		?>
	</div>
<?php endif; ?>

<?php echo form_close(); ?>

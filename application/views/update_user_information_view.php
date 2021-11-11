<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>
<title>Update User Details Page</title>
<p class="h1 d-flex justify-content-center">Update User Details Page</p><br>

<?php $attributes = array('id' => 'update_user_information_form', 'class' => 'row g-3') ?>

<!--If there are errors with the form this will be shown-->
<?php if ($this->session->flashdata('updateErrors') !== null): ?>
	<div class="alert alert-danger print-error-msg">
		<?php echo $this->session->flashdata('updateErrors'); ?>
		<?php unset($_SESSION['updateErrors']); ?>
	</div>
<?php endif; ?>

<!--If the update was successful this would be shown-->
<?php if ($this->session->flashdata('updateSuccessMessage') !== null): ?>
	<div class="alert alert-success">
		<?php echo $this->session->flashdata('updateSuccessMessage'); ?>
		<?php unset($_SESSION['updateSuccessMessage']); ?>
	</div>
<?php endif; ?>

<?php echo form_open_multipart('Authentication/updateUserInformation', $attributes); ?>


<!-- Firstname Input -->
<div class="form-group">
	<?php

	echo form_label('First Name');
	$data = array(
			'class' => 'form-control',
			'name' => 'firstname',
			'placeholder' => 'Enter First name',
			'value' => $details['first_name']
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
			'value' => $details['last_name']
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
			'value' => $details['email_address']
	);
	echo form_input($data);
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
	$selected = $genres;

	echo form_multiselect('genreSelection[]', $options, $selected);
	?>
</div>

<!-- Signup Button-->
<div class="form-group">
	<?php
	$data = array(
			'class' => 'btn btn-primary',
			'name' => 'submit',
			'value' => 'Change Details',
	);
	echo form_submit($data);
	?>
</div>

<?php echo form_close(); ?>

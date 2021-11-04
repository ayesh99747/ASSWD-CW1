<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>
<title>Signup Page</title>
<p class="h1">Registration Form</p><br>

<?php $attributes = array('id' => 'signup_form', 'class' => 'row g-3') ?>

<?php if ($this->session->flashdata('registrationErrors') !== null): ?>
	<div class="alert alert-danger print-error-msg">
		<?php echo $this->session->flashdata('registrationErrors'); ?>
		<?php  unset($_SESSION['registrationErrors']);?>
	</div>
<?php endif; ?>

<?php if ($this->session->flashdata('registrationFailMessage') !== null): ?>
	<div class="alert alert-danger print-error-msg">
		<?php echo $this->session->flashdata('registrationFailMessage'); ?>
		<?php  unset($_SESSION['registrationFailMessage']);?>
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

	);
	echo form_upload($data);
	?>
</div>

<!-- Genre Selection -->
<div class="form-group">
	<?php

	echo form_label('Favourite Genre');

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


<!--<form class="row g-3" action="--><?php //echo base_url() ?><!--index.php/Authentication/registrationConfirmation" method=POST>-->
<!--	<div class="form-floating col-md-6">-->
<!--		<input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name">-->
<!--		<label for="firstName" class="form-label">First Name</label>-->
<!--	</div>-->
<!--	<div class="form-floating col-md-6">-->
<!--		<input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name">-->
<!--		<label for="lastName" class="form-label">Last Name</label>-->
<!--	</div>-->
<!---->
<!--	<div class="form-floating col-12">-->
<!--		<input type="text" class="form-control" id="username" name="username" placeholder="Username">-->
<!--		<label for="userName" class="form-label">Username</label>-->
<!--	</div>-->
<!---->
<!--	<div class="form-floating col-12">-->
<!--		<input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="Email Address">-->
<!--		<label for="emailAddress">Email address</label>-->
<!--	</div>-->
<!---->
<!--	<div class="form-floating col-md-6">-->
<!--		<input type="password" class="form-control" id="password" name="password" placeholder="Password">-->
<!--		<label for="password" class="form-label">Password</label>-->
<!--	</div>-->
<!--	<div class="form-floating col-md-6">-->
<!--		<input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">-->
<!--		<label for="confirmPassword" class="form-label">Confirm Password</label>-->
<!--	</div>-->
<!---->
<!--	<div class="col-12">-->
<!--		<label for="imageUpload" class="form-label">Please Upload an Image - </label>-->
<!--		<input class="form-control" type="file" id="imageUpload" name="imageUpload">-->
<!--	</div>-->
<!---->
<!---->
<!--	<label for="genreSelection" class="form-label">Please chose your favourite genres - </label>-->
<!--	<div class="side-by-side clearfix ">-->
<!--		<select data-placeholder="Chose your favourite genres" class="chosen-select" multiple id="genreSelection" name="genreSelection">-->
<!--			<option value="Alternative Rock">Alternative Rock</option>-->
<!--			<option value="Blues">Blues</option>-->
<!--			<option value="Classical">Classical</option>-->
<!--			<option value="Country">Country</option>-->
<!--			<option value="Disco">Disco</option>-->
<!--			<option value="Dubstep">Dubstep</option>-->
<!--			<option value="Electronic">Electronic</option>-->
<!--			<option value="Electronic Dance">Electronic Dance</option>-->
<!--			<option value="Folk">Folk</option>-->
<!--			<option value="Funk">Funk</option>-->
<!--			<option value="Heavy Metal">Heavy Metal</option>-->
<!--			<option value="Hip Hop">Hip Hop</option>-->
<!--			<option value="House">House</option>-->
<!--			<option value="Instrumental">Instrumental</option>-->
<!--			<option value="Jazz">Jazz</option>-->
<!--			<option value="Opera">Opera</option>-->
<!--			<option value="Orchestral">Orchestral</option>-->
<!--			<option value="Pop">Pop</option>-->
<!--			<option value="Punk Rock">Punk Rock</option>-->
<!--			<option value="Reggae">Reggae</option>-->
<!--			<option value="Rhythm and Blues">Rhythm and Blues</option>-->
<!--			<option value="Rock">Rock</option>-->
<!--			<option value="Soul">Soul</option>-->
<!--			<option value="Techno">Techno</option>-->
<!--		</select>-->
<!--	</div>-->
<!---->
<!--	<div class="col-12">-->
<!--		<button type="submit" class="btn btn-primary">Sign Up</button>-->
<!--	</div>-->
<!--</form>-->

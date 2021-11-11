<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>
<!--TODO: Style this page -->
<title>Private Home Page</title>
<div class="row">
	<div class="d-flex justify-content-center">
		<p class="h1 d-flex justify-content-center">Private Home Page</p><br>
</div>
<br>

<div class="row">
	<!-- Form to create a new post -->
	<?php $attributes = array('id' => 'new_post_form', 'class' => 'row g-3') ?>

	<!-- Display Post Creation Error Messages -->
	<?php if ($this->session->flashdata('postCreationErrors')): ?>
		<!--TODO: Fix position where error messages are shown-->
		<div class="alert alert-danger print-error-msg form-group">
			<?php echo $this->session->flashdata('postCreationErrors'); ?>
			<?php unset($_SESSION['postCreationErrors']); ?>
		</div>
	<?php endif; ?>
	<div class="d-flex justify-content-center">
		<?php echo form_open('Post/createPost', $attributes); ?>

		<!-- Text Area Input -->
		<div class="form-group">
			<?php

			echo form_label('Post Text');
			$data = array(
					'class' => 'form-control',
					'name' => 'postText',
					'maxlength' => '10000',
					'placeholder' => 'Enter Text',

			);
			echo form_textarea($data);
			?>
		</div>

		<!-- Submit Post Button-->
		<div class="form-group">
			<?php
			$data = array(
					'class' => 'btn btn-primary',
					'name' => 'submit',
					'value' => 'Submit Post',

			);
			echo form_submit($data);
			?>
		</div>

		<?php echo form_close(); ?>
	</div>

</div>

</div>
<br>
<hr>
<div class="row">
	<div class="d-flex justify-content-center">
		<p class="h1">Latest Posts</p></div>
</div>

<div class="row">

	<div class="col-2">

	</div>
	<div class="col-8">
		<?php foreach ($posts as $row): ?>
			<p class="h3">
				@<?php echo $row['username'] ?>
			</p><br>
			<p class="h4">
				<?php echo $row['post']; ?>
			</p><br>
			<p class="h6 text-end">
				Time posted : <?php echo $row['timestamp']; ?>
			</p>
			<hr><br>
		<?php endforeach; ?>

	</div>
	<div class="col-2">

	</div>
</div>



<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>

<title>Private Home Page</title>


<div class="row">
	<div class="d-flex justify-content-center">
		<p class="h1">Private Home Page</p></div>
</div>
<br>

<div class="row">
	<div class="col-2"></div>

	<div class="col-8">
		<div class="d-flex justify-content-center">
			<!--			<div class="row">-->
			<!--				-->
			<!--			</div>-->

			<!-- Form to create a new post -->

			<?php $attributes = array('id' => 'new_post_form', 'class' => 'row g-3') ?>

			<!-- Display Error Messages -->
			<?php if ($this->session->flashdata('postCreationErrors')): ?>
				<div class="alert alert-danger print-error-msg">
					<?php echo $this->session->flashdata('postCreationErrors'); ?>
					<?php unset($_SESSION['postCreationErrors']); ?>
				</div>
			<?php endif; ?>

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


	<div class="col-2">

	</div>
</div>
<br>

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
				<?php echo $row['username'] ?>
			</p>
			<p class="h4">
				<!--				--><?php //echo $row['post'] ?>
				<?php

				$text = strip_tags($row['post']);
				$textWithLinks = preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank" rel="nofollow">$1</a>', $text);
				echo $textWithLinks;
				?>
			</p>
			<hr><br>
		<?php endforeach; ?>

	</div>
	<div class="col-2">

	</div>
</div>

<script>

</script>


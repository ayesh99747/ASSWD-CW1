<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>

<title>Search Users By Genre Page</title>
<p class="h1">Search User By Genre</p><br>

<?php $attributes = array('id' => 'search_by_Genre_Form', 'class' => 'row g-3') ?>
<?php echo form_open('User/getUsersByGenre', $attributes); ?>

<!-- Drop Down Genre Input -->
<div class="form-group">
	<?php
	$genreArray = array();
	foreach ($genres as $genre) {
		array_push($genreArray, $genre['genre']);
	}

	echo form_label('Genre');
	$data = array(
			'class' => 'form-control',
			'name' => 'genre_dropdown',
			'options' => $genreArray,

	);
	echo form_dropdown($data);
	?>
</div>

<!-- Submit Button-->
<div class="form-group">
	<?php
	$data = array(
			'class' => 'btn btn-primary',
			'name' => 'submit',
			'value' => 'Submit',

	);
	echo form_submit($data);
	?>
</div>


<?php echo form_close(); ?>
<br><br>
<hr>

<?php if (isset($user_details)): ?>
	<?php if ($user_details === false): ?>
		<div class="row">
			<div class="d-flex justify-content-center">
				<h2>No users were found!</h2>
			</div>
		</div>
	<?php else: ?>
		<?php foreach ($user_details as $user_detail): ?>
			<div class="row">
				<div class="d-flex justify-content-center">
					<div class="col-6">
						<img src="\cw1\assets\uploads\<?php echo $user_detail['profile_picture_location']; ?>"
							 width="300"
							 height="300" alt="">
					</div>
					<div class="col-6">
						<h1 class="profile-user-name">Username : @<?php echo $user_detail['username']; ?></h1>
						<br>
						<h2 class="profile-user-name">Name :
							<a href="<?php echo base_url() ?>index.php/User/viewPublicHomePage/<?php echo $user_detail['username']; ?>"
							   target="_blank"><?php echo $user_detail['first_name']; ?> <?php echo $user_detail['last_name']; ?>
						</h2></a>
						<br>
						<a class="btn btn-primary"
						   href="<?php echo base_url() ?>index.php/User/followUser/<?php echo $user_detail['username']; ?>"
						   target="_blank">Follow</a>
					</div>
				</div>
			</div>
			<hr>
		<?php endforeach; ?>
	<?php endif; ?>
<?php endif; ?>

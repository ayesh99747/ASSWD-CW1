<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>

<title>Search Users By Genre Page</title>
<p class="h1">Search User By Genre</p><br>

<?php $attributes = array('id' => 'search_by_Genre_Form', 'class' => 'row g-3') ?>
<?php echo form_open('User/getGenreSelection', $attributes); ?>

<?php if (isset($selectedGenreNumber)):?>
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
			'selected' => $selectedGenreNumber

	);
	echo form_dropdown($data);
	?>
</div>
<?php else:?>
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
<?php endif;?>
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


<?php if (isset($user_details)): ?>
	<?php if ($user_details === false): ?>
		<div class="row">
			<div class="d-flex justify-content-center">
				<h2>No users were found!</h2>
			</div>
		</div>
	<?php else: ?>
		<hr>
		<?php foreach ($user_details as $user_detail): ?>
			<div class="card-body">
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
							<a href="<?php echo base_url() ?>index.php/publicHomePage/<?php echo $user_detail['username']; ?>"><?php echo $user_detail['first_name'] . " " . $user_detail['last_name']; ?>
						</h2></a>
						<br>
						<?php if ($user_detail['isFollowed'] == true): ?>
							<a class="btn btn-primary"
							   href="<?php echo base_url() ?>index.php/User/unfollowUser/<?php echo $main_view; ?>/<?php echo $user_detail['username']; ?>/<?php echo $selectedGenreNumber; ?>">Unfollow</a>
						<?php else: ?>
							<a class="btn btn-primary"
							   href="<?php echo base_url() ?>index.php/User/followUser/<?php echo $main_view; ?>/<?php echo $user_detail['username']; ?>/<?php echo $selectedGenreNumber; ?>">Follow</a>
						<?php endif; ?>
						<?php if ($user_detail['isFriend'] == true): ?>
							<span class="badge rounded-pill bg-success">Friend</span>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<hr>
		<?php endforeach; ?>
	<?php endif; ?>
<?php endif; ?>

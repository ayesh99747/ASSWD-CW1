<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>

<title>View Followers Page</title>
<p class="h1 d-flex justify-content-center"><?php echo $view_name; ?></p><br>

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
							   href="<?php echo base_url() ?>index.php/User/unfollowUser/<?php echo $view_name; ?>/<?php echo $user_detail['username']; ?>">Unfollow</a>
						<?php else: ?>
							<a class="btn btn-primary"
							   href="<?php echo base_url() ?>index.php/User/followUser/<?php echo $view_name; ?>/<?php echo $user_detail['username']; ?>">Follow</a>
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

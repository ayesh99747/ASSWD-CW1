<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>

<title>Public Home Page</title>

<div class="row">
	<div class="d-flex justify-content-center">
		<p class="h1 d-flex justify-content-center">Public Home Page</p><br>
	</div>
	<br>
	<hr>
	<div class="row">
		<div class="d-flex justify-content-center">


			<div class="col-6">

				<img src="\cw1\assets\uploads\<?php echo $user_details['profile_picture_location']; ?>" alt=""
					 width="300" height="300" class="img-thumbnail">

			</div>

			<div class="col-6">

				<h1 class="profile-user-name">Username : @<?php echo $user_details['username']; ?></h1>
				<br>
				<h2 class="profile-user-name">Name
					: <?php echo $user_details['first_name']; ?> <?php echo $user_details['last_name']; ?></h2>
				<br>
				<h3>Stats : </h3>
				<ul>
					<li><span class="profile-stat-count"><?php echo $numberOfPosts; ?></span> posts</li>
					<li><span class="profile-stat-count"><?php echo $user_details['numberOfFollowers']; ?></span>
						followers
					</li>
					<li><span class="profile-stat-count"><?php echo $user_details['numberOfFollowing']; ?></span>
						following
					</li>
					<li><span class="profile-stat-count"><?php echo $user_details['numberOfFriends']; ?></span> friends
					</li>
				</ul>

				<?php if (isset($user_details['isFollowed'])): ?>
					<?php if ($user_details['isFollowed'] == true): ?>
						<a class="btn btn-primary"
						   href="<?php echo base_url() ?>index.php/User/unfollowUser/<?php echo $view_name; ?>/<?php echo $user_details['username']; ?>">Unfollow</a>
					<?php else: ?>
						<a class="btn btn-primary"
						   href="<?php echo base_url() ?>index.php/User/followUser/<?php echo $view_name; ?>/<?php echo $user_details['username']; ?>">Follow</a>
					<?php endif; ?>
				<?php endif; ?>

				<?php if (isset($user_details['isFriend'])): ?>
					<?php if ($user_details['isFriend'] == true): ?>
						<span class="badge rounded-pill bg-success">Friend</span>
					<?php endif; ?>
				<?php endif; ?>

			</div>
		</div>

	</div>

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
					<?php echo $row['username'] ?>
				</p>
				<p class="h4">
					<?php echo $row['post']; ?>
				</p>
				<p class="h6 text-end">
					Time : <?php echo $row['timestamp']; ?>
				</p>
				<hr><br>
			<?php endforeach; ?>

		</div>
		<div class="col-2">

		</div>
	</div>




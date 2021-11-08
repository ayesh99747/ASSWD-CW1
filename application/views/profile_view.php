<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>

<title>Private Home Page</title>

<div class="row">
	<div class="d-flex justify-content-center">
		<p class="h1"> <?php echo $view_name; ?></p></div>
</div>
<br>

<div class="row">
	<div class="d-flex justify-content-center">


		<div class="col-6">

			<img src="\cw1\assets\uploads\<?php echo $user_details['profile_picture_location']; ?>" width="300"
				 height="300" alt="">

		</div>

		<div class="col-6">

			<h1 class="profile-user-name">Username : @<?php echo $user_details['username']; ?></h1>
			<br>
			<h2 class="profile-user-name">Name
				: <?php echo $user_details['first_name']; ?> <?php echo $user_details['last_name']; ?></h2>
			<br>
			<h3>Stats : </h3>
			<ul>
<!--				TODO: Make stats dynamic-->
				<li><span class="profile-stat-count">164</span> posts</li>
				<li><span class="profile-stat-count">188</span> followers</li>
				<li><span class="profile-stat-count">206</span> following</li>
				<li><span class="profile-stat-count">206</span> friends</li>
			</ul>

			<?php if ($user_details['isFollowed'] == true): ?>
				<a class="btn btn-primary"
				   href="<?php echo base_url() ?>index.php/User/unfollowUser/<?php echo $view_name; ?>/<?php echo $user_details['username']; ?>">Unfollow</a>
			<?php else: ?>
				<a class="btn btn-primary"
				   href="<?php echo base_url() ?>index.php/User/followUser/<?php echo $view_name; ?>/<?php echo $user_details['username']; ?>">Follow</a>
			<?php endif; ?>
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
		<hr>
		<?php foreach ($posts as $row): ?>
			<p class="h3">
				<?php echo $row['username'] ?>
			</p>
			<p class="h4">
				<!--				--><?php //echo $row['post'] ?>
				<?php
				// TODO: Extract the images from the text.
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

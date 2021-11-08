<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>

<title>Public Home Page</title>

<div class="row">
	<div class="d-flex justify-content-center">
		<p class="h1">Profile View</p></div>
</div>
<br>
<hr>
<div class="row">
	<div class="d-flex justify-content-center">


		<div class="col-6">

			<img src="\cw1\assets\uploads\<?php echo $user_details['profile_picture_location']; ?>" alt="" width="300"
				 height="300">

		</div>

		<div class="col-6">

			<h1 class="profile-user-name">Username : @<?php echo $user_details['username']; ?></h1>
			<br>
			<h2 class="profile-user-name">Name
				: <?php echo $user_details['first_name']; ?> <?php echo $user_details['last_name']; ?></h2>
			<br>
			<h3>Stats : </h3>
			<ul><!--TODO: Make stats dynamic-->
				<li><span class="profile-stat-count">164</span> posts</li>
				<li><span class="profile-stat-count">188</span> followers</li>
				<li><span class="profile-stat-count">206</span> following</li>
				<li><span class="profile-stat-count">206</span> friends</li>
			</ul>
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




<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>

<title>Private Home Page</title>

<div class="row">
	<div class="d-flex justify-content-center">
		<p class="h1">Profile View</p></div>
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
				<li><span class="profile-stat-count">164</span> posts</li>
				<li><span class="profile-stat-count">188</span> followers</li>
				<li><span class="profile-stat-count">206</span> following</li>
				<li><span class="profile-stat-count">206</span> friends</li>
			</ul>
		</div>
	</div>

</div>



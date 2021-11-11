<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link href="\cw1\assets\css\bootstrap.min.css" rel="stylesheet">
	<script src="\cw1\assets\js\bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
	<div class="row">
		<?php if ($this->session->userdata('is_logged_in') == true): ?>
			<nav class="navbar navbar-light bg-light">
				<div class="container">
					<a class="navbar-brand"
					   href="<?php echo base_url() ?>index.php/privateHomePage/<?php echo $this->session->username ?>">
						<img src="\cw1\assets\logos\TrebleLogo.svg" alt="" width="50" height="50">
						Treble
					</a>
				</div>
				<ul class="nav nav-pills justify-content-end ">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							User Information
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							<li class="nav-item">
								<a class="nav-link"
								   href="<?php echo base_url() ?>index.php/followers/<?php echo $this->session->username; ?>"
								   >View Followers</a>
							</li>
							<li class="nav-item">
								<a class="nav-link"
								   href="<?php echo base_url() ?>index.php/following/<?php echo $this->session->username; ?>"
								   >View Following</a>
							</li>
							<li class="nav-item">
								<a class="nav-link "
								   href="<?php echo base_url() ?>index.php/publicHomePage/<?php echo $this->session->username; ?>"
								   >View Profile</a>
							</li>
						</ul>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url() ?>index.php/searchUsersByGenre">Search Users</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url() ?>index.php/logout">Logout</a>
					</li>
				</ul>
			</nav>
		<?php else: ?>
			<nav class="navbar navbar-light bg-light">
				<div class="container">
					<a class="navbar-brand" href="<?php echo base_url() ?>index.php/Home">
						<img src="\cw1\assets\logos\TrebleLogo.svg" alt="" width="50" height="50">
						Treble
					</a>
				</div>
				<ul class="nav nav-pills justify-content-end">
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url() ?>index.php/login"
						   >Login</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url() ?>index.php/registration">Register</a>
					</li>
				</ul>
			</nav>
		<?php endif; ?>
	</div>
</div>
<br>
<div class="container">
	<?php $this->load->view($main_view); ?>
</div>

</body>
</html>

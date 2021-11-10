<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link href="\cw1\assets\css\bootstrap.min.css" rel="stylesheet">
	<script src="\cw1\assets\js\bootstrap.min.js"></script>
	<style>
		.navigation-buttons{
			margin-right:16px;
			margin-bottom:16px;
			margin-top:16px;
		}
	</style>
</head>
<body>

<div class="container-fluid">
	<div class="row">
		<?php if ($this->session->userdata('is_logged_in') == true): ?>
			<div class="col-md-4">
				<div class="d-flex justify-content-start">
					<a href="<?php echo base_url() ?>index.php/privateHomePage/<?php echo $this->session->username ?>">
						<img src="\cw1\assets\logos\TREBLE.svg" alt="Treble Logo" width="100" height="100">
					</a>
				</div>
			</div>
			<div class="col-md-8">
				<div class="d-flex justify-content-end">
					<a class="btn btn-primary navigation-buttons" href="<?php echo base_url() ?>index.php/followers/<?php echo $this->session->username; ?>"
					   role="button">View Followers</a>
					<a class="btn btn-primary navigation-buttons" href="<?php echo base_url() ?>index.php/following/<?php echo $this->session->username; ?>"
					   role="button">View Following</a>
					<a class="btn btn-primary navigation-buttons" href="<?php echo base_url() ?>index.php/searchUsersByGenre"
					   role="button">Search Users</a>
					<a class="btn btn-primary navigation-buttons" href="<?php echo base_url() ?>index.php/publicHomePage/<?php echo $this->session->username; ?>"
					   role="button">View Profile</a>
					<a class="btn btn-primary navigation-buttons" href="<?php echo base_url() ?>index.php/logout"
					   role="button">Logout</a>
				</div>
			</div>
		<?php else: ?>
			<div class="col-md-8">
				<div class="d-flex justify-content-start">
					<a href="<?php echo base_url() ?>index.php/Home">
						<img src="\cw1\assets\logos\TREBLE.svg" alt="Treble Logo" width="100" height="100">
					</a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="d-flex justify-content-end">
					<a class="btn btn-primary navigation-buttons" href="<?php echo base_url() ?>index.php/login"
					   role="button">Login</a>
					<a class="btn btn-primary navigation-buttons" href="<?php echo base_url() ?>index.php/registration"
					   role="button">Register</a>
				</div>
			</div>
		<?php endif; ?>



	</div>

</div>

<div class="container">
	<?php $this->load->view($main_view); ?>
</div>

</body>
</html>

<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
		  integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
			integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
			crossorigin="anonymous"></script>

</head>
<body>


<div class="container-fluid">
	<div class="row">
		<?php if ($this->session->userdata('is_logged_in') == true): ?>
			<div class="col-md-8">
				<div class="d-flex justify-content-start">
					<a href="<?php echo base_url() ?>index.php/Home">
						<img src="\cw1\assets\logos\TREBLE - Black Logo.png" alt="Treble Logo" width="100" height="100">
					</a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="d-flex justify-content-end">
					<a class="btn btn-primary" href="<?php echo base_url() ?>index.php/Authentication/logout"
					   role="button">Logout</a>
				</div>
			</div>
		<?php else: ?>
			<div class="col-md-8">
				<div class="d-flex justify-content-start">
					<a href="<?php echo base_url() ?>index.php/Home">
						<img src="\cw1\assets\logos\TREBLE - Black Logo.png" alt="Treble Logo" width="100" height="100">
					</a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="d-flex justify-content-end">
					<a class="btn btn-primary" href="<?php echo base_url() ?>index.php/Authentication/loginForm"
					   role="button">Login</a>
					<a class="btn btn-primary" href="<?php echo base_url() ?>index.php/Authentication/signUpForm"
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

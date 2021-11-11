<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<style>
	.main-page-buttons{
		margin-right: 20px;
		margin-left: 20px;
		margin-top: 20px;
		margin-bottom: 20px;
	}
</style>
<title>Home Page</title>
<br><br><br>
<div class="row">
	<div class="col-4">
		<img src="/cw1/assets/logos/TREBLE2.svg" alt="Treble Logo" height="400" width="600">
	</div>
	<div class="col-2"></div>
	<div class="col-4">
		<br><br>
		<p class="text-center display-2">
			Treble is the best social network for music lovers!
		</p>
	</div>
</div>
<br>


<br><br><br>
<p class="text-center h6">
	Create your account or login to get in on the action today!
</p>
<div class="d-flex justify-content-center">

	<a class="btn btn-primary main-page-buttons" href="<?php echo base_url() ?>index.php/login"
	   role="button">Login</a>

	<a class="btn btn-primary main-page-buttons" href="<?php echo base_url() ?>index.php/registration"
	   role="button">Register</a>

</div>

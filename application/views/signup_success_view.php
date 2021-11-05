<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>
<title>Signup Success Page</title>
<p class="h1">Registration Confirmation</p><br>

<?php if ($this->session->flashdata('registrationSuccessMessage') !== null): ?>
	<div class="alert alert-success">
		<?php echo $this->session->flashdata('registrationSuccessMessage'); ?>
		<?php unset($_SESSION['registrationSuccessMessage']); ?>
	</div>
<?php endif; ?>

<p class="h3">Welcome <?php echo $name ?> ! You can now proceed to the <a
			href="<?php echo base_url() ?>index.php/User/viewPrivateHomePage/">home page.</a></p><br>



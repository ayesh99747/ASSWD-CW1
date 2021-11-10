<?php

defined('BASEPATH') or exit('No direct script access allowed');
?>
<title>Signup Success Page</title>
<p class="h1">Registration Confirmation</p><br>

<?php if ($this->session->flashdata('registrationSuccessMessage') !== null): ?>
	<div class="alert alert-success">
		<?php echo $this->session->flashdata('registrationSuccessMessage'); ?>
	</div>
<?php endif; ?>

<p class="h3">Welcome <?php echo $name ?> ! Please verify your email by clicking on the link our team has sent you.
			Once your email has been successfully verified, you can proceed to the <a
			href="<?php echo base_url() ?>index.php/login/">login page.</a></p><br>



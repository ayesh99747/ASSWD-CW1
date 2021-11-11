<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authentication extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	// The following function is used to display the login form.
	public function loginForm()
	{
		$data['main_view'] = "login_view";
		$this->load->view('main', $data);
	}

	// The following function is used to display the signup form.
	public function signUpForm()
	{
		$data['main_view'] = "signup_view";
		$this->load->view('main', $data);
	}

	// The following function is used to display the signup success view.
	public function signUpSuccessView()
	{
		$username = $this->session->userdata('username');
		$name = $this->users->getNameByUsername($username);
		$data = array(
			'name' => $name,
			'main_view' => 'signup_success_view'
		);
		$this->load->view('main', $data);
	}

	// The following function is used to confirm the registration.
	public function registrationConfirmation()
	{
		// Setting the form validations for the signup form.
		$this->form_validation->set_rules('firstname', 'First Name', 'trim|required|min_length[3]|max_length[64]');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|min_length[3]|max_length[64]');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[20]|is_unique[users.username]');
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|min_length[3]|is_unique[users.email_address]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|min_length[3]|matches[password]');
		if (empty($_FILES['imageUpload']['name'])) {
			$this->form_validation->set_rules('imageUpload', 'Image Upload', 'required');
		}
		$this->form_validation->set_rules('genreSelection[]', 'Favourite Genre', 'trim|required');

		// Checking if the form_validation couldn't run and outputing the errors
		if ($this->form_validation->run() == FALSE) {
			$data = array(
				'registrationErrors' => validation_errors()
			);
			$this->session->set_flashdata($data);
			redirect('registration', 'refresh');
		} else {
			// Retrieving all the data from the post and assigning them to variables.
			$firstname = $this->input->post('firstname');
			$lastname = $this->input->post('lastname');
			$username = $this->input->post('username');
			$emailAddress = $this->input->post('email_address');
			$password = $this->input->post('password');

			// Creating the configurations for the user image.
			$config['upload_path'] = './assets/uploads';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = 2000;
			$config['max_width'] = 1200;
			$config['max_height'] = 1200;
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('imageUpload')) {
				// If the image upload fails the following code will be executed.
				$this->session->set_flashdata('registrationFailMessage', $this->upload->display_errors());
				log_message('debug', "Registration Failed,  unable to upload file - " . $username);
				log_message('debug', $this->upload->display_errors());
				redirect('registration', 'refresh');
			} else {
				// If the image upload succeeds the following code will be executed.
				$data = array('upload_data' => $this->upload->data());
				$fileName = $data['upload_data']['file_name'];
				$isUploadSuccess = true;
				log_message('debug', "File Upload success - " . $fileName);

				// Inserting new user to database
				$isUserAddition = $this->users->createNewUser($username, $firstname, $lastname, $emailAddress, $password, $fileName);
				if ($isUserAddition & $isUploadSuccess) {
					log_message('debug', "User Addition Success - " . $username);

					// Adding new Genre-User Associations
					$isGenreAdditionSuccess = false;
					foreach ($this->input->post('genreSelection') as $genre) {
						$this->genreuser->addGenreToUser($username, $genre);
						log_message('debug', "Genre Added - " . $genre);
						$isGenreAdditionSuccess = true;
					}
					if ($isGenreAdditionSuccess) {
						log_message('debug', "Genre Addition Success - " . $username);
						$sendResult = $this->sendVerificationEmail($emailAddress); // Sending verification email to user.
						if ($sendResult) {
							// If the email was sent successfully.
							log_message('debug', "Email Send Success - " . $username);
							$this->session->set_flashdata('registrationSuccessMessage', "You have successfully registered!");
							redirect('signUpSuccess');
						} else {
							// If the email was not sent successfully.
							log_message('debug', "Error Sending Email - " . $username);
							$this->session->set_flashdata('registrationSuccessMessage', "Unable to send verification email, but registration successful!");
							// By passing the email verification as it does not work on the westminster server.
							$this->users->verifyEmailAddress(md5($emailAddress));
							redirect('signUpSuccess');
						}
					}
				} else {
					// If the user addition fails or image upload fails, the following code will be executed.
					$this->session->set_flashdata('registrationFailMessage', "Sorry, your registration failed!");
					log_message('debug', "Registration Fail - " . $username);
					redirect('registration');
				}
			}
		}
	}

	// The following function is used to send a verification email to the user
	public function sendVerificationEmail($userEmail)
	{
		$fromEmail = 'madara.2018072@iit.ac.lk';
		$emailSubject = 'Verify Your Email Address';
		$emailMessage = 'Dear User,
					<br /><br />
					Please click on the below activation link to verify your email address.
					<br /><br /> 
					https://w1714881.users.ecs.westminster.ac.uk/cw1/index.php/emailVerification/' . md5($userEmail) . '
					<br /><br /><br />
					Thanks,<br />
					Treble Team';

		// Email Configuration Settings
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'smtp-relay.sendinblue.com'; //smtp host name
		$config['smtp_port'] = '587'; //smtp port number
		$config['smtp_user'] = $fromEmail;
		$config['smtp_pass'] = 'vtJjN3MD5CH2K18F';
		$config['mailtype'] = 'html';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['newline'] = "\r\n";
		$this->email->initialize($config);

		// Code to send the email
		$this->email->from($fromEmail, 'Treble Team');
		$this->email->to($userEmail);
		$this->email->subject($emailSubject);
		$this->email->message($emailMessage);
		return $this->email->send();
	}

	// This function will verify the email address
	public function verifyEmail()
	{
		$emailHash = $this->uri->segment(2);
		$result = $this->users->verifyEmailAddress($emailHash);
		if ($result != null) {
			switch ($result) {
				case 1:
					// If the email verification was successful.
					log_message('debug', "Email Verification Success - " . $emailHash);
					$data = array(
						'name' => 'Email Verification Success',
						'main_view' => 'email_verification_view',
						'isSuccess' => true
					);
					$this->load->view('main', $data);
					break;
				case 2:
					// If the email verification was unsuccessful.
					log_message('debug', "Email Verification Fail - " . $emailHash);
					$data = array(
						'name' => 'Email Verification Fail',
						'main_view' => 'email_verification_view',
						'isSuccess' => false
					);
					$this->load->view('main', $data);
					break;
				case 3:
					// If the email verification has already been performed.
					log_message('debug', "Email Verification Already Completed - " . $emailHash);
					$data = array(
						'name' => 'Email Verification Completed',
						'main_view' => 'email_verification_view',
						'code' => 1
					);
					$this->load->view('main', $data);
					break;
				case 4:
					// If the email provided does not exist.
					log_message('debug', "Email Does not exist - " . $emailHash);
					$data = array(
						'name' => 'Key provided does not exist',
						'main_view' => 'email_verification_view',
						'code' => 2
					);
					$this->load->view('main', $data);
					break;
			}
		} else {
			// If the email verification has been unsuccessful for any other reason.
			log_message('debug', "Email Verification Fail - " . $emailHash);
			$data = array(
				'name' => 'Email Verification Fail',
				'main_view' => 'email_verification_view',
				'isSuccess' => false
			);
		}

	}

	// The following function is used when logging in
	public function login()
	{
		// The following code validates the form fields.
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]');

		if ($this->form_validation->run() == FALSE) {
			$data = array(
				'loginErrors' => validation_errors()
			);
			$this->session->set_flashdata($data);
			redirect('login');
		} else {
			// Retrieving the post data from the form.
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			if ($this->users->isEmailAddressVerified($username)) {
				// If the email address is verified, this code will be executed.
				if ($this->users->authenticateUser($username, $password)) {
					// This code checks the db if the username and password matches.
					// Then logs the user in by setting the sessions.
					$this->session->is_logged_in = true;
					$this->session->username = $username;
					log_message('debug', "Login Success - " . $username);
					redirect('privateHomePage/' . $username);
				} else {
					// If the username or password does not match.
					log_message('debug', "Login Fail - " . $username);
					$data = array(
						'loginErrors' => "Username or Password provided is wrong."
					);
					$this->session->set_flashdata($data);
					$this->session->login_error = True;
					redirect('login');
				}
			} else {
				// If the email address is not verified, this code will be executed.
				log_message('debug', "Login Fail - " . $username);
				$data = array(
					'loginErrors' => "Please verify your email address!"
				);
				$this->session->set_flashdata($data);
				$this->session->login_error = True;
				redirect('login');
			}
		}

	}

	// The following function is used to view the change password form.
	public function changePasswordForm()
	{
		if ($this->session->is_logged_in == true) {
			$data = array(
				'main_view' => 'change_password_view'
			);
			$this->load->view('main', $data);
		}
	}

	// The following function is used to process the data related to the change password form
	public function changePassword()
	{
		// The following code validates the form fields.
		$this->form_validation->set_rules('existingPassword', 'Old Password', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('newPassword', 'New Password', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('confirmNewPassword', 'Confirm New Password', 'trim|required|min_length[3]|matches[newPassword]');

		if ($this->form_validation->run() == FALSE) {
			$data = array(
				'changePasswordErrors' => validation_errors()
			);
			$this->session->set_flashdata($data);
			redirect('changePassword');
		} else {
			// Retrieving the post data from the form.
			$existingPassword = $this->input->post('existingPassword');
			$newPassword = $this->input->post('newPassword');
			$username = $this->session->username;

			// First we check if the user exists.
			if ($this->users->authenticateUser($username, $existingPassword)) {
				// If the user exists we update the password.
				if ($this->users->changePassword($username, $newPassword)) {
					log_message('debug', "Change Password Success - " . $username);
					$this->logout();
					redirect('login');
				} else {
					log_message('debug', "Change Password Failed - " . $username);
					$data = array(
						'changePasswordErrors' => "Error while updating password!"
					);
					$this->session->set_flashdata($data);
					$this->session->login_error = True;
					redirect('changePassword');
				}
			} else {
				// If the user doesn't exist this error will be displayed.
				log_message('debug', "Change Password Failed - " . $username);
				$data = array(
					'changePasswordErrors' => "Username and old Password does not match!"
				);
				$this->session->set_flashdata($data);
				$this->session->login_error = True;
				redirect('changePassword');
			}
		}
	}

	// This function is used to display the update user information form.
	public function updateUserInformationForm()
	{
		if ($this->session->is_logged_in == true) {
			$details = $this->users->getDetailsByUsername($this->session->username);
			$genreArray = $this->genreuser->getGenresByUser($this->session->username);
			$data = array(
				'main_view' => 'update_user_information_view',
				'details' => $details,
				'genres' => $genreArray

			);
			$this->load->view('main', $data);
		}
	}

	// This function is used to update the user information
	public function updateUserInformation()
	{
		// Setting the form validations for the signup form.
		$this->form_validation->set_rules('firstname', 'First Name', 'trim|required|min_length[3]|max_length[64]');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|min_length[3]|max_length[64]');
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|min_length[3]');
		$this->form_validation->set_rules('genreSelection[]', 'Favourite Genre', 'trim');

		// Checking if the form_validation couldn't run and outputing the errors
		if ($this->form_validation->run() == FALSE) {
			$data = array(
				'updateErrors' => validation_errors()
			);
			$this->session->set_flashdata($data);
			redirect('updateUserInfo', 'refresh');
		} else {
			// Retrieving all the data from the post and assigning them to variables.
			$firstname = $this->input->post('firstname');
			$lastname = $this->input->post('lastname');
			$username = $this->session->username;
			$emailAddress = $this->input->post('email_address');

			// Here we will be updating the user details.
			if ($this->users->updateUserDetails($username, $firstname, $lastname, $emailAddress)) {
				log_message('debug', "User Details update Success - " . $username);
				$sendResult = $this->sendVerificationEmail($emailAddress); // Sending verification email to user.
				if ($sendResult) {
					log_message('debug', "Email Send Success - " . $username);
				} else {
					log_message('debug', "Email Send Fail - " . $username);
					$this->users->verifyEmailAddress(md5($emailAddress));
				}
			}

			// Here we will be updating the genres that the user has selected.
			if ($this->input->post('genreSelection') != null) {
				if ($this->genreuser->deleteGenresByUser($username)) {
					foreach ($this->input->post('genreSelection') as $genre) {
						$this->genreuser->addGenreToUser($username, $genre);

					}
					log_message('debug', "Genre Update Successful - " . $genre);
				}
			}
			// If the user details update was successful
			$data = array(
				'updateSuccessMessage' => "Update was Successful!"
			);
			$this->session->set_flashdata($data);
			redirect('updateUserInfo');
		}
	}


// The following function is used when the user logs out.
	public function logout()
	{
		$array = array('is_logged_in', 'username');
		$this->session->unset_userdata($array);
		$this->session->sess_destroy();
		redirect('home');
	}
}

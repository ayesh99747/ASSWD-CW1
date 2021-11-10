<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authentication extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('users');
		$this->load->model('genreuser');
	}

	public function index()
	{
		$data['main_view'] = "home_view";
		$this->load->view('main', $data);
	}

	public function loginForm()
	{
		$data['main_view'] = "login_view";
		$this->load->view('main', $data);
	}

	public function signUpForm()
	{
		$data['main_view'] = "signup_view";
		$this->load->view('main', $data);
	}

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

	public function registrationConfirmation()
	{
		$this->form_validation->set_rules('firstname', 'First Name', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|is_unique[users.username]');
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
			redirect('registration');
		} else {
			$firstname = $this->input->post('firstname');
			$lastname = $this->input->post('lastname');
			$username = $this->input->post('username');
			$email_address = $this->input->post('email_address');
			$password = $this->input->post('password');

			// Uploading User image
			$config['upload_path'] = './assets/uploads';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '2048';
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('imageUpload')) {
				$this->session->set_flashdata('registrationFailMessage', $this->upload->display_errors());
				log_message('debug', "Registration Failed,  unable to upload file - " . $username);
				log_message('debug', $this->upload->display_errors());
				redirect('registration');
			} else {
				$data = array('upload_data' => $this->upload->data());
				$file_name = $data['upload_data']['file_name'];
				$isUploadSuccess = true;
				log_message('debug', "File Upload success - " . $file_name);

				// Inserting new user to database
				$isRegistrationSuccess = $this->users->createNewUser($username, $firstname, $lastname, $email_address, $password, $file_name);
				if ($isRegistrationSuccess & $isUploadSuccess) {
					log_message('debug', "User Addition Success - " . $username);

					// Adding new Genre-User Associations
					$isGenreAdditionSuccess = false;
					foreach ($this->input->post('genreSelection') as $genre) {
						$this->genreuser->addGenreToUser($username, $genre);
						log_message('debug', "Echo - " . $genre);
						$isGenreAdditionSuccess = true;
					}
					if ($isGenreAdditionSuccess) {
						log_message('debug', "Genre Addition Success - " . $username);
						$sendResult = $this->sendVerificationEmail($email_address);
						if ($sendResult) {
							log_message('debug', "Email Send Success - " . $username);
							$this->session->set_flashdata('registrationSuccessMessage', "You have successfully registered!");
							redirect('signUpSuccess');
						} else {
							log_message('debug', "Error Sending Email" . $email_address);
						}
					}
				} else {
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
					https://w1714881.users.ecs.westminster.ac.uk/cw1/index.php/Authentication/verifyEmail/' . md5($userEmail) . '
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

		$this->email->from($fromEmail, 'Treble Team');
		$this->email->to($userEmail);
		$this->email->subject($emailSubject);
		$this->email->message($emailMessage);
		return $this->email->send();
	}

	public function verifyEmail(){
		$hash = $this->uri->segment(2);
		$result = $this->users->verifyEmailAddress($hash);
		if ($result != null){
			if ($result){
				$data = array(
					'name' => 'Email Verification Success',
					'main_view' => 'email_verification_view',
					'isSuccess' => true
				);
				$this->load->view('main', $data);
			} else {
				$data = array(
					'name' => 'Email Verification Success',
					'main_view' => 'email_verification_view',
					'isSuccess' => false
				);
				$this->load->view('main', $data);
			}
		}else {
			$data = array(
				'name' => 'Email Verification Completed',
				'main_view' => 'email_verification_view',
			);
			$this->load->view('main', $data);
		}

	}

	public function login()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]');

		if ($this->form_validation->run() == FALSE) {
			$data = array(
				'loginErrors' => validation_errors()
			);
			$this->session->set_flashdata($data);
			redirect('login');
		} else {
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			if ($this->users->isEmailAddressVerified($username)) {
				if ($this->users->authenticateUser($username, $password)) {
					$this->session->is_logged_in = true;
					$this->session->username = $username;
					log_message('debug', "Login Success - " . $username);
					redirect('privateHomePage/' . $username);
				} else {
					log_message('debug', "Login Fail - " . $username);
					$data = array(
						'loginErrors' => "Username or Password does not exist."
					);
					$this->session->set_flashdata($data);
					$this->session->login_error = True;
					redirect('login');
				}
			} else {
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

	public function logout()
	{
		$array_items = array('is_logged_in' => '', 'username' => '');
		$this->session->unset_userdata($array_items);
		$this->session->sess_destroy();
		redirect('home');
	}
}

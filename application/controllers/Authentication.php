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
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|min_length[3]|matches[password]');
		$this->form_validation->set_rules('image', 'Image Upload', 'trim|required');
		$this->form_validation->set_rules('genreSelection[]', 'Favourite Genre', 'trim|required');

		// Checking if the form_validation couldn't run and outputing the errors
		if ($this->form_validation->run() == FALSE) {
			$data = array(
				'registrationErrors' => validation_errors()
			);

			$this->session->set_flashdata($data);
			redirect('Authentication/signUpForm');
		} else {
			$firstname = $this->input->post('firstname');
			$lastname = $this->input->post('lastname');
			$username = $this->input->post('username');
			$email_address = $this->input->post('email_address');
			$password = $this->input->post('password');

			$isRegistrationSuccess = $this->users->createNewUser($username, $firstname, $lastname, $email_address, $password);
			if ($isRegistrationSuccess) {
				log_message('debug', "User Addition Success - " . $username);

				$isGenreAdditionSuccess = false;
				foreach ($this->input->post('genreSelection') as $genre) {
					$this->genreuser->addGenreToUser($username, $genre);
					log_message('debug', "Echo - " . $genre);
					$isGenreAdditionSuccess = true;
				}

				if ($isGenreAdditionSuccess) {
					log_message('debug', "Genre Addition Success - " . $username);
					$user_data = array(
						'username' => $username,
						'is_logged_in' => true
					);
					$this->session->set_userdata($user_data);
					$this->session->set_flashdata('registrationSuccessMessage', "You have successfully registered!");
					redirect('Authentication/signUpSuccessView');
				}
			} else {
				$error = $this->db->error();
				if ($error['code'] == 1062) {
					$this->session->set_flashdata('registrationFailMessage', "Sorry, this username already exists!");
					log_message('debug', "Registration Failed, username exists - " . $username);
					redirect('Authentication/signUpForm');
				} else {
					$this->session->set_flashdata('registrationFailMessage', "Sorry, your registration failed!");
					log_message('debug', "Registration Fail - " . $username);
					redirect('Authentication/signUpForm');
				}
			}
		}
	}

	public
	function login()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]');

		if ($this->form_validation->run() == FALSE) {
			$data = array(
				'loginErrors' => validation_errors()
			);
			$this->session->set_flashdata($data);
			redirect('Authentication/loginForm');
		} else {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			if ($this->users->authenticateUser($username, $password)) {
				$this->session->is_logged_in = true;
				$this->session->username = $username;
				log_message('debug', "Login Success - " . $username);
				redirect('Home/index');
			} else {
				log_message('debug', "Login Fail - " . $username);
				$this->session->login_error = True;
				redirect('Authentication/loginForm');
			}
		}


	}
}

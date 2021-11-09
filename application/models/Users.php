<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Model
{

	public function createNewUser($username, $firstname, $lastName, $emailAddress, $password, $file_name)
	{
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		$dataArray = array(
			'first_name' => $firstname,
			'last_name' => $lastName,
			'username' => $username,
			'email_address' => $emailAddress,
			'password' => $hashed_password,
			'profile_picture_location' => $file_name
		);

		if ($this->db->insert('users', $dataArray)) {
			return true;
		} else {
			return false;
		}
	}

	function sendVerificationEmail($userEmail)
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


	public function verifyEmailAddress($key)
	{
		$this->db->select('verification_status');
		$this->db->where('md5(email_address)', $key);
		$result = $this->db->get('users');
		if ($result->first_row()->verification_status == "0") {
			$data = array('verification_status' => 1);
			if ($this->db->update('users', $data)) {
				return true;
			} else {
				return false;
			}
		} else {
			return null;
		}
	}

	public function isEmailAddressVerified($username)
	{
		$this->db->select('verification_status');
		$this->db->where('username', $username);
		$result = $this->db->get('users');
		if ($result->first_row()->verification_status == "1") {
			return true;
		} else {
			return false;
		}
	}

	public function getNameByUsername($username)
	{
		$this->db->where('username', $username);
		$result = $this->db->get('users');
		if ($result->num_rows() != 1) {
			return false;
		} else {
			$name = $result->row(0)->first_name . " " . $result->row(0)->last_name;
			return $name;
		}
	}

	public function getDetailsByUsername($username)
	{
		$this->db->select('username, first_name, last_name, profile_picture_location');
		$this->db->where('username', $username);
		$result = $this->db->get('users');
		return $result->row_array();
	}

	public function isUsernameUnique($username)
	{
		$this->db->where('username', $username);
		$result = $this->db->get('users');
		if ($result->num_rows() > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function authenticateUser($username, $password)
	{
		$result = $this->db->get_where('users', array('username' => $username));
		if ($result->num_rows() != 1) {
			return false;
		} else {
			$row = $result->row();
			if (password_verify($password, $row->password)) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function is_logged_in()
	{
		if (isset($this->session->is_logged_in) && $this->session->is_logged_in == True) {
			return True;
		} else {
			return False;
		}
	}
}

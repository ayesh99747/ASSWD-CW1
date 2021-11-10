<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Model
{

	// This function is used to create a new user.
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

	// The following function is used to verify the email address of a user
	public function verifyEmailAddress($key)
	{
		var_dump($key);
		$this->db->select('verification_status');
		$this->db->where('md5(email_address)', $key);
		$result = $this->db->get('users'); // The rows where the md5 hash of the email address matches the key is retrieved.
		// If the verification_status is 0, which means that if the verification has not been performed yet.
		var_dump($result->result_array()); // TODO: Verfication error
		if ($result->first_row()->verification_status == "0") {
			$data = array('verification_status' => 1);
			$this->db->where('md5(email_address)', $key);
			// The users table will be updated where the md5 hash of the email address matches the key.
			if ($this->db->update('users', $data)) {
				return true;
			} else {
				return false;
			}
		} else {
			return null;
		}
	}

	// The following function is used to check if the email address has been verified.
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

	// The following function is used to get the full name of a user.
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

	// The following function is used to get the details of a user.
	public function getDetailsByUsername($username)
	{
		$this->db->select('username, first_name, last_name, profile_picture_location');
		$this->db->where('username', $username);
		$result = $this->db->get('users');
		return $result->row_array();
	}

	// The following function is used to check if the username and password of a user is correct.
	// It is used during the login procedure.
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
}

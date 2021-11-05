<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Model
{

	public function createNewUser($username, $firstname, $lastName, $emailAddress, $password)
	{
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		$dataArray = array(
			'first_name' => $firstname,
			'last_name' => $lastName,
			'username' => $username,
			'email_address' => $emailAddress,
			'password' => $hashed_password
		);

		if ($this->db->insert('users', $dataArray)) {
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

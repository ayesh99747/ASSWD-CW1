<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GenreUser extends CI_Model
{

	// This function is used to create the associations between users and the genres that they select.
	public function addGenreToUser($username, $genre)
	{
		$dataArray = array(
			'username' => $username,
			'genre_id' => $genre
		);
		log_message('debug', 'Username - ' . $username);
		log_message('debug', 'Genre - ' . $genre);
		$this->db->insert('genre_user', $dataArray);

		return true;
	}

	// This function is used to get all the users for a particular genre.
	public function getUsersByGenre($genre)
	{
		$this->db->select('username');
		$this->db->where('genre_id',$genre);
		$result = $this->db->get('genre_user');
		return $result->result_array();
	}


}

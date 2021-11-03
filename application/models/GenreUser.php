<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GenreUser extends CI_Model
{

	function addGenreToUser($username, $genre)
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



}

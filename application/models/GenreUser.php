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
		$this->db->insert('genre_user', $dataArray);

		return true;
	}

	public function deleteGenresByUser($username)
	{
		$this->db->where('username', $username);
		return $this->db->delete('genre_user');
	}

	// This function is used to get all the users for a particular genre.
	public function getUsersByGenre($genre)
	{
		$this->db->select('username');
		$this->db->where('genre_id',$genre);
		$result = $this->db->get('genre_user');
		return $result->result_array();
	}


	public function getGenresByUser($username)
	{
		$this->db->select('genre_id');
		$this->db->where('username',$username);
		$result = $this->db->get('genre_user');
		$genreArray = Array();
		foreach ($result->result_array() as $row){
			array_push($genreArray,$row['genre_id']);
		}
		return $genreArray;
	}


}

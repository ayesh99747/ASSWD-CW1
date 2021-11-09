<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Genres extends CI_Model
{

	// The following function is used to get all the genres available and this is used to populate the
	// dropdown list which is used when searching for users by genre.
	public function getAllGenres()
	{
		$results = $this->db->get('genres');
		return $results->result_array();
	}


}

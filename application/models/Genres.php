<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Genres extends CI_Model
{

	function getAllGenres()
	{
		$results = $this->db->get('genres');
		return $results->result_array();
	}



}

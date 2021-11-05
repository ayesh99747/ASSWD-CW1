<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Posts extends CI_Model
{
	public function createNewPost($post, $username){
		$dataArray = array(
			'username' => $username,
			'post' => $post
		);

		if ($this->db->insert('posts', $dataArray)) {
			return true;
		} else {
			return false;
		}
	}

	public function getAllPostsByUsername($username)
	{
		$this->db->where('username', $username);
		$result = $this->db->get('posts');
		return $result->result_array();
	}
}

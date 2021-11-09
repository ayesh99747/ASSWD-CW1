<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Posts extends CI_Model
{
	// This function is used when the user creates a new post.
	public function createNewPost($post, $username)
	{
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

	// The following function is used for the users public home page where only the users post should be shown.
	public function getAllPostsByUsername($username)
	{
		$this->db->where('username', $username);
		$this->db->order_by("timestamp", "desc");
		$result = $this->db->get('posts');
		return $result->result_array();
	}

	// The following function is used for the users private home page where
	// the users post and posts pf the people the user followers should be shown.
	public function getAllPostsForUsernames($usernames)
	{
		$this->db->where('username', $this->session->username);
		foreach ($usernames as $username) {
			$this->db->or_where('username', $username['following_username']);
		}
		$this->db->order_by("timestamp", "desc");
		$result = $this->db->get('posts');
		return $result->result_array();
	}
}

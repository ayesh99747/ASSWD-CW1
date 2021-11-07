<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserFollower extends CI_Model
{

	function followUser($followerUsername, $followingUsername)
	{
		$dataArray = array(
			'follower_username' => $followerUsername,
			'following_username' => $followingUsername
		);
		if ($this->db->insert('user_follower', $dataArray)) {
			return true;
		} else {
			return false;
		}
	}

	function unfollowUser($followerUsername, $followingUsername)
	{
		$dataArray = array(
			'follower_username' => $followerUsername,
			'following_username' => $followingUsername
		);
		$this->db->where($dataArray);
		if ($this->db->delete('user_follower')) {
			return true;
		} else {
			return false;
		}
	}


}

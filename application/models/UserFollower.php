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

	function checkIsFollower($followerUsername, $followingUsername)
	{
		$dataArray = array(
			'follower_username' => $followerUsername,
			'following_username' => $followingUsername
		);
		$this->db->where($dataArray);
		$result = $this->db->get('user_follower');
		if ($result->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	function checkIsFriend($followerUsername, $followingUsername)
	{
		$dataArray1 = array(
			'follower_username' => $followerUsername,
			'following_username' => $followingUsername
		);
		$this->db->where($dataArray1);
		$result1 = $this->db->get('user_follower');

		$dataArray2 = array(
			'follower_username' => $followingUsername,
			'following_username' => $followerUsername
		);
		$this->db->where($dataArray2);
		$result2 = $this->db->get('user_follower');

		if ($result1->num_rows() > 0 & $result2->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	function getFollowersByUsername($followingUsername)
	{
		$dataArray = array(
			'following_username' => $followingUsername
		);
		$this->db->where($dataArray);
		$result = $this->db->get('user_follower');
		return $result->result_array();
	}

	function getFollowingByUsername($followerUsername)
	{
		$dataArray = array(
			'follower_username' => $followerUsername,
		);
		$this->db->where($dataArray);
		$result = $this->db->get('user_follower');
		return $result->result_array();
	}

}

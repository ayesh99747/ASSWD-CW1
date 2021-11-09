<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserFollower extends CI_Model
{

	// This function is used when a user what's to follow another user.
	public function followUser($followerUsername, $followingUsername)
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

	// This function is used when a user what's to unfollow another user.
	public function unfollowUser($followerUsername, $followingUsername)
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

	// This function is used to check whether a particular user is following another user.
	public function checkIsFollower($username, $followingUsername)
	{
		$dataArray = array(
			'follower_username' => $username,
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

	// This function is used to check whether two users are friends.
	public function checkIsFriend($username1, $username2)
	{
		$dataArray1 = array(
			'follower_username' => $username1,
			'following_username' => $username2
		);
		$this->db->where($dataArray1);
		$result1 = $this->db->get('user_follower');

		$dataArray2 = array(
			'follower_username' => $username2,
			'following_username' => $username1
		);
		$this->db->where($dataArray2);
		$result2 = $this->db->get('user_follower');

		if ($result1->num_rows() > 0 & $result2->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// This function is used to get all the followers for a particular user.
	public function getFollowersByUsername($username)
	{
		$dataArray = array(
			'following_username' => $username
		);
		$this->db->where($dataArray);
		$result = $this->db->get('user_follower');
		return $result->result_array();
	}

	// This function is used to get all the users being followed by a particular user.
	public function getFollowingByUsername($username)
	{
		$dataArray = array(
			'follower_username' => $username,
		);
		$this->db->where($dataArray);
		$result = $this->db->get('user_follower');
		return $result->result_array();
	}

	// This function is used to get the number of friends for a particular username.
	public function getNumberOfFriends($username)
	{
		// First we get the number of people the user follows
		$this->db->where('follower_username', $username);
		$results = $this->db->get('user_follower');
		$resultArray = $results->result_array();

		$numberOfFriends = 0;
		foreach ($resultArray as $result) {
			if ($this->checkIsFriend($result['following_username'], $username)) {
				$numberOfFriends = $numberOfFriends + 1;
			}
		}
		return $numberOfFriends;
	}

}

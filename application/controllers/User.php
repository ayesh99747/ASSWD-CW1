<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	// This function is used to render the private home page.
	public function viewPrivateHomePage()
	{
		$username = $this->uri->segment(2);
		if ($username === $this->session->username) {
			$data['main_view'] = "private_home_page";
			// We retrieve all the users followed by the user.
			$usersFollowed = $this->userfollower->getFollowingByUsername($username);
			// We retrieve all the posts for a user
			$posts = $this->posts->getAllPostsForUsernames($usersFollowed);
			$data['posts'] = $posts;
			$this->load->view('main', $data);
		} else {
			if ($this->session->is_logged_in === true) {
				redirect('privateHomePage/' . $this->session->username);
			} else {
				redirect('login');
			}
		}

	}

	// This function is used to render the public home page.
	public function viewPublicHomePage()
	{
		$username = trim($this->uri->segment(2));
		if ($this->session->is_logged_in === true) {
			// Here we retrieve all the details by username
			$userDetails = $this->users->getDetailsByUsername($username);
			$userDetails['numberOfFollowers'] = count($this->userfollower->getFollowersByUsername($username));
			$userDetails['numberOfFollowing'] = count($this->userfollower->getFollowingByUsername($username));
			$userDetails['numberOfFriends'] = $this->userfollower->getNumberOfFriends($username);

			if ($this->session->username != $username) {
				$userDetails['isFollowed'] = $this->userfollower->checkIsFollower($this->session->username, $username);
				$userDetails['isFriend'] = $this->userfollower->checkIsFriend($this->session->username, $username);
			}
			$data['user_details'] = $userDetails;

			$posts = $this->posts->getAllPostsByUsername($username); // We get all the posts by the user.
			$data['posts'] = $posts;
			$data['numberOfPosts'] = count($posts);

			$data['view_name'] = "Public Home Page";
			$data['main_view'] = "public_home_page";
			$this->load->view('main', $data);
		} else {
			if ($this->session->is_logged_in === true) {
				redirect('publicHomePage/' . $this->session->username);
			} else {
				redirect('login');
			}
		}
	}

	// This function is used when the follow button is clicked by a user.
	public function followUser()
	{
		$view_name = trim($this->uri->segment(3));
		$usernameToBeFollowed = trim($this->uri->segment(4));
		$selectedGenreNumber = trim($this->uri->segment(5));
		if ($this->userfollower->followUser($this->session->username, $usernameToBeFollowed)) {
			// Once the follow operation is successful the user will be redirected to the page he came from.
			log_message('debug', "Follow User Success - " . $usernameToBeFollowed);
			if ($view_name == 'searchByGenre_view') {
				redirect('viewUsersByGenre/' . $selectedGenreNumber);
			} elseif ($view_name == 'View%20Followers') {
				redirect('followers/' . $this->session->username);
			} elseif ($view_name == 'View%20Following') {
				redirect('following/' . $this->session->username);
			} elseif ($view_name == 'Public%20Home%20Page') {
				redirect('publicHomePage/' . $usernameToBeFollowed);
			}
		} else {
			// If the follow operation fails, he will be redirected to his private home page.
			log_message('debug', "Follow User Fail - " . $usernameToBeFollowed);
			redirect('privateHomePage/' . $this->session->username);
		}
	}

	// This function is used when the unfollow button is clicked by a user.
	public function unfollowUser()
	{
		$view_name = trim($this->uri->segment(3));
		$usernameToBeFollowed = trim($this->uri->segment(4));
		$selectedGenreNumber = trim($this->uri->segment(5));
		if ($this->userfollower->unfollowUser($this->session->username, $usernameToBeFollowed)) {
			log_message('debug', "Unfollow User Success - " . $usernameToBeFollowed);
			// Once the unfollow operation is successful the user will be redirected to the page he came from.
			if ($view_name == 'searchByGenre_view') {
				redirect('viewUsersByGenre/' . $selectedGenreNumber);
			} elseif ($view_name == 'View%20Followers') {
				redirect('followers/' . $this->session->username);
			} elseif ($view_name == 'View%20Following') {
				redirect('following/' . $this->session->username);
			} elseif ($view_name == 'Public%20Home%20Page') {
				redirect('publicHomePage/' . $usernameToBeFollowed);
			}
		} else {
			// If the unfollow operation fails, he will be redirected to his private home page.
			log_message('debug', "Unfollow User Fail - " . $usernameToBeFollowed);
			redirect('privateHomePage/' . $this->session->username);
		}
	}

	// This function is used when the user wants to view all his followers
	public function viewFollowers()
	{
		$username = $this->uri->segment(2);
		if ($username === $this->session->username) {
			// We retrieve the followers by the username here.
			$users = $this->userfollower->getFollowersByUsername($username);
			$userDetails = array();
			foreach ($users as $user) {
				$userDetail = $this->users->getDetailsByUsername($user['follower_username']);
				$userDetail['isFollowed'] = $this->userfollower->checkIsFollower($this->session->username, $user['follower_username']);
				$userDetail['isFriend'] = $this->userfollower->checkIsFriend($this->session->username, $user['follower_username']);
				array_push($userDetails, $userDetail);
			}

			if (count($userDetails) > 0) {
				$data['user_details'] = $userDetails;
			} else {
				$data['user_details'] = false;
			}

			$data['main_view'] = "followers_and_following_view";
			$data['view_name'] = "View Followers";
			$this->load->view('main', $data);
		} else {
			if ($this->session->is_logged_in === true) {
				redirect('privateHomePage/' . $this->session->username);
			} else {
				redirect('login');
			}
		}
	}

	// This function is used when the user wants to view all the users he follows
	public function viewFollowing()
	{
		$username = $this->uri->segment(2);
		if ($username === $this->session->username) {
			// We retrieve all the users he follows by the username here.
			$users = $this->userfollower->getFollowingByUsername($username);
			$userDetails = array();
			foreach ($users as $user) {
				$userDetail = $this->users->getDetailsByUsername($user['following_username']);
				$userDetail['isFollowed'] = $this->userfollower->checkIsFollower($this->session->username, $user['following_username']);
				$userDetail['isFriend'] = $this->userfollower->checkIsFriend($this->session->username, $user['following_username']);
				array_push($userDetails, $userDetail);
			}

			if (count($userDetails) > 0) {
				$data['user_details'] = $userDetails;
			} else {
				$data['user_details'] = false;
			}

			$data['main_view'] = "followers_and_following_view";
			$data['view_name'] = "View Following";
			$this->load->view('main', $data);
		} else {
			if ($this->session->is_logged_in === true) {
				redirect('privateHomePage/' . $this->session->username);
			} else {
				redirect('login');
			}
		}
	}
}

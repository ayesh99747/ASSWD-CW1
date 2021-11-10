<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function viewPrivateHomePage()
	{
		$username = $this->uri->segment(2);
		if ($username === $this->session->username) {
			$data['main_view'] = "private_home_page";
			$usersFollowed = $this->userfollower->getFollowingByUsername($username);
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

	public function viewPublicHomePage()
	{
		$username = trim($this->uri->segment(2));
		if ($this->session->is_logged_in === true) {
			$userDetails = $this->users->getDetailsByUsername($username);
			$userDetails['numberOfFollowers'] = count($this->userfollower->getFollowersByUsername($username));
			$userDetails['numberOfFollowing'] = count($this->userfollower->getFollowingByUsername($username));
			$userDetails['numberOfFriends'] = $this->userfollower->getNumberOfFriends($username);

			if ($this->session->username != $username) {
				$userDetails['isFollowed'] = $this->userfollower->checkIsFollower($this->session->username, $username);
				$userDetails['isFriend'] = $this->userfollower->checkIsFriend($this->session->username, $username);
			}
			$data['user_details'] = $userDetails;

			$posts = $this->posts->getAllPostsByUsername($username);
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

	public function viewSearchByGenreForm()
	{
		if (true === $this->session->is_logged_in) {
			$genres = $this->genres->getAllGenres();
			$data['genres'] = $genres;
			$data['main_view'] = "searchByGenre_view";
			$this->load->view('main', $data);
		} else {
			redirect('login');
		}
	}

	public function getGenreSelection()
	{
		$this->form_validation->set_rules('genre_dropdown', 'Genre', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$data = array(
				'searchByGenreErrors' => validation_errors()
			);
			$this->session->set_flashdata($data);
			redirect('searchUsersByGenre');
		} else {
			$selectedGenre = (int)$this->input->post('genre_dropdown');
			redirect('viewUsersByGenre/' . $selectedGenre);
		}
	}

	public function getUsersByGenre()
	{
		$selectedGenre = trim($this->uri->segment(2));
		if ($selectedGenre == null) {
			redirect('searchUsersByGenre');
		} else {
			$users = $this->genreuser->getUsersByGenre($selectedGenre + 1);

			$userDetails = array();
			foreach ($users as $user) {
				if ($user['username'] != $this->session->username) {
					$userDetail = $this->users->getDetailsByUsername($user['username']);
					$userDetail['isFollowed'] = $this->userfollower->checkIsFollower($this->session->username, $user['username']);
					$userDetail['isFriend'] = $this->userfollower->checkIsFriend($this->session->username, $user['username']);
					array_push($userDetails, $userDetail);
				}
			}

			if (count($userDetails) > 0) {
				$data['user_details'] = $userDetails;
			} else {
				$data['user_details'] = false;
			}
			$genres = $this->genres->getAllGenres();
			$data['genres'] = $genres;
			$data['selectedGenreNumber'] = $selectedGenre;
			$data['main_view'] = "searchByGenre_view";
			$this->load->view('main', $data);
		}
	}

	public function followUser()
	{
		$view_name = trim($this->uri->segment(3));
		$usernameToBeFollowed = trim($this->uri->segment(4));
		$selectedGenreNumber = trim($this->uri->segment(5));
		if ($this->userfollower->followUser($this->session->username, $usernameToBeFollowed)) {
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

		}
	}

	public function unfollowUser()
	{
		$view_name = trim($this->uri->segment(3));
		$usernameToBeFollowed = trim($this->uri->segment(4));
		$selectedGenreNumber = trim($this->uri->segment(5));
		if ($this->userfollower->unfollowUser($this->session->username, $usernameToBeFollowed)) {
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

		}
	}

	public function viewFollowers()
	{
		$username = $this->uri->segment(2);
		if ($username === $this->session->username) {

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

	public function viewFollowing()
	{
		$username = $this->uri->segment(2);
		if ($username === $this->session->username) {

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

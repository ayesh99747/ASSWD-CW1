<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('posts');
		$this->load->model('users');
		$this->load->model('genres');
		$this->load->model('genreuser');
		$this->load->model('userfollower');
	}

	public function viewPrivateHomePage()
	{
		$username = $this->uri->segment(3);
		if ($username === $this->session->username) {
			$data['main_view'] = "private_home_page";
			$usersFollowed = $this->userfollower->getFollowingByUsername($username);
			$posts = $this->posts->getAllPostsForUsernames($usersFollowed);
			$data['posts'] = $posts;
			$this->load->view('main', $data);
		} else {
			if ($this->session->is_logged_in === true) {
				redirect('User/viewPrivateHomePage/' . $this->session->username);
			} else {
				redirect('Authentication/loginForm');
			}
		}

	}

	public function viewPublicHomePage()
	{
		$username = trim($this->uri->segment(3));
		if ($this->session->is_logged_in === true) {
			$userDetails = $this->users->getDetailsByUsername($username);
			$userDetails['numberOfFollowers'] = count($this->userfollower->getFollowersByUsername($username));
			$userDetails['numberOfFollowing'] = count($this->userfollower->getFollowingByUsername($username));
			$userDetails['numberOfFriends'] = $this->userfollower->getNumberOfFriends($username);

			if ($this->session->username != $username){
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
				redirect('User/viewPublicHomePage/' . $this->session->username);
			} else {
				redirect('Authentication/loginForm');
			}
		}
	}

	public function viewSearchByGenre()
	{
		if (true === $this->session->is_logged_in) {
			$genres = $this->genres->getAllGenres();
			$data['genres'] = $genres;
			$data['main_view'] = "searchByGenre_view";
			$this->load->view('main', $data);
		} else {
			redirect('Authentication/loginForm');
		}
	}

	public function getUsersByGenre()
	{
		$this->form_validation->set_rules('genre_dropdown', 'Genre', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$data = array(
				'searchByGenreErrors' => validation_errors()
			);
			$this->session->set_flashdata($data);
			redirect('User/viewSearchByGenre');
		} else {
			$selectedGenre = (int)$this->input->post('genre_dropdown');
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
			$data['main_view'] = "searchByGenre_view";
			$this->load->view('main', $data);
		}
	}

	public function followUser()
	{
		$view_name = trim($this->uri->segment(3));
		$usernameToBeFollowed = trim($this->uri->segment(4));
		if ($this->userfollower->followUser($this->session->username, $usernameToBeFollowed)) {
			if ($view_name == 'searchByGenre_view') {
				redirect('User/getUsersByGenre');
			} elseif ($view_name == 'View%20Followers') {
				redirect('User/viewFollowers/' . $this->session->username);
			} elseif ($view_name == 'View%20Following') {
				redirect('User/viewFollowing/' . $this->session->username);
			} elseif ($view_name == 'Public%20Home%20Page') {
				redirect('User/viewPublicHomePage/' . $usernameToBeFollowed);
			}
		} else {

		}
	}

	public function unfollowUser()
	{
		$view_name = trim($this->uri->segment(3));
		$usernameToBeFollowed = trim($this->uri->segment(4));
		if ($this->userfollower->unfollowUser($this->session->username, $usernameToBeFollowed)) {
			if ($view_name == 'searchByGenre_view') {
				redirect('User/getUsersByGenre');
			} elseif ($view_name == 'View%20Followers') {
				redirect('User/viewFollowers/' . $this->session->username);
			} elseif ($view_name == 'View%20Following') {
				redirect('User/viewFollowing/' . $this->session->username);
			} elseif ($view_name == 'Public%20Home%20Page') {
				redirect('User/viewPublicHomePage/' . $usernameToBeFollowed);
			}
		} else {

		}
	}

	public function viewFollowers()
	{
		$username = $this->uri->segment(3);
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
				redirect('User/viewPrivateHomePage/' . $this->session->username);
			} else {
				redirect('Authentication/loginForm');
			}
		}
	}

	public function viewFollowing()
	{
		$username = $this->uri->segment(3);
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
				redirect('User/viewPrivateHomePage/' . $this->session->username);
			} else {
				redirect('Authentication/loginForm');
			}
		}
	}
}

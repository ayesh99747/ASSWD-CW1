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
			$posts = $this->posts->getAllPostsByUsername($username);
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
		if (true === $this->session->is_logged_in) {
			$username = $this->uri->segment(3);
			$posts = $this->posts->getAllPostsByUsername($username);
			$data['posts'] = $posts;
			$userDetails = $this->users->getDetailsByUsername($username);
			$data['user_details'] = $userDetails;
			$data['main_view'] = "public_home_page";
			$this->load->view('main', $data);
		} else {
			redirect('Authentication/loginForm');
		}
	}

	public function viewProfile()
	{
		$username = trim($this->uri->segment(3));
		if ($username === $this->session->username) {
			$data['main_view'] = "profile_view";
			$userDetails = $this->users->getDetailsByUsername($username);
			$data['user_details'] = $userDetails;
			$this->load->view('main', $data);
		} else {
			if ($this->session->is_logged_in === true) {
				redirect('User/viewPrivateHomePage/' . $this->session->username);
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
				$userDetail = $this->users->getDetailsByUsername($user['username']);
				array_push($userDetails, $userDetail);
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

	public function followUser(){

	}
}

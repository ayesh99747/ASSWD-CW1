<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Genre extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	// The following function is used to render the search by genre form.
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

	// The following function is used to get the data from the form and pass it to the next function.
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
}

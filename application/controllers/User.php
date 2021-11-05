<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('posts');
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
			redirect('Authentication/loginForm');
		}

	}

	public function viewPublicHomePage()
	{
		$data['main_view'] = "public_home_page";
		$this->load->view('main', $data);
	}
}

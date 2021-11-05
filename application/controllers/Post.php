<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Post extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
//		$this->load->model('users');
		$this->load->model('posts');
	}

	public function createPost()
	{
		$this->form_validation->set_rules('postText', 'Post Text', 'trim|required|min_length[5]|max_length[1000]');
		$username = $this->session->username;
		if ($this->form_validation->run() == FALSE) {
			$data = array(
				'postCreationErrors' => validation_errors()
			);
			$this->session->set_flashdata($data);
			log_message('debug', "Post Creation Fail - " . $username);
			redirect('User/viewPrivateHomePage/' . $username);
		} else {
			$postText = $this->input->post('postText');

			if ($this->posts->createNewPost($postText, $username)) {
				log_message('debug', "Post Creation Success - " . $username);
				redirect('User/viewPrivateHomePage/' . $username);
			} else {
				log_message('debug', "Post Creation Fail - " . $username);
				redirect('User/viewPrivateHomePage/' . $username);
			}
		}

	}



}

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
			$arrayString = explode(" ", $postText);
			for ($x = 0; $x < sizeof($arrayString); $x++) {
				if (preg_match('!https?://\S+!', $arrayString[$x], $matches)) {
					if (preg_match('!https?://\S+.(?:jpe?g|png|gif)!', $arrayString[$x], $matches2)) {
						$arrayString[$x] = '<img src="' . $arrayString[$x] . '" alt="' . $arrayString[$x] . '" width="150" height="100">';
					} else {
						$arrayString[$x] = '<a href="' . $arrayString[$x] . '" target="_blank" rel="nofollow">' . $arrayString[$x] . '</a>';
					}
				}
			}
			$newPostText = "";
			foreach ($arrayString as $string) {
				$newPostText = $newPostText . $string . " ";
			}
			if ($this->posts->createNewPost($newPostText, $username)) {
				log_message('debug', "Post Creation Success - " . $username);
				redirect('User/viewPrivateHomePage/' . $username);
			} else {
				log_message('debug', "Post Creation Fail - " . $username);
				redirect('User/viewPrivateHomePage/' . $username);
			}
		}

	}


}

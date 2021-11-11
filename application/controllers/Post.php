<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Post extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	// The following function is used to create a post.
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
			redirect('privateHomePage/' . $username);
		} else {
			$postText = $this->input->post('postText');
			$arrayString = explode(" ", $postText);// The string is split by spaces
			for ($x = 0; $x < sizeof($arrayString); $x++) {
				if (preg_match('!https?://\S+!', $arrayString[$x], $matches)) {
					if (preg_match('!https?://\S+.(?:jpe?g|png|gif)!', $arrayString[$x], $matches2)) {
						// Here we convert image links to <img> tags
						$arrayString[$x] = '<img src="' . $arrayString[$x] . '" alt="' . $arrayString[$x] . '" width="150" height="100">';
					} else {
						// Here we convert links to <a> tags
						$arrayString[$x] = '<a href="' . $arrayString[$x] . '" target="_blank" rel="nofollow">' . $arrayString[$x] . '</a>';
					}
				}
			}
			$newPostText = "";
			// Here we concatenate all the strings in the array to one string.
			foreach ($arrayString as $string) {
				$newPostText = $newPostText . $string . " ";
			}
			// here we insert the post to the database
			if ($this->posts->createNewPost($newPostText, $username)) {
				log_message('debug', "Post Creation Success - " . $username);
				redirect('privateHomePage/' . $username);
			} else {
				log_message('debug', "Post Creation Fail - " . $username);
				redirect('privateHomePage/' . $username);
			}
		}

	}


}

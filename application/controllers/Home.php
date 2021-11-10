<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
	// The following method is used to display the landing page.
	public function index()
	{
		$data['main_view'] = "home_view";
		$this->load->view('main', $data);
	}
}

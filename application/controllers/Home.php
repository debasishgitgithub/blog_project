<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct(){
		parent::__construct();
		
	}

    public function index()
    {
        $this->http->auth('get', 'SUPER_ADMIN');
        $this->load->view('layout/header');
        $this->load->view('blog/dashboard');
        $this->load->view('layout/footer');
    }
}

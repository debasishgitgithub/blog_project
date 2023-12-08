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
        view('blog/dashboard', [], 'Dashboard | Blog');
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		try {
			$this->http->auth(['get', 'post'], 'SUPER_ADMIN');
			view('blog/category_view', [], 'Category | Blog');
		} catch (\Throwable $th) {
			print_r($th);
		}
	}
}

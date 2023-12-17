<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Blog extends CI_Controller
{
	private $blog_image_dir = "";
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'blog_model'
		]);
	}

	private function save_view($id = null)
	{
		if ($blg_dtls = $this->blog_model->get($id)) {
			view('blog_create_view', $blg_dtls, "Blog | Update");
		} else {
			view('blog_create_view', [], "Blog | Create");
		}
	}

	public function index()
	{
		try {
			$this->http->auth(['get', 'post'], 'SUPER_ADMIN');
			view('blog/blog_view', [], 'Blogs | Blog');
		} catch (\Throwable $th) {
			print_r($th);
		}
	}

	public function save($id = null): void
	{
		try {
			$u = $this->http->auth(['get', 'post'], 'SUPER_ADMIN');
			$admin_id = $u->admin_id;

			if (is_post()) {
				$this->form_validation->set_rules(
					[
						'field' => 'content',
						'label' => 'Content',
						'rules' => 'required',
					],
					[
						'field' => 'category_id',
						'label' => 'Category',
						'rules' => 'required|is_exist[category.id]',
						'errors' => array(
							'is_exist' => '%s not exist',
						),
					],
					[
						'field' => 'status',
						'label' => 'Status',
						'rules' => 'required|in_list[0,1]',
						'errors' => array(
							'is_exist' => '%s not exist',
						),
					],
					[
						'field' => 'blogimage[]',
						'label' => 'Blog Image',
						'rules' => "file_required[blogimage]|file_extension[blogimage.jpeg|jpg|png]|file_maxsize[blogimage.2024]",
						'errors' => array(
							'file_required' => 'The {field} field is required',
							'file_extension' => 'The {field} field must have a valid file extension jpeg|jpg|png',
							'file_maxsize' => 'The {field} field must not exceed 2024 KB.',
						),
					],
				);
			} else {
				$this->save_view($id);
			}
		} catch (\Throwable $th) {
			redirect(portal_url(), 'refresh');
		}
	}
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Blog extends CI_Controller
{
	private $blog_image_dir = "";
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'blog_model',
			'category_model',
			'blog_img_model'
		]);
	}

	private function save_view($user_id, $id = null)
	{
		$category_dtls = $this->category_model->get_all(1, $user_id);
		if ($blg_dtls = $this->blog_model->get($id)) {
			view('blog/blog_create_view', compact('category_dtls', 'blg_dtls'), "Blog | Update");
		} else {
			view('blog/blog_create_view', compact('category_dtls'), "Blog | Create");
		}
	}

	public function index()
	{
		try {
			$this->http->auth(['get', 'post'], 'SUPER_ADMIN');
			view('blog/blog_view', [], 'Blogs | Blog');
		} catch (\Throwable $th) {
			redirect(portal_url(), 'refresh');
		}
	}

	public function save($id = null)
	{
		try {
			$u = $this->http->auth(['get', 'post'], 'SUPER_ADMIN');
			$user_id = $u->user_id;
			$p = $this->input->post();

			if (is_post()) {
				$this->form_validation->set_rules(
					[
						[
							'field' => 'title',
							'label' => 'title',
							'rules' => 'required',
						],
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
							// 'rules' => 'file_required[blogimage]|file_extension[blogimage.jpeg|jpg|png]|file_maxsize[blogimage.2024]",
							'rules' => 'file_required[blogimage]',
							'errors' => array(
								'file_required' => 'The {field} field is required',
								'file_extension' => 'The {field} field must have a valid file extension jpeg|jpg|png',
								'file_maxsize' => 'The {field} field must not exceed 2024 KB.',
							),
						],
					]
				);

				if ($this->form_validation->run() == true) {
					$upload_file_names = [];

					// file validation for insert
					if (is_null($id)) {
						if (empty($_FILES['blogimage']['name'][0])) {
							set_message('danger', 'please select your file');
							$this->save_view($user_id, $id);
							return;
						}
					}


					// file upload
					if (!empty($_FILES['blogimage']['name'][0])) {
						$where_in_fileArr = ['img_name'=> $_FILES['blogimage']['name']];

						$duplicate_filesArr = array_column($this->blog_img_model->get_all($where_in_fileArr), 'img_name');
						if(!empty($duplicate_filesArr)){
							$dup_file = array_reduce($duplicate_filesArr, function($carry, $file_name){
								return $carry .= "{$file_name} already exists\n";
							});
							set_message('danger', $dup_file);
							$this->save_view($user_id, $id);
							return;
						}

						$config = [
							'upload_path' => 'documents/uploads/blog_img',
							'allowed_types' => 'jpg|jpeg|png',
						];

						if (!$this->mfile->upload('blogimage', $config)) {
							set_message('danger', 'File uploading error');
							$this->save_view($user_id, $id);
							return;
						}

						$upload_file_names = $this->mfile->file_names();
					}

					$data = [
						"title" => $p['title'],
						"content" => $p['content'],
						"category_id" => $p['category_id'],
						"status" => $p['status']
					];

					if (is_null($id)) {
						// insert
						if ($blog_id = $this->blog_model->insert($data)) {
							$img_data = array_map(fn ($file_name) => ['img_name' => $file_name, 'blog_id' => $blog_id], $upload_file_names);
							if ($this->blog_img_model->insert_batch($img_data)) {
								set_message('success', 'Blog create successfully');
							} else {
								$this->blog_model->delete($blog_id);
								set_message('danger', 'Blog img upload failed');
							}
						} else {
							$this->mfile->unlink_files();
							set_message('danger', 'Blog create failed');
						}
					} else {
						// update
						if ($this->blog_model->update($data)) {
							if(!empty($upload_file_names)){
								$img_data = array_map(fn ($file_name) => ['img_name' => $file_name, 'blog_id' => $id], $upload_file_names);
								if ($this->blog_img_model->insert_batch($img_data)) {
									set_message('success', 'Blog updated successfully');
								} else {
									set_message('danger', 'Blog img upload failed');
								}
							} else {
								set_message('success', 'Blog update success');
							}
						} else {
							if(!empty($upload_file_names)) $this->mfile->unlink_files();
							set_message('danger', 'Blog update failed');
						}
					}
					redirect(portal_url('blog'), 'refresh');
				} else {
					$this->save_view($user_id, $id);
				}
			} else {
				$this->save_view($user_id, $id);
			}
		} catch (\Throwable $th) {
			pp($th);
			redirect(portal_url(), 'refresh');
		}
	}
}

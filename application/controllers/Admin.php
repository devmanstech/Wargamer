<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		/*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');

		// Set the timezone
		date_default_timezone_set(get_settings('timezone'));
	}

	public function index() {
		if ($this->session->userdata('admin_login') == true) {
			$this->blogs();
		}else {
			redirect(site_url('login'), 'refresh');
		}
	}

	
	public function users($param1 = "", $param2 = "") {
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('login'), 'refresh');
		}

		if ($param1 == 'add') {
			$this->user_model->add_user();
			redirect(site_url('admin/users'), 'refresh');
		}
		elseif ($param1 == 'edit') {
			$this->user_model->edit_user($param2);
			redirect(site_url('admin/users'), 'refresh');
		}elseif ($param1 == 'delete') {
			$this->crud_model->delete_from_table('user', $param2);
			$this->session->set_flashdata('flash_message', get_phrase('user_has_been_deleted'));
			redirect(site_url('admin/users'), 'refresh');
		}

		$page_data['page_name'] = 'users';
		$page_data['page_title'] = get_phrase('users');
		$page_data['users'] = $this->user_model->get_users();
		$this->load->view('backend/index', $page_data);

	}

	
	public function user_form($param1 = "", $param2 = "") {
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		if ($param1 == 'add') {
			$page_data['page_name']  = 'user_add';
			$page_data['page_title'] = get_phrase('add_new_user');
		}elseif ($param1 == 'edit') {
			$page_data['page_name']  = 'user_edit';
			$page_data['page_title'] = get_phrase('update_user');
			$page_data['user_id'] = $param2;
		}
		$this->load->view('backend/index.php', $page_data);
	}


	
	public function blogs(){
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		$page_data['blogs'] = $this->crud_model->get_blogs()->result_array();
		$page_data['page_name'] = 'blogs';
		$page_data['page_title'] = get_phrase('posts');
		$this->load->view('backend/index', $page_data);
	}

	public function blog_form($param1 = "", $param2 = ""){
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		if($param1 == 'add'):
			
			$page_data['page_name'] = 'add_blog_form';
			$page_data['page_title'] = get_phrase('add_new_blog');
			$this->load->view('backend/index', $page_data);
		elseif($param1 == 'edit'):
			$page_data['blog'] = $this->crud_model->get_blogs($param2)->row_array();
			
			$page_data['page_name'] = 'edit_blog_form';
			$page_data['page_title'] = get_phrase('blog_edit');
			$this->load->view('backend/index', $page_data);
		endif;
	}

	public function add_blog(){
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		$this->crud_model->add_blog();
		$this->session->set_flashdata('flash_message', get_phrase('new_blog_added_successfully'));
		redirect(site_url('admin/blogs'), 'refresh');
	}

	public function edit_blog($param1 = ""){
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		$this->crud_model->edit_blog($param1);
		$this->session->set_flashdata('flash_message', get_phrase('blog_updated_successfully'));
		redirect(site_url('admin/blogs'), 'refresh');
	}

	public function blog_status($param1 = "", $param2 = ""){
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		$this->crud_model->blog_status($param1, $param2);
		if($param1 == 'active'):
		    $this->session->set_flashdata('flash_message', get_phrase('blog_activated_successfully'));
		elseif($param1 == 'inactive'):
			$this->session->set_flashdata('flash_message', get_phrase('blog_inactivated_successfully'));
		endif;
		redirect(site_url('admin/blogs'), 'refresh');
	}

	public function delete_blog($param1 = ""){
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		$this->crud_model->delete_blog($param1);
		$this->session->set_flashdata('flash_message', get_phrase('blog_deleted_successfully'));
		redirect(site_url('admin/blogs'), 'refresh');
	}


	
	// Settings portion
	public function system_settings($param1 = "") {
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('login'), 'refresh');
		}

		if ($param1 == 'system_update') {
			$this->crud_model->update_system_settings();
			$this->session->set_flashdata('flash_message', get_phrase('system_settings_updated'));
			redirect(site_url('admin/system_settings'), 'refresh');
		}
		// $page_data['languages']	 = $this->get_all_languages();
		$page_data['page_name']  = 'system_settings';
		$page_data['page_title'] = get_phrase('system_settings');
		$this->load->view('backend/index', $page_data);
	}

	public function frontend_settings($param1 = "", $uploaded_image = "") {
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('login'), 'refresh');
		}

		if ($param1 == 'frontend_update') {
			$this->crud_model->update_frontend_settings();
			$this->session->set_flashdata('flash_message', get_phrase('frontend_settings_updated'));
			redirect(site_url('admin/frontend_settings'), 'refresh');
		}
		elseif($param1 == 'image_upload') {
			if (isset($_FILES[$uploaded_image]) && $_FILES[$uploaded_image]['name'] != "") {
				$this->crud_model->website_images_uploader($uploaded_image);
			}
			$this->session->set_flashdata('flash_message', get_phrase('frontend_settings_updated'));
			redirect(site_url('admin/frontend_settings'), 'refresh');
		}

		$page_data['page_name'] = 'frontend_settings';
		$page_data['page_title'] = get_phrase('frontend_settings');
		$this->load->view('backend/index', $page_data);
	}

	public function map_settings($param1 = "") {
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('login'), 'refresh');
		}

		if ($param1 == 'map_update') {
			$this->crud_model->update_map_settings();
			$this->session->set_flashdata('flash_message', get_phrase('map_settings_updated'));
			redirect(site_url('admin/map_settings'), 'refresh');
		}

		$page_data['page_name'] = 'map_settings';
		$page_data['page_title'] = get_phrase('map_settings');
		$this->load->view('backend/index', $page_data);
	}

	public function smtp_settings($param1 = "") {
		if ($this->session->userdata('admin_login') != true) {
			redirect(site_url('login'), 'refresh');
		}

		if ($param1 == 'update') {
			$this->crud_model->update_smtp_settings();
			$this->session->set_flashdata('flash_message', get_phrase('smtp_settings_updated'));
			redirect(site_url('admin/smtp_settings'), 'refresh');
		}

		$page_data['page_name'] = 'smtp_settings';
		$page_data['page_title'] = get_phrase('smtp_settings');
		$this->load->view('backend/index', $page_data);
	}


	
	function get_all_php_files() {
		$all_files = $this->get_list_of_directories_and_files();
		foreach ($all_files as $file) {
			$info = pathinfo($file);
			if( isset($info['extension']) && strtolower($info['extension']) == 'php') {
				// echo $file.' <br/> ';
				if ($fh = fopen($file, 'r')) {
					while (!feof($fh)) {
						$line = fgets($fh);
						preg_match_all('/get_phrase\(\'(.*?)\'\)\;/s', $line, $matches);
						foreach ($matches[1] as $matche) {
							get_phrase($matche);
						}
					}
					fclose($fh);
				}
			}
		}

		echo 'I Am So Lit';
	}

	function get_list_of_language_files($dir = APPPATH.'/language', &$results = array()) {
		$files = scandir($dir);
		foreach($files as $key => $value){
			$path = realpath($dir.DIRECTORY_SEPARATOR.$value);
			if(!is_dir($path)) {
				$results[] = $path;
			} else if($value != "." && $value != "..") {
				$this->get_list_of_directories_and_files($path, $results);
				$results[] = $path;
			}
		}
		return $results;
	}

	function get_all_languages() {
		$language_files = array();
		$all_files = $this->get_list_of_language_files();
		foreach ($all_files as $file) {
			$info = pathinfo($file);
			if( isset($info['extension']) && strtolower($info['extension']) == 'json') {
				$file_name = explode('.json', $info['basename']);
				array_push($language_files, $file_name[0]);
			}
		}

		return $language_files;
	}


	/******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
	function manage_profile($param1 = '', $param2 = '', $param3 = '')
	{
		if ($this->session->userdata('admin_login') != 1)
		redirect(site_url('login'), 'refresh');
		if ($param1 == 'update_profile_info') {
			$this->user_model->edit_user($param2);
			redirect(site_url('admin/manage_profile'), 'refresh');
		}
		if ($param1 == 'change_password') {
			$this->user_model->change_password($param2);
			redirect(site_url('admin/manage_profile'), 'refresh');
		}
		$page_data['page_name']  = 'manage_profile';
		$page_data['page_title'] = get_phrase('manage_profile');
		$page_data['user_info']  = $this->user_model->get_all_users($this->session->userdata('user_id'))->row_array();
		$this->load->view('backend/index', $page_data);
	}

	function review_modify($param1 = '', $param2 = '', $param3 = '', $param4 = ''){
		if ($this->session->userdata('admin_login') != 1)
			redirect(site_url('login'), 'refresh');

        if($param1 == 'edit'){

        }
        if($param1 == 'delete'){
            $this->db->where('review_id', $param2);
            $this->db->delete('review');
            $this->session->set_flashdata('flash_message', get_phrase('review_deleted'));
        }
        redirect(get_listing_url($param4),'refresh');

	}

}

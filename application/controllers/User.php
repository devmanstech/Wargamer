<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
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
		if ($this->session->userdata('user_login') == true) {
			$this->dashboard();
		}else {
			redirect(site_url('login'), 'refresh');
		}
	}

	public function dashboard() {
		if ($this->session->userdata('user_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		$page_data['page_name'] = 'dashboard';
		$page_data['page_title'] = get_phrase('dashboard');
		$this->load->view('backend/index.php', $page_data);
	}

	public function matches($param1 = '', $param2 = '') {
		if ($this->session->userdata('user_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		if ($param1 == 'add') {
			$this->crud_model->add_match();
			redirect(site_url('user/matches'), 'refresh');
		}elseif ($param1 == 'edit') {
			$this->crud_model->update_match($param2);
			redirect(site_url('user/matches'), 'refresh');
		}elseif ($param1 == 'delete') {
			$this->crud_model->delete_from_table('matches', $param2);
			$this->session->set_flashdata('flash_message', get_phrase('match_deleted'));
			redirect(site_url('user/matches'), 'refresh');
		}

		// $page_data['timestamp_start'] = strtotime('-29 days', time());
		// $page_data['timestamp_end']   = strtotime(date("m/d/Y"));
		$page_data['page_name']  = 'matches';
		$page_data['page_title'] = get_phrase('matches');
		$this->load->view('backend/index', $page_data);
	}

	public function match_form($param1 = '', $param2 = '') {
		if ($this->session->userdata('user_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		if ($param1 == 'add') {
			$page_data['page_name']  = 'match_add_wiz';
			$page_data['page_title'] = get_phrase('add_new_match');
		}elseif ($param1 == 'edit') {
			$page_data['page_name']  = 'match_edit_wiz';
			$page_data['page_title'] = get_phrase('match_edit');
			$page_data['listing_id'] = $param2;
		}
		$this->load->view('backend/index.php', $page_data);
	}


	public function rosters($param1 = "", $param2 = "") {
		if ($this->session->userdata('user_login') != true) {
			redirect(site_url('login'), 'refresh');
		}

		if ($param1 == 'add') {
			$this->user_model->add_roster();
			redirect(site_url('user/rosters'), 'refresh');
		}
		elseif ($param1 == 'view') {
			$this->user_model->view_roster($param2);
			redirect(site_url('user/rosters'), 'refresh');
		}elseif ($param1 == 'delete') {
			$this->crud_model->delete_from_table('roster', $param2);
			$this->session->set_flashdata('flash_message', get_phrase('roster_has_been_deleted'));
			redirect(site_url('user/rosters'), 'refresh');
		}

		$page_data['page_name'] = 'rosters';
		$page_data['page_title'] = get_phrase('rosters');
		$page_data['rosters'] = $this->user_model->get_rosters();
		$this->load->view('backend/index', $page_data);

	}


	public function roster_form($param1 = "", $param2 = "") {
		if ($this->session->userdata('user_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		if ($param1 == 'add') {
			$page_data['page_name']  = 'roster_add';
			$page_data['page_title'] = get_phrase('roster_add');
		}elseif ($param1 == 'view') {
			$page_data['page_name']  = 'roster_view';
			$page_data['page_title'] = get_phrase('parse_roster');
//			$page_data['user_id'] = $param2;
			$page_data['roster'] = $this->user_model->view_roster($param2);
		}
		$this->load->view('backend/index.php', $page_data);
	}

	function search($param1 = "", $param2 = ""){
		if ($this->session->userdata('user_login') != true) {
			redirect(site_url('login'), 'refresh');
		}

		if($param1 == 'start'){
			$page_data['search_button_name'] = 'stop';
			$page_data['page_name'] = 'search_form';
		}elseif($param1 == 'add'){
			$this->user_model->add_queue();
			$page_data['search_button_name'] = 'start';
			$page_data['page_name'] = 'current_match';
			redirect(site_url('user/current_match'), 'refresh');
		}elseif($param1 == 'stop'){
			$user_id = $param2;
			$this->user_model->delete_queue($user_id);

			redirect(site_url('user/current_match'), 'refresh');
		}

		$this->load->view('backend/index.php', $page_data);

	}

	function review_modify($param1 = '', $param2 = '', $param3 = '', $param4 = ''){
		if ($this->session->userdata('user_login') != 1)
			redirect(site_url('login'), 'refresh');

        if($param1 == 'edit'){
        	$data['review_rating'] = $this->input->post('review_rating');
        	$data['review_comment'] = $this->input->post('review_comment');
        	$this->db->where('review_id', $param2);
        	$this->db->update('review', $data);
        	$this->session->set_flashdata('flash_message', get_phrase('review_updated_successfully'));
        }
        if($param1 == 'delete'){
            $this->db->where('review_id', $param2);
            $this->db->delete('review');
            $this->session->set_flashdata('flash_message', get_phrase('review_deleted'));
        }
        $listing_type = $this->db->get_where('listing', array('id' => $param4))->row('listing_type');
        redirect(get_listing_url($param4),'refresh');

	}

	function report() {
		if ($this->session->userdata('user_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		$page_data['page_name'] = 'report';
		$page_data['page_title'] = get_phrase('report');
		$this->load->view('backend/index.php', $page_data);
	}

	function current_match() {
		if ($this->session->userdata('user_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		$page_data['page_name'] = 'current_match';
		$page_data['page_title'] = get_phrase('current_match');
//		$page_data['packages'] = $this->crud_model->get_packages()->result_array();
		$this->load->view('backend/index.php', $page_data);
	}


	function filter_listing_table() {
		$data['status'] 	= sanitizer($this->input->post('status'));
		$date_range = sanitizer($this->input->post('date_range'));
		$date_range = explode(" - ", $date_range);
		$data['timestamp_start'] = strtotime($date_range[0]);
		$data['timestamp_end']   = strtotime($date_range[1]);
		$page_data['listings'] = $this->crud_model->filter_listing_table($data)->result_array();
		$this->load->view('backend/user/filter_listing_table', $page_data);
	}

	function history() {
		if ($this->session->userdata('user_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		$page_data['page_name'] = 'history';
		$page_data['page_title'] = get_phrase('history');
//		$page_data['history'] = $this->crud_model->get_user_specific_purchase_history($this->session->userdata('user_id'))->result_array();
		$this->load->view('backend/index.php', $page_data);
	}

	function package_invoice($package_purchase_history_id = "") {
		if ($this->session->userdata('user_login') != true) {
			redirect(site_url('login'), 'refresh');
		}
		$page_data['page_name'] = 'package_invoice';
		$page_data['page_title'] = get_phrase('invoice');
		$page_data['purchase_history'] = $this->db->get_where('package_purchased_history', array('id' => $package_purchase_history_id))->row_array();
		$this->load->view('backend/index.php', $page_data);
	}

	/******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('user_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'update_profile_info') {
            $this->user_model->edit_user($param2);
            redirect(site_url('user/manage_profile'), 'refresh');
        }
        if ($param1 == 'change_password') {
            $this->user_model->change_password($param2);
            redirect(site_url('user/manage_profile'), 'refresh');
        }
        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['user_info']  = $this->user_model->get_all_users($this->session->userdata('user_id'))->row_array();
        $this->load->view('backend/index', $page_data);
    }
}

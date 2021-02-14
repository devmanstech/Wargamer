<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    // constructor
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('crud_model');
        $this->load->model('frontend_model');
        $this->load->model('email_model');
        $this->load->library('session');
        $this->load->helper('directory');
        // Set the timezone
        date_default_timezone_set(get_settings('timezone'));
    }

    public function index()
    {
        $page_data['page_name']     =   'home';
        $page_data['title']         =   get_phrase('home');
        $this->load->view('frontend/index', $page_data);
    }

    public function login() {
        $page_data['page_name']                 = 'login';
        $page_data['title']                     = get_phrase('get_logged_in');
        $this->load->view('frontend/index', $page_data);
    }

    public function sign_up() {
        $page_data['page_name'] = 'sign_up';
        $page_data['title']         = get_phrase('get_registered_yourself');
        $this->load->view('frontend/index', $page_data);
    }

    public function forgot_password() {
        $page_data['page_name'] = 'forgot_password';
        $page_data['title']         = get_phrase('forgot_password');
        $this->load->view('frontend/index', $page_data);
    }
   
    function profile($inner_page = "") {
        if($this->session->userdata('user_login') != true){
            redirect(site_url('home'), 'refresh');
        }
        if ($inner_page == "" || $inner_page == 'listing_add') {
            $page_data['inner_page']            = 'listing_add';
            $page_data['inner_page_title']  = get_phrase('add_new_listing');
        }elseif ($inner_page == 'manage_own_listing') {
            $page_data['inner_page']            = 'listing_add';
            $page_data['inner_page_title']  = get_phrase('add_new_listing');
        }
        $page_data['page_name']                 = 'user_profile';
        $page_data['title']                         = get_phrase('user_profile');
        $this->load->view('frontend/index', $page_data);
    }


    function blog($param1 = "", $param2 = "")
    {
        if(isset($_GET['search'])):
            $page_data['blogs']         = $this->frontend_model->blog_search($_GET['search']);
        
            $page_data['searching_value'] = $_GET['search'];
            $page_data['blog_detail_page'] = false;
            $page_data['page_name']     = 'blogs';
            $page_data['title']         = get_phrase('posts');            
        
        else:
            $all_blogs = $this->frontend_model->get_blogs()->result_array();
            $total_rows = count($all_blogs);
            $config = array();
            $config = pagintaion($total_rows, 8);
            $config['base_url']  = site_url('home/blog');
            $this->pagination->initialize($config);

            $this->db->where('status', 1);
            $blogs = $this->db->get('blogs', $config['per_page'], $this->uri->segment(3))->result_array();

            $page_data['blogs']         = $blogs;
            $page_data['page_name']     =   'blogs';
            $page_data['searching_value'] = '';
            $page_data['blog_detail_page'] = false;
            $page_data['title']         =   get_phrase('post');
        endif;
        $this->load->view('frontend/index', $page_data);
    }

    function post($param1 = ""){
        $page_data['blog']         = $this->frontend_model->get_blogs($param1)->row_array();
        $page_data['comments']     = $this->frontend_model->get_comments($param1)->result_array();
        $page_data['page_name']     = 'blogs';
        $page_data['searching_value'] = '';
        $page_data['blog_detail_page'] = true;
        $page_data['title']         = $this->frontend_model->get_blogs($param1)->row('title');
        $this->load->view('frontend/index', $page_data);
    }

    function matches($param1 = ""){
        $page_data['matches']         = $this->frontend_model->get_matches();
        $page_data['page_name']     = 'matches';
        $page_data['title']         = 'Matches';
        $this->load->view('frontend/index', $page_data);
    }


    function comment_add($comment_type = ""){
        if ($this->session->userdata('is_logged_in') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $blog_id = $this->input->post('blog_id');
        $blog_name = $this->input->post('blog_name');
        $this->frontend_model->comment_add();
        $this->session->set_flashdata('flash_message', get_phrase('comment_added_successfully'));

        //redirect(site_url('home/post/'.$blog_id.'/'.slugify($blog_name)), 'refresh');
    }

    function update_blog_comment($comment_id = ""){
        if ($this->session->userdata('is_logged_in') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $comment_user_id = $this->frontend_model->get_comment_row($comment_id)->row('user_id');
        if($this->session->userdata('user_id') == $comment_user_id):
            $this->frontend_model->update_blog_comment($comment_id);
            $this->session->set_flashdata('flash_message', get_phrase('comment_deleted_successfully'));
        endif;
    }

    function delete_blog_comment($comment_id = "", $blog_id = ""){
        if ($this->session->userdata('is_logged_in') != true) {
            redirect(site_url('login'), 'refresh');
        }

        $comment_user_id = $this->frontend_model->get_comment_row($comment_id)->row('user_id');
        $blog_name = $this->frontend_model->get_blogs($blog_id)->row('title');

        if($this->session->userdata('admin_login') == 1 || $this->session->userdata('user_id') == $comment_user_id):
            $this->db->where('id', $comment_id);
            $this->db->delete('blog_comments');

            $this->db->where('under_comment_id', $comment_id);
            $this->db->delete('blog_comments');
            $this->session->set_flashdata('flash_message', get_phrase('comment_deleted_successfully'));
        endif;

        redirect(site_url('home/post/'.$blog_id.'/'.slugify($blog_name)), 'refresh');
    }

    function user_account()
    {
        // $page_data['page_name']     =   'user_account';
        // $page_data['title']         =   get_phrase('account');
        // $this->load->view('frontend/index', $page_data);
    }




    // About
    function about() {
        $page_data['page_name']     =   'about';
        $page_data['title']         =   get_phrase('about');
        $this->load->view('frontend/index', $page_data);
    }

    // Terms And Condition
    function terms_and_conditions() {
        $page_data['page_name']     =   'terms_and_conditions';
        $page_data['title']         =   get_phrase('terms_and_conditions');
        $this->load->view('frontend/index', $page_data);
    }

    // Privacy Policy
    function privacy_policy() {
        $page_data['page_name']     =   'privacy_policy';
        $page_data['title']         =   get_phrase('privacy_policy');
        $this->load->view('frontend/index', $page_data);
    }
    // FAQ
    function faq() {
        $page_data['page_name']     =   'faq';
        $page_data['title']         =   get_phrase('frequently_asked_question');
        $this->load->view('frontend/index', $page_data);
    }
    // FAQ
    function cookie_policy() {
        $page_data['page_name']     =   'cookie_policy';
        $page_data['title']         =   get_phrase('cookie_policy');
        $this->load->view('frontend/index', $page_data);
    }
}

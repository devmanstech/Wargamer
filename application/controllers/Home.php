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

    public function matches_view($param1 = ''){
        $this->session->set_userdata('matches_view', $param1);
    }

    function matches()
    {
        $page_data['page_name']     =   'matches';
        $page_data['title']         =   get_phrase('matches');
        $this->load->view('frontend/index', $page_data);
    }



    function match($slug = "", $listing_id) {
        $listing_details = $this->crud_model->get_listing_details($listing_id)->row_array();

        $page_data['geo_json']  = $this->make_geo_json_for_map($this->db->get_where('listing', array('id' => $listing_id))->result_array(), 'listing_single_page'); // Result array is needed for geo json
        $page_data['page_name']  = 'directory_listing';
        $page_data['title']      = $listing_details['name'];
        $page_data['listing_id'] = $listing_id;
        $page_data['slug'] = $slug;
        $page_data['listing_details'] = $listing_details;
        $this->load->view('frontend/index', $page_data);
    }

    function category()
    {
        $page_data['page_name']     =   'category';
        $page_data['title']         =   get_phrase('categories');
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
        elseif($param1 != "" && isset($_GET['category'])):
            $page_data['blogs']         = $this->frontend_model->blog_category_search($param1);
            $page_data['searching_value'] = '';
            $page_data['blog_detail_page'] = false;
            $page_data['page_name']     = 'blogs';
            $page_data['title']         = $this->db->get_where('category', array('id' => $param1))->row('name');
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


    function listing_form($action = "") { // This function only shows the form for adding and editing the listing.
        if ($action == "")
        redirect(site_url('home/listings'), 'refresh');

        if ($action == 'add') {
            if ($this->session->userdata('admin_login') == true) {
                $page_data['page_name'] =   'listing/create';
                $page_data['title']         =   get_phrase('add_listing');
                $this->load->view('frontend/index', $page_data);
            }
            elseif($this->session->userdata('user_login') == true) {
                $page_data['page_name'] =   'listing/create';
                $page_data['title']         =   get_phrase('add_listing');
                $this->load->view('frontend/index', $page_data);
            }else {
                redirect(site_url('home/listings'), 'refresh');
            }
        }elseif($action == 'edit') {

        }
    }

    function listing_review($param1 = '', $param2 = '') {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        $slug = sanitizer($this->input->post('slug'));
        $listing_id = sanitizer($this->input->post('listing_id'));
        $listing_type = $this->db->get_where('listing', array('id' => $listing_id))->row('listing_type');
        $this->frontend_model->post_review();
        redirect(get_listing_url($listing_id), 'refresh');
    }

    function claim_this_listing() {
        if ($this->session->userdata('is_logged_in') != true) {
            redirect(site_url('login'), 'refresh');
        }

        $listing_id = sanitizer($this->input->post('listing_id'));
        $this->frontend_model->claim_this_listing();
        $this->session->set_flashdata('flash_message', get_phrase('your_claimed_sent_successfully'));
        //redirect to routs file
        redirect(get_listing_url($listing_id), 'refresh');
    }

    function report_this_listing() {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $slug = sanitizer($this->input->post('slug'));
        $listing_id = sanitizer($this->input->post('listing_id'));
        $listing_type = $this->db->get_where('listing', array('id' => $listing_id))->row('listing_type');
        $this->frontend_model->report_this_listing();

        //redirect to routs file
        redirect(get_listing_url($listing_id), 'refresh');
    }

    function contact_us($listing_type = "") {
        $listing_id = sanitizer($this->input->post('listing_id'));
        $slug = sanitizer($this->input->post('slug'));
        $listing_details = $this->crud_model->get_listing_details($listing_id)->row_array();
        if ($listing_type == 'restaurant') {
            $data['date'] = sanitizer($this->input->post('dates'));
            $data['adult_guests_for_booking'] = sanitizer($this->input->post('adult_guests_for_booking'));
            $data['child_guests_for_booking'] = sanitizer($this->input->post('child_guests_for_booking'));
            $data['time']    = sanitizer($this->input->post('time'));
            $data['to'] = $listing_details['email'];
            if ($data['date'] != "" && $data['time'] != "") {
                $this->frontend_model->restaurant_booking();
                $this->email_model->restaurant_booking_mail($data);
            }else {
                $this->session->set_flashdata('error_message', get_phrase('fill_all_fields_first'));

                //redirect to routs file
                redirect(get_listing_url($listing_id), 'refresh');
            }

        }elseif ($listing_type == 'hotel') {
            $dates= explode('>', $this->input->post('dates'));
            $data['book_from'] = $dates[0];
            $data['book_to'] = $dates[1];
            $data['adult_guests_for_booking'] = sanitizer($this->input->post('adult_guests_for_booking'));
            $data['child_guests_for_booking'] = sanitizer($this->input->post('child_guests_for_booking'));
            $data['room_type']    = sanitizer($this->input->post('room_type'));
            $data['to'] = $listing_details['email'];
            if ($data['book_from'] != "" && $data['book_to'] != "" && $data['room_type'] != "") {
                $this->frontend_model->hotel_booking();
                $this->email_model->hotel_booking_mail($data);
            }else {
                $this->session->set_flashdata('error_message', get_phrase('fill_all_fields_first'));

                //redirect to routs file
                redirect(get_listing_url($listing_id), 'refresh');
            }

        }elseif ($listing_type == 'beauty') {
            $data['date'] = sanitizer($this->input->post('dates'));
            $data['time']    = sanitizer($this->input->post('time'));
            $data['service'] = sanitizer($this->input->post('service'));
            $data['note'] = sanitizer($this->input->post('note'));
            $data['to'] = $listing_details['email'];
            if ($data['date'] != "" && $data['time'] != "") {
                $this->frontend_model->beauty_service();
                $this->email_model->beauty_service_mail($data);
            }else {
                $this->session->set_flashdata('error_message', get_phrase('fill_all_fields_first'));

                //redirect to routs file
                redirect(get_listing_url($listing_id), 'refresh');
            }

        }else {
            $data['name'] = sanitizer($this->input->post('name'));
            $data['message'] = sanitizer($this->input->post('message'));
            $data['to'] = $listing_details['email'];

            if ($data['name'] != "" && $data['message'] != "") {
                $this->email_model->contact_us_mail($data);
            }else {
                $this->session->set_flashdata('error_message', get_phrase('fill_all_fields_first'));

                //redirect to routs file
                redirect(get_listing_url($listing_id), 'refresh');
            }

        }
        $this->session->set_flashdata('flash_message', get_phrase('your_mail_has_been_sent_to_recipient'));

        //redirect to routs file
        redirect(get_listing_url($listing_id), 'refresh');
    }

    // //For custom pagination
    // function search($page_number = 1) {
    //     $search_string = $_GET['search_string'];
    //     $selected_category_id = $_GET['selected_category_id'];

    //     $all_listings = $this->frontend_model->search_listing_all_rows($search_string, $selected_category_id);
    //     $listings = $this->frontend_model->search_listing($search_string, $selected_category_id, $page_number);
    //     $geo_json = $this->make_geo_json_for_map($listings);

    //     $page_data['search_string'] = $search_string;
    //     $page_data['selected_category_id'] = $selected_category_id;
    //     $total_listings = count($all_listings);
    //     if($total_listings > 8):
    //         $page_data['pagination'] = true;
    //         $total_page_number = $total_listings/8;
    //         if($total_page_number%2 != 0):
    //             $total_page_number = intval($total_page_number) + 1;
    //         endif;

    //         $page_data['total_page_number'] = $total_page_number;
    //         $page_data['active_page_number']= $page_number;
    //     else:
    //         $page_data['pagination'] = false;
    //     endif;
    //     $page_data['page_name']     = 'listings';
    //     $page_data['title']         = get_phrase('listings');
    //     $page_data['listings']      = $listings;
    //     $page_data['geo_json']      = $geo_json;
    //     if ($selected_category_id != "") {
    //         $page_data['category_ids'] = array($selected_category_id);
    //     }
    //     if ($search_string != "") {
    //         $page_data['search_string'] = $search_string;
    //     }
    //     $this->load->view('frontend/index', $page_data);
    // }


    // Search function
    function search() {
        $search_string = $_GET['search_string'];
        $selected_category_id = $_GET['selected_category_id'];

        $listings = $this->frontend_model->search_listing($search_string, $selected_category_id);
        $geo_json = $this->make_geo_json_for_map($listings);
        $page_data['page_name']     = 'listings';
        $page_data['title']         = get_phrase('listings');
        $page_data['listings']      = $listings;
        $page_data['geo_json']      = $geo_json;
        if ($selected_category_id != "") {
            $page_data['category_ids'] = array($selected_category_id);
        }
        if ($search_string != "") {
            $page_data['search_string'] = $search_string;
        }
        $this->load->view('frontend/index', $page_data);
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
    // Ajax calls
    function get_city_list_by_country_id() {
        $page_data['country_id'] = sanitizer($this->input->post('country_id'));
        return $this->load->view('frontend/city_list_dropdown', $page_data);
    }

    function page_missing() {
        $page_data['page_name']     =   '404';
        $page_data['title']         =   get_phrase('page_not_found');
        $this->load->view('frontend/index', $page_data);
    }
    function beauty_service_time($param1 = '', $param2 = ''){
        $this->crud_model->beauty_service_checking_time($param1, $param2);
    }

    function footer_more_category($view_limitation = ""){
        $page_data['limitation'] = $view_limitation;
        $this->load->view('frontend/footer_more_category', $page_data);
    }

    function home_categories(){
        $this->load->view('frontend/home_categories');
    }
}

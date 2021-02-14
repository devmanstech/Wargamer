<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_model extends CI_Model {

  function __construct()
  {
    parent::__construct();
    /*cache control*/
    $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    $this->output->set_header('Pragma: no-cache');
    $this->load->helper("file");
  }
  function make_json($param) {
    $array = array();
    if(sizeof($param) > 0){
      foreach ($param as $row) {
        if ($row != "") {
          array_push($array, $row);
        }
      }
    }
    return json_encode($array);
  }


// This function removes all the exisiting data of a certain listing
function remove_from_other_tables($listing_type = "", $listing_id = "") {

  if ($listing_type != "hotel") {
    $this->db->where('listing_id', $listing_id);
    $this->db->delete('hotel_room_specification');
  }
  if ($listing_type != "shop") {
    $this->db->where('listing_id', $listing_id);
    $this->db->delete('product_details');
  }
  if ($listing_type != "restaurant") {
    $this->db->where('listing_id', $listing_id);
    $this->db->delete('food_menu');
  }
  if ($listing_type != "beauty") {
    $this->db->where('listing_id', $listing_id);
    $this->db->delete('beauty_service');
  }
}
function delete_from_table($table_name = "", $id) {
  $this->db->where('id', $id);
  $this->db->delete($table_name);
}
function trim_file_name($old_file_name) {
  $new_file_name = trim(addslashes($old_file_name));
  $new_file_name = str_replace(' ', '_', $new_file_name);
  return $new_file_name;
}


public function update_system_settings() {
  $data['description'] = sanitizer($this->input->post('website_title'));
  $this->db->where('type', 'website_title');
  $this->db->update('settings', $data);

  $data['description'] = sanitizer($this->input->post('system_title'));
  $this->db->where('type', 'system_title');
  $this->db->update('settings', $data);

  $data['description'] = sanitizer($this->input->post('language'));
  $this->db->where('type', 'language');
  $this->db->update('settings', $data);

  $data['description'] = sanitizer($this->input->post('text_align'));
  $this->db->where('type', 'text_align');
  $this->db->update('settings', $data);

  $data['description'] = sanitizer($this->input->post('system_email'));
  $this->db->where('type', 'system_email');
  $this->db->update('settings', $data);

  $data['description'] = $this->input->post('address');
  $this->db->where('type', 'address');
  $this->db->update('settings', $data);

  $data['description'] = sanitizer($this->input->post('phone'));
  $this->db->where('type', 'phone');
  $this->db->update('settings', $data);

  $data['description'] = sanitizer($this->input->post('purchase_code'));
  $this->db->where('type', 'purchase_code');
  $this->db->update('settings', $data);

  $data['description'] = sanitizer($this->input->post('vat_percentage'));
  $this->db->where('type', 'vat_percentage');
  $this->db->update('settings', $data);

  $data['description'] = sanitizer($this->input->post('country_id'));
  $this->db->where('type', 'country_id');
  $this->db->update('settings', $data);

  $data['description'] = sanitizer($this->input->post('timezone'));
  $this->db->where('type', 'timezone');
  $this->db->update('settings', $data);

  $data['description'] = sanitizer($this->input->post('footer_text'));
  $this->db->where('type', 'footer_text');
  $this->db->update('settings', $data);

  $data['description'] = sanitizer($this->input->post('footer_link'));
  $this->db->where('type', 'footer_link');
  $this->db->update('settings', $data);
}

public function update_frontend_settings() {
  $data['description'] = sanitizer($this->input->post('banner_title'));
  $this->db->where('type', 'banner_title');
  $this->db->update('frontend_settings', $data);

  $data['description'] = sanitizer($this->input->post('banner_sub_title'));
  $this->db->where('type', 'banner_sub_title');
  $this->db->update('frontend_settings', $data);

  $data['description'] = sanitizer($this->input->post('slogan'));
  $this->db->where('type', 'slogan');
  $this->db->update('frontend_settings', $data);

  $data['description'] = $this->input->post('about_us');
  $this->db->where('type', 'about_us');
  $this->db->update('frontend_settings', $data);

  $data['description'] = $this->input->post('terms_and_condition');
  $this->db->where('type', 'terms_and_condition');
  $this->db->update('frontend_settings', $data);

  $data['description'] = $this->input->post('privacy_policy');
  $this->db->where('type', 'privacy_policy');
  $this->db->update('frontend_settings', $data);

  $data['description'] = $this->input->post('faq');
  $this->db->where('type', 'faq');
  $this->db->update('frontend_settings', $data);

  $social_links = array(
    'facebook' => sanitizer($this->input->post('facebook')),
    'twitter' => sanitizer($this->input->post('twitter')),
    'linkedin' => sanitizer($this->input->post('linkedin')),
    'google' => sanitizer($this->input->post('google')),
    'instagram' => sanitizer($this->input->post('instagram')),
    'pinterest' => sanitizer($this->input->post('pinterest'))
  );

  $data['description'] = json_encode($social_links);
  $this->db->where('type', 'social_links');
  $this->db->update('frontend_settings', $data);

  if($this->input->post('cookie_status') == 1):
    $data['description'] = $this->input->post('cookie_status');
  else:
    $data['description'] = 0;
  endif;
  $this->db->where('type', 'cookie_status');
  $this->db->update('frontend_settings', $data);

  $data['description'] = $this->input->post('cookie_note');
  $this->db->where('type', 'cookie_note');
  $this->db->update('frontend_settings', $data);

  $data['description'] = $this->input->post('cookie_policy');
  $this->db->where('type', 'cookie_policy');
  $this->db->update('frontend_settings', $data);
}

function update_smtp_settings() {

  $data['description'] = sanitizer($this->input->post('smtp_protocol'));
  $this->db->where('type', 'protocol');
  $this->db->update('settings', $data);

  $data['description'] = sanitizer($this->input->post('smtp_user'));
  $this->db->where('type', 'smtp_user');
  $this->db->update('settings', $data);

  $data['description'] = sanitizer($this->input->post('smtp_pass'));
  $this->db->where('type', 'smtp_pass');
  $this->db->update('settings', $data);

  $data['description'] = sanitizer($this->input->post('smtp_host'));
  $this->db->where('type', 'smtp_host');
  $this->db->update('settings', $data);

  $data['description'] = sanitizer($this->input->post('smtp_port'));
  $this->db->where('type', 'smtp_port');
  $this->db->update('settings', $data);

}

function website_images_uploader($image_type = "") {
  if ($image_type == 'banner_image') {
    move_uploaded_file($_FILES['banner_image']['tmp_name'], 'uploads/system/home_banner.jpg');
  }
  if ($image_type == 'light_logo') {
    move_uploaded_file($_FILES['light_logo']['tmp_name'], 'assets/global/light_logo.png');
  }
  if ($image_type == 'dark_logo') {
    move_uploaded_file($_FILES['dark_logo']['tmp_name'], 'assets/global/dark_logo.png');
  }
  if ($image_type == 'small_logo') {
    move_uploaded_file($_FILES['small_logo']['tmp_name'], 'assets/global/logo-sm.png');
  }
  if ($image_type == 'favicon') {
    move_uploaded_file($_FILES['favicon']['tmp_name'], 'assets/global/favicon.png');
  }
}
//blog select
public function get_blogs($blog_id = ""){
  if($blog_id > 0){
    $this->db->where('id', $blog_id);
  }
  return $this->db->get('blogs');
}

public function add_blog(){
  $data['title'] = sanitizer($this->input->post('title'));

  $data['blog_text'] = $this->input->post('blog_text');
  $data['blog_thumbnail'] = md5(rand()).'.jpg';
  $data['blog_cover'] = md5(rand()).'.jpg';
  $data['user_id'] = $this->session->userdata('user_id');
  $data['status'] = 1;
  $data['added_date'] = strtotime(date('dMY'));
  $this->db->insert('blogs', $data);
  move_uploaded_file($_FILES['blog_thumbnail']['tmp_name'], 'uploads/blog_thumbnails/'.$data['blog_thumbnail']);
  move_uploaded_file($_FILES['blog_cover']['tmp_name'], 'uploads/blog_cover_images/'.$data['blog_cover']);
}

public function edit_blog($param1 = ""){
  $data['title'] = sanitizer($this->input->post('title'));
  
  $data['blog_text'] = $this->input->post('blog_text');
  $data['blog_thumbnail'] = sanitizer($this->input->post('blog_thumbnail_name'));
  $data['blog_cover'] = sanitizer($this->input->post('blog_cover_name'));
  $data['modified_date'] = strtotime(date('dMY'));
  $this->db->where('id', $param1);
  $this->db->update('blogs', $data);
  move_uploaded_file($_FILES['blog_thumbnail']['tmp_name'], 'uploads/blog_thumbnails/'.$data['blog_thumbnail']);
  move_uploaded_file($_FILES['blog_cover']['tmp_name'], 'uploads/blog_cover_images/'.$data['blog_cover']);
}

public function blog_status($param1 = "", $param2 = ""){
  if($param1 == 'active'):
    $data['status'] = 1;
  elseif($param1 == 'inactive'):
    $data['status'] = 0;
  endif;
  $this->db->where('id', $param2);
  $this->db->update('blogs', $data);
}

public function delete_blog($param1 = ""){
  $thumbnail_image = $this->db->get_where('blogs', array('id' => $param1))->row('blog_thumbnail');
  $cover_image = $this->db->get_where('blogs', array('id' => $param1))->row('blog_cover');
  unlink('uploads/blog_thumbnails/'.$thumbnail_image);
  unlink('uploads/blog_cover_images/'.$cover_image);
  $this->db->where('id', $param1);
  $this->db->delete('blogs');
}

function get_application_details() {
  $purchase_code = get_settings('purchase_code');
  $returnable_array = array(
    'purchase_code_status' => get_phrase('not_found'),
    'support_expiry_date'  => get_phrase('not_found'),
    'customer_name'        => get_phrase('not_found')
  );

  $personal_token = "gC0J1ZpY53kRpynNe4g2rWT5s4MW56Zg";
  $url = "https://api.envato.com/v3/market/author/sale?code=".$purchase_code;
  $curl = curl_init($url);

  //setting the header for the rest of the api
  $bearer   = 'bearer ' . $personal_token;
  $header   = array();
  $header[] = 'Content-length: 0';
  $header[] = 'Content-type: application/json; charset=utf-8';
  $header[] = 'Authorization: ' . $bearer;

  $verify_url = 'https://api.envato.com/v1/market/private/user/verify-purchase:'.$purchase_code.'.json';
    $ch_verify = curl_init( $verify_url . '?code=' . $purchase_code );

    curl_setopt( $ch_verify, CURLOPT_HTTPHEADER, $header );
    curl_setopt( $ch_verify, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch_verify, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch_verify, CURLOPT_CONNECTTIMEOUT, 5 );
    curl_setopt( $ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

    $cinit_verify_data = curl_exec( $ch_verify );
    curl_close( $ch_verify );

    $response = json_decode($cinit_verify_data, true);

    if (count($response['verify-purchase']) > 0) {

      //print_r($response);
      $item_name 				= $response['verify-purchase']['item_name'];
      $purchase_time 			= $response['verify-purchase']['created_at'];
      $customer 				= $response['verify-purchase']['buyer'];
      $licence_type 			= $response['verify-purchase']['licence'];
      $support_until			= $response['verify-purchase']['supported_until'];
      $customer 				= $response['verify-purchase']['buyer'];

      $purchase_date			= date("d M, Y", strtotime($purchase_time));

      $todays_timestamp 		= strtotime(date("d M, Y"));
      $support_expiry_timestamp = strtotime($support_until);

      $support_expiry_date	= date("d M, Y", $support_expiry_timestamp);

      if ($todays_timestamp > $support_expiry_timestamp)
      $support_status		= get_phrase('expired');
      else
      $support_status		= get_phrase('valid');

      $returnable_array = array(
        'purchase_code_status' => $support_status,
        'support_expiry_date'  => $support_expiry_date,
        'customer_name'        => $customer
      );
    }
    else {
      $returnable_array = array(
        'purchase_code_status' => 'invalid',
        'support_expiry_date'  => 'invalid',
        'customer_name'        => 'invalid'
      );
    }

    return $returnable_array;
  }

  function curl_request($code = '') {

        $product_code = $code;

        $personal_token = "FkA9UyDiQT0YiKwYLK3ghyFNRVV9SeUn";
        $url = "https://api.envato.com/v3/market/author/sale?code=".$product_code;
        $curl = curl_init($url);

        //setting the header for the rest of the api
        $bearer   = 'bearer ' . $personal_token;
        $header   = array();
        $header[] = 'Content-length: 0';
        $header[] = 'Content-type: application/json; charset=utf-8';
        $header[] = 'Authorization: ' . $bearer;

        $verify_url = 'https://api.envato.com/v1/market/private/user/verify-purchase:'.$product_code.'.json';
        $ch_verify = curl_init( $verify_url . '?code=' . $product_code );

        curl_setopt( $ch_verify, CURLOPT_HTTPHEADER, $header );
        curl_setopt( $ch_verify, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch_verify, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch_verify, CURLOPT_CONNECTTIMEOUT, 5 );
        curl_setopt( $ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $cinit_verify_data = curl_exec( $ch_verify );
        curl_close( $ch_verify );

        $response = json_decode($cinit_verify_data, true);

        if (count($response['verify-purchase']) > 0) {
            return true;
        } else {
            return false;
        }
  	}

    public function beauty_service_checking_time($param1 = '', $param2 = ''){
      $times = $this->db->get_where('beauty_service', array('id' => $param1))->row('service_times');
      $time = explode(',', $times);
      $starting_hour_and_minute = explode(':', $time[0]);
      $ending_hour_and_minute = explode(':', $time[1]);

      $booking_time_hour_and_minute = explode(':', $param2);

      if($starting_hour_and_minute[0] == $booking_time_hour_and_minute[0]){
          if($starting_hour_and_minute[1] <= $booking_time_hour_and_minute[1])
          {
              echo 1;
          }else{
              echo 0;
          }

      }elseif($ending_hour_and_minute[0] == $booking_time_hour_and_minute[0]){
          if($ending_hour_and_minute[1] >= $booking_time_hour_and_minute[1]){
              echo 1;
          }else{
              echo 0;
          }
      }else{
          if($booking_time_hour_and_minute[0] == 00){
              $booking_hour = 12;
          }else{
              $booking_hour = $booking_time_hour_and_minute[0];
          }

          if($starting_hour_and_minute[0] < $ending_hour_and_minute[0]){
              if($starting_hour_and_minute[0] < $booking_hour && $ending_hour_and_minute[0] > $booking_hour){
                  echo 1;
              }else{
                  echo 0;
              }
          }elseif($starting_hour_and_minute[0] > $ending_hour_and_minute[0]){
              if($starting_hour_and_minute[0] < $booking_hour || $ending_hour_and_minute[0] > $booking_hour){
                  echo 1;
              }else{
                  echo 0;
              }
          }
      }
    }
}

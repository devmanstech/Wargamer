<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    function get_matches() {
        $this->db->where('status', 'active');
        return $this->db->get('match');
    }


    function filter_matches($category_ids = array(), $amenity_ids = array(), $city_id = "", $price_range = 0, $with_video = 0, $with_open = 'all') {
        $match_ids = array();
        $match_ids_with_open = array();
        $match_ids_with_video = array();
        $match_ids_with_this_city = array();
        $match_ids_with_this_price_range = array();

        $this->db->where('status', 'active');
        $matches = $this->db->get('match')->result_array();
        foreach ($matches as $match) {
            $categories = json_decode($match['categories']);
            $amenities  = json_decode($match['amenities']);

            if(!array_diff($category_ids, $categories) && !array_diff($amenity_ids, $amenities)) {

                // push the match id if the video url is not empty
                if ($with_video == 1) {
                    if ($match['video_url'] != "") {
                        if (!in_array($match['id'], $match_ids_with_video)) {
                          array_push($match_ids_with_video, $match['id']);
                        }
                    }
                }else {
                  array_push($match_ids_with_video, $match['id']);
                }

                // push the match id if the opening time matching current time
                if ($with_open == 'open') {

                    $current_day_opening_time = $this->db->get_where('time_configuration', array('match_id' => $match['id']))->row(strtolower(date("l")));
                    $open_and_colseing_time = explode('-', $current_day_opening_time);
                    if($open_and_colseing_time[0] <= date('H') &&  $open_and_colseing_time[1] >= date('H')){
                        if (!in_array($match['id'], $match_ids_with_open)) {
                          array_push($match_ids_with_open, $match['id']);
                        }
                    }
                }else {
                  array_push($match_ids_with_open, $match['id']);
                }

                //Push the match id if the match has this city id
                if ($city_id != "" && $city_id != "all") {
                  if ($match['city_id'] == $city_id) {
                    if (!in_array($match['id'], $match_ids_with_this_city)) {
                      array_push($match_ids_with_this_city, $match['id']);
                    }
                  }
                }else {
                  array_push($match_ids_with_this_city, $match['id']);
                }

                // Push the match id if it lies in this price range
                if ($price_range > 0) {
                  $returned_match_id = $this->check_if_this_match_lies_in_price_range($match['id'], $price_range);
                  if ($returned_match_id > 0) {
                    if (!in_array($returned_match_id, $match_ids_with_this_price_range)) {
                      array_push($match_ids_with_this_price_range, $returned_match_id);
                    }
                  }
                }else {
                  array_push($match_ids_with_this_price_range, $match['id']);
                }

                // If with video checkbox and city checkbox remain unchecked
                if ($with_open != 'open' && $with_video != 1 && $city_id == "" && $price_range == 0) {
                  if (!in_array($match['id'], $match_ids)) {
                    array_push($match_ids, $match['id']);
                  }
                }else {
                    $match_ids = array_intersect($match_ids_with_open, $match_ids_with_video, $match_ids_with_this_city, $match_ids_with_this_price_range);
                    //print_r($match_ids_with_video);
                    // print_r($match_ids_with_this_city);
                    // print_r($match_ids_with_this_price_range);
                    // print_r($match_ids);
                }
            }
        }

        if (count($match_ids) > 0) {
            $this->db->order_by('is_featured', 'desc');
            $this->db->where_in('id', $match_ids);
            return $this->db->get('match')->result_array();
        }else {
            return array();
        }
    }

    function get_amenity($amenity_id = "", $attribute = "") {
        if ($attribute != "") {
            $this->db->select($attribute);
        }

        if ($amenity_id != "") {
            $this->db->where('id', $amenity_id);
        }

        return $this->db->get('amenities');
    }

    // Functions related to review
    function post_review() {
        $data['reviewer_id'] = $this->input->post('reviewer_id');
        $data['match_id'] = sanitizer($this->input->post('match_id'));
        $data['review_rating'] = sanitizer($this->input->post('review_rating'));
        $data['review_comment'] = sanitizer($this->input->post('review_comment'));
        $data['timestamp'] = strtotime(date('D, d-M-Y'));
        $this->db->insert('review', $data);
    }

    function get_match_wise_review($match_id = "") {
        return $this->db->get_where('review', array('match_id' => $match_id))->result_array();
    }

    function get_match_wise_rating($match_id = "") {
        $this->db->select_avg('review_rating');
        $rating = $this->db->get_where('review', array('match_id' => $match_id))->row()->review_rating;
        return number_format((float)$rating, 1, '.', '');
    }

    function get_rating_wise_quality($match_id = "") {
        $rating = $this->get_match_wise_rating($match_id);
        $this->db->where('rating_to >=', $rating);
        $this->db->where('rating_from <=', $rating);
        return $this->db->get('review_wise_quality')->row_array();
    }

    public function get_percentage_of_specific_rating($match_id = "", $rating = "") {
        $total_number_of_reviewers = count($this->get_match_wise_review($match_id));
        $total_number_of_reviewers_of_specific_rating = $this->db->get_where('review', array('match_id' => $match_id, 'review_rating' => $rating))->num_rows();

        if ($total_number_of_reviewers_of_specific_rating > 0) {
            $percentage = ($total_number_of_reviewers_of_specific_rating / $total_number_of_reviewers) * 100;
        }else {
            $percentage = 0;
        }
        return floor($percentage);
    }

    public function get_reviewers_image($email = "") {
        $user_details = $this->db->get_where('user', array('email' => $email));
        if($user_details->num_rows() > 0) {
            return base_url("uploads/user_image/".$user_details->row()->id.'.jpg');
        }else {
            return base_url('uploads/user_image/user.png');
        }
    }


    function claim_this_match() {
      $data['match_id'] = sanitizer($this->input->post('match_id'));
      $data['user_id'] = sanitizer($this->input->post('user_id'));
      $data['full_name'] = sanitizer($this->input->post('full_name'));
      $data['phone'] = sanitizer($this->input->post('phone'));
      $data['additional_information'] = sanitizer($this->input->post('additional_information'));
      $data['status'] = 0;
      $this->db->insert('claimed_match', $data);
    }

    function report_this_match() {
      $data['match_id'] = sanitizer($this->input->post('match_id'));
      $data['reporter_id'] = sanitizer($this->input->post('reporter_id'));
      $data['report'] = sanitizer($this->input->post('report'));
      $data['status'] = 0;
      $data['date_added'] = strtotime(date('D, d M Y'));
      $this->db->insert('reported_match', $data);
    }

    function restaurant_booking(){
        $data['user_id']             = $this->input->post('user_id');
        $data['requester_id']             = $this->input->post('requester_id');
        $data['match_id']               = $this->input->post('match_id');
        $data['match_type']               = $this->input->post('match_type');
        $data['booking_date']             = strtotime($this->input->post('dates'));

        $additional_data['adult_guests']  = $this->input->post('adult_guests_for_booking');
        $additional_data['child_guests']  = $this->input->post('child_guests_for_booking');
        $additional_data['time']          = $this->input->post('time');
        $data['additional_information']   = json_encode($additional_data);

        $data['created_at']               = strtotime(date('dMY'));
        $data['status']                   = 0;
        $this->db->insert('booking', $data);
    }

    function beauty_service(){
        $data['user_id']             = $this->input->post('user_id');
        $data['requester_id']             = $this->input->post('requester_id');
        $data['match_id']               = $this->input->post('match_id');
        $data['match_type']               = $this->input->post('match_type');
        $data['booking_date']             = strtotime($this->input->post('dates'));

        $additional_data['time']          = strtotime($this->input->post('time'));
        $additional_data['service']          = $this->input->post('service');
        $additional_data['note']          = $this->input->post('note');
        $data['additional_information']   = json_encode($additional_data);

        $data['created_at']               = strtotime(date('dMY'));
        $data['status']                   = 0;
        $this->db->insert('booking', $data);
    }

    function hotel_booking(){
        $data['user_id']                  = $this->input->post('user_id');
        $data['requester_id']                  = $this->input->post('requester_id');
        $data['match_id']               = $this->input->post('match_id');
        $data['match_type']               = $this->input->post('match_type');

        $dates= explode('>', $this->input->post('dates'));

        $fromdate = DateTime::createFromFormat('m-d-y', trim($dates[0]));
        $todate = DateTime::createFromFormat('m-d-y', trim($dates[1]));

        //this don't garbage code
        echo "<span style='display: none;'>";
            print_r($fromdate);
            print_r($todate);
        echo "</span>";
        //this don't garbage code

        $data['booking_date']             = strtotime($fromdate->date).' - '.strtotime($todate->date);
        $additional_data['adult_guests']  = $this->input->post('adult_guests_for_booking');
        $additional_data['child_guests']  = $this->input->post('child_guests_for_booking');
        $additional_data['room_type']          = $this->input->post('room_type');
        $data['additional_information']   = json_encode($additional_data);

        $data['created_at']               = strtotime(date('d M Y'));
        $data['status']                   = 0;
        $this->db->insert('booking', $data);
    }

    function get_category_wise_matches($category_id = "") {
        $match_ids = array();
        $matches = $this->get_matches()->result_array();
        foreach ($matches as $match) {
            if(!has_package($match['user_id']) > 0){
                continue;
            }
            $categories = json_decode($match['categories']);
            if(in_array($category_id, $categories)) {
                array_push($match_ids, $match['id']);
            }
        }
        if (count($match_ids) > 0) {
            $this->db->where_in('id', $match_ids);
            $this->db->where('status', 'active');
            return  $this->db->get('match')->result_array();
        }else {
            return array();
        }
    }

    function get_top_ten_matches() {
        $match_ids = array();
        $match_id_with_rating = array();
        $matches = $this->get_matches()->result_array();
        foreach ($matches as $match) {
          if(!has_package($match['user_id']) > 0){
            continue;
          }
          $match_id_with_rating[$match['id']] = $this->get_match_wise_rating($match['id']);
        }
        arsort($match_id_with_rating);
        foreach ($match_id_with_rating as $key => $value) {
            if (count($match_ids) <= 10) {
                array_push($match_ids, $key);
            }
        }
        if (count($match_ids) > 0) {
            $this->db->where_in('id', $match_ids);
            $this->db->where('status', 'active');
            return  $this->db->get('match')->result_array();
        }else {
            return array();
        }
    }

    // //For ustom pagination
    // function search_match($search_string = '', $selected_category_id = '', $page_number = 1) {
    //     if($page_number == 1):
    //         $starting_value = 0;
    //         $end_value = $page_number * 8;
    //     else:
    //         $end_value = $page_number * 8;
    //         $starting_value = $end_value - 8;
    //     endif;
    //     if ($search_string != "") {
    //         $this->db->like('name', $search_string);
    //         $this->db->or_like('description', $search_string);
    //     }

    //     if ($selected_category_id != "") {
    //         $this->db->like('categories', "$selected_category_id");
    //     }
    //     $this->db->order_by('is_featured', 'desc');

    //     $this->db->where('status', 'active');

    //     return  $this->db->get('match', $end_value, $starting_value)->result_array();
    // }

    function search_match($search_string = '', $selected_category_id = '') {
        if ($search_string != "") {
            $this->db->like('name', $search_string);
            $this->db->or_like('description', $search_string);
        }

        if ($selected_category_id != "") {
            $this->db->like('categories', "$selected_category_id");
        }

        $this->db->order_by('is_featured', 'desc');

        $this->db->where('status', 'active');
        return  $this->db->get('match')->result_array();
    }

    function search_match_all_rows($search_string = '', $selected_category_id = '') {
        if ($search_string != "") {
            $this->db->like('name', $search_string);
            $this->db->or_like('description', $search_string);
        }

        if ($selected_category_id != "") {
            $this->db->like('categories', "$selected_category_id");
        }
        $this->db->order_by('is_featured', 'desc');

        $this->db->where('status', 'active');

        return  $this->db->get('match')->result_array();
    }

    function get_the_maximum_price_limit_of_all_matches() {
      $related_tables = array('hotel_room_specification', 'food_menu', 'product_details');
      $maximum_prices = array();
      for ($i=0; $i < count($related_tables); $i++) { // select_max active record didn't work, thats why i had to do in this shitty style
        $prices = array();
        $this->db->select('price');
        $query_price = $this->db->get($related_tables[$i])->result_array();
        foreach ($query_price as $query) {
            array_push($prices, $query['price']);
        }
        if (count($prices) > 0) {
          array_push($maximum_prices, max($prices));
      }else {
          array_push($maximum_prices, 0);
      }
      }
      return max($maximum_prices);
    }

    function check_if_this_match_lies_in_price_range($match_id = "", $price_range = "") {

      $maximum_price = 0;

      if ($price_range > 0) {
        $match_details = $this->db->get_where('match', array('id' => $match_id))->row_array();

        if($match_details['match_type'] == 'hotel') {
          $this->db->select_max('price');
          $maximum_price = $this->db->get_where('hotel_room_specification', array('match_id' => $match_id))->row()->price;

        }elseif ($match_details['match_type'] == 'shop') {
          $this->db->select_max('price');
          $maximum_price = $this->db->get_where('product_details', array('match_id' => $match_id))->row()->price;

        }elseif ($match_details['match_type'] == 'restaurant') {
          $this->db->select_max('price');
          $maximum_price = $this->db->get_where('food_menu', array('match_id' => $match_id))->row()->price;
        }

         // echo $match_id.'-'.$maximum_price.'--'.$price_range.'<br/>';

        // returning part
        if ($price_range >= $maximum_price) {
            return $match_id;
        }else {
            return 0;
        }
      }else {
        return $match_id;
      }
    }

    //user select
    function get_users($user_id = 0){
        if($user_id > 0){
            $this->db->where('id', $user_id);
        }
        return $this->db->get('user');
    }

    //category select
    function get_categories($category_id = 0) {
        if ($category_id > 0) {
          $this->db->where('id', $category_id);
        }
        return $this->db->get('category');
    }

    //blog select
    public function get_blogs($blog_id = ""){
      if($blog_id > 0){
        $this->db->where('id', $blog_id);
      }else{
        $this->db->where('status', 1);
      }
      return $this->db->get('blogs');
    }

    //comment select
    public function get_comments($blog_id = 0, $under_comment_id = 0){
        if($blog_id > 0){
            $this->db->where('blog_id', $blog_id);
        }
        if($under_comment_id > 0){
            $this->db->where('under_comment_id', $under_comment_id);
        }else{
            $this->db->where('under_comment_id', 0);
        }
        return $this->db->get('blog_comments');
    }

    //comment select
    public function get_comment_row($comment_id = 0){
        if($comment_id > 0){
            $this->db->where('id', $comment_id);
        }
        return $this->db->get('blog_comments');
    }

    //blog search
    public function blog_search($searching_key = ""){
        $this->db->like('name', $searching_key);
        $categories = $this->db->get('category')->result_array();

        $this->db->like('title', $searching_key);
        foreach($categories as $category):
            $this->db->or_like('category_id', $category['id']);
        endforeach;
        $this->db->or_like('blog_text', $searching_key);
        $this->db->where('status', 1);
        return $this->db->get('blogs')->result_array();
    }

    public function blog_category_search($category_id = ""){

        $this->db->where('category_id', $category_id);
        $this->db->where('status', 1);
        return $this->db->get('blogs')->result_array();
    }

    public function latest_blog_post(){
        $this->db->order_by('added_date', 'desc');
        $this->db->limit(4);
        $this->db->where('status', 1);
        return $this->db->get('blogs')->result_array();
    }

    public function comment_add(){
        $data['blog_id'] = sanitizer($this->input->post('blog_id'));
        $data['comment'] = sanitizer($this->input->post('comment'));
        $data['user_id'] = sanitizer($this->session->userdata('user_id'));
        $data['under_comment_id'] = sanitizer($this->input->post('under_comment_id'));
        $data['added_date'] = strtotime(date('dMY'));
        $this->db->insert('blog_comments', $data);
    }

    public function update_blog_comment($comment_id = ""){
        $data['modified_date'] = strtotime(date('dMY'));
        $data['comment'] = sanitizer($this->input->post('comment'));
        $this->db->where('id', $comment_id);
        $this->db->update('blog_comments', $data);
    }





}

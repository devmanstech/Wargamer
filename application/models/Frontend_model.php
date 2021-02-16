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
        $this->db->where('status', '1');
        $this->db->order_by('created_at','DESC');
        return $this->db->get('match')->result_array();
    }




    //user select
    function get_users($user_id = 0){
        if($user_id > 0){
            $this->db->where('id', $user_id);
        }
        return $this->db->get('user');
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
        // $this->db->like('name', $searching_key);
        
        $this->db->like('title', $searching_key);
        
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

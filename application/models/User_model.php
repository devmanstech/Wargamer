<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    function unzip($src_file, $dest_dir=false, $create_zip_name_dir=true, $overwrite=true)
    {

        $fstream = '';
        if ($zip = zip_open($src_file))
        {

            if ($zip)
            {
                $splitter = ($create_zip_name_dir === true) ? "." : "/";
//      if ($dest_dir === false) $dest_dir = substr($src_file, 0, strrpos($src_file, $splitter))."/";


                // Create the directories to the destination dir if they don't already exist
//      create_dirs($dest_dir);

                // For every file in the zip-packet
                while ($zip_entry = zip_read($zip))
                {

                    // Now we're going to create the directories in the destination directories

                    // If the file is not in the root dir
                    $pos_last_slash = strrpos(zip_entry_name($zip_entry), "/");
//        if ($pos_last_slash !== false)
//        {
//          // Create the directory where the zip-entry should be saved (with a "/" at the end)
//          create_dirs($dest_dir.substr(zip_entry_name($zip_entry), 0, $pos_last_slash+1));
//        }

                    // Open the entry
                    if (zip_entry_open($zip,$zip_entry,"r"))
                    {

                        $fstream = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

                        // Close the entry
                        zip_entry_close($zip_entry);
                    }
                }
                // Close the zip-file
                zip_close($zip);
            }
        }
        else
        {
            return false;
        }

        return $fstream;
    }



    public function get_all_users($user_id = 0) {
        if ($user_id > 0) {
            $this->db->where('id', $user_id);
        }
        return $this->db->get('user');
    }

    public function get_users() {
        $this->db->where('role_id', 2);
        return $this->db->get('user');
    }

    function add_user() {
        $data['email'] = sanitizer($this->input->post('email'));
        $data['name'] = sanitizer($this->input->post('name'));
        $data['password'] = sha1(sanitizer($this->input->post('password')));
        $data['address'] = sanitizer($this->input->post('address'));
        $data['phone'] = sanitizer($this->input->post('phone'));
        $data['website'] = sanitizer($this->input->post('website'));
        $data['about'] = sanitizer($this->input->post('about'));
        $social_links = array(
            'facebook' => sanitizer($this->input->post('facebook')),
            'twitter' => sanitizer($this->input->post('twitter')),
            'linkedin' => sanitizer($this->input->post('linkedin')),
        );
        $data['social'] = json_encode($social_links);
        $data['role_id'] = 2;
        $data['wishlists'] = '[]';
        $verification_code =  md5(rand(100000000, 200000000));
        $data['verification_code'] = $verification_code;

        $validity = $this->check_duplication('on_create', $data['email']);
        if($validity){
            if (strtolower($this->session->userdata('role')) == 'admin') {
                $data['is_verified'] = 1;
                $this->db->insert('user', $data);
                $user_id = $this->db->insert_id();
                $this->upload_user_image($user_id);
                $this->session->set_flashdata('flash_message', get_phrase('user_registration_successfully_done'));
            }else {
                $data['is_verified'] = 0;
                $this->db->insert('user', $data);
                $user_id = $this->db->insert_id();
                $this->upload_user_image($user_id);
                $this->email_model->send_email_verification_mail($data['email'], $verification_code);
                $this->session->set_flashdata('flash_message', get_phrase('your_registration_has_been_successfully_done').'. '.get_phrase('please_check_your_mail_inbox_to_verify_your_email_address').'.');
            }
        }else {
            $this->session->set_flashdata('error_message', get_phrase('this_email_id_has_been_taken'));
        }
        return;
    }

    function edit_user($user_id) {
        $data['email'] = sanitizer($this->input->post('email'));
        $data['name'] = sanitizer($this->input->post('name'));
        $data['address'] = sanitizer($this->input->post('address'));
        $data['phone'] = sanitizer($this->input->post('phone'));
        $data['website'] = sanitizer($this->input->post('website'));
        $data['about'] = sanitizer($this->input->post('about'));
        $social_links = array(
            'facebook' => sanitizer($this->input->post('facebook')),
            'twitter' => sanitizer($this->input->post('twitter')),
            'linkedin' => sanitizer($this->input->post('linkedin')),
        );
        $data['social'] = json_encode($social_links);

        $validity = $this->check_duplication('on_update', $data['email'], $user_id);

        if($validity){
            $this->db->where('id', $user_id);
            $this->db->update('user', $data);
            $this->upload_user_image($user_id);
            $this->session->set_flashdata('flash_message', get_phrase('user_updated_successfully'));
        }else {
            $this->session->set_flashdata('error_message', get_phrase('this_email_id_has_been_taken'));
        }
        return;
    }

    public function upload_user_image($user_id) {
        if (isset($_FILES['user_image']) && $_FILES['user_image']['name'] != "") {
            move_uploaded_file($_FILES['user_image']['tmp_name'], 'uploads/user_image/'.$user_id.'.jpg');
        }
    }


    public function get_rosters() {

        return $this->db->get('roster');
    }


    public function add_roster() {

        $data['name'] = sanitizer($this->input->post('name'));

        $validity = $this->check_roster_duplication('on_create', $data['name']);
        if($validity){

            $roster_name = $data['name'];

            $this->upload_roster_file($roster_name);

            $roster_uri = '/uploads/rosters/'.$roster_name.'.zip';

            $res_file = $this->unzip(dirname(BASEPATH).$roster_uri, false, true, true);

            $obj = simplexml_load_string($res_file);

            $costs = $obj->costs->cost;

            foreach($costs as $cost){
                if($cost['name'] == 'pts') {
                    $data['cost'] = floatval($cost['value']);
                }
            }

            $forces = $obj->forces->force;

            foreach($forces as $force){
                $data['catalogue_name'] = $force['catalogueName'];
            }

            $this->db->insert('roster', $data);

            $this->session->set_flashdata('flash_message', get_phrase('roster_file_saved_successfully_done'));
        }else {
            $this->session->set_flashdata('error_message', get_phrase('this_roster_name_has_been_taken'));
        }
        return;
    }


    public function add_queue(){
        $data['user_id'] = 1;
        $roster_id = sanitizer($this->input->post('roster'));
        $faction_by_roster  = $this->db->get_where('roster', array('id'=>$roster_id))->result_array();
//        var_dump($faction_by_roster);
//        die();
        $faction = $faction_by_roster[0]['catalogue_name'];
        $data['faction'] = $faction;
        $data['status'] = 1;
        $data['mode'] = sanitizer($this->input->post('main_mode'));
        $data['language_id'] = sanitizer($this->input->post('language'));

        $date = new DateTime('now');

        $data['create_at'] = $date->format('Y-m-d H:i:s');
        $data['update_at'] = $date->format('Y-m-d H:i:s');

//        var_dump($data);
//        die();
        $this->db->insert('queue', $data);

        $this->session->set_flashdata('flash_message', get_phrase('search_queued_successfully_done'));

    }

    public function delete_queue($user_id){
        $this->db->where('user_id', $user_id);
        $this->db->delete('queue');

        $this->session->set_flashdata('flash_message', get_phrase('search_reject_queue'));

    }

    public function upload_roster_file($roster_name) {
        if (isset($_FILES['roster_file']) && $_FILES['roster_file']['name'] != "") {
            move_uploaded_file($_FILES['roster_file']['tmp_name'], 'uploads/rosters/'.$roster_name.'.zip');
        }
    }


    function view_roster($roster_id) {
        return $this->db->get_where('roster', array('id' => $roster_id));
    }


    function get_user_thumbnail($user_id = "") {
        if (file_exists('uploads/user_image/'.$user_id.'.jpg')) {
            return base_url('uploads/user_image/'.$user_id.'.jpg');
        }else {
            return base_url('uploads/user_image/user.png');
        }
    }

    public function check_duplication($action = "", $email = "", $user_id = "") {
        $duplicate_email_check = $this->db->get_where('user', array('email' => $email));

        if ($action == 'on_create') {
            if ($duplicate_email_check->num_rows() > 0) {
                return false;
            }else {
                return true;
            }
        }elseif ($action == 'on_update') {
            if ($duplicate_email_check->num_rows() > 0) {
                if ($duplicate_email_check->row()->id == $user_id) {
                    return true;
                }else {
                    return false;
                }
            }else {
                return true;
            }
        }
    }

    public function check_roster_duplication($action = "", $name = "", $user_id = "") {
        $duplicate_roster_check = $this->db->get_where('roster', array('name' => $name));

        if ($action == 'on_create') {
            if ($duplicate_roster_check->num_rows() > 0) {
                return false;
            }else {
                return true;
            }
        }elseif ($action == 'on_update') {
            if ($duplicate_roster_check->num_rows() > 0) {
                if ($duplicate_roster_check->row()->id == $user_id) {
                    return true;
                }else {
                    return false;
                }
            }else {
                return true;
            }
        }
    }

    public function change_password($user_id) {
        $data = array();
        if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
            $user_details = $this->get_all_users($user_id)->row_array();
            $current_password = sanitizer($this->input->post('current_password'));
            $new_password = sanitizer($this->input->post('new_password'));
            $confirm_password = sanitizer($this->input->post('confirm_password'));

            if ($user_details['password'] == sha1($current_password) && $new_password == $confirm_password) {
                $data['password'] = sha1($new_password);
            }else {
                $this->session->set_flashdata('error_message', get_phrase('mismatch_password'));
                return;
            }
        }

        $this->db->where('id', $user_id);
        $this->db->update('user', $data);
        $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
    }
}

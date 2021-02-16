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


                // For every file in the zip-packet
                while ($zip_entry = zip_read($zip))
                {


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
        $data['role_id'] = 2;
        
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
        
        $data['language'] = sanitizer($this->input->post('language'));
        
        

        $validity = $this->check_duplication('on_update', $data['email'], $user_id);

        if($validity){
            $this->db->where('id', $user_id);
            $this->db->update('user', $data);
            // $this->upload_user_image($user_id);
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



    public function add_roster() {

        $data['name'] = sanitizer($this->input->post('name'));
        $data['user_id'] = sanitizer($this->input->post('user_id'));
        

        $validity = $this->check_roster_duplication('on_create', $data['name']);
        if($validity){

            $roster_name = $data['name'];

            $this->upload_roster_file($roster_name);

            $roster_uri = '/uploads/rosters/'.$roster_name.'.rosz';

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
        $data['user_id'] = sanitizer($this->input->post('user_id'));
        $roster_id = sanitizer($this->input->post('roster'));

        $faction_by_roster  = $this->db->get_where('roster', array('id'=>$roster_id))->result_array();
//        var_dump($faction_by_roster);
//        die();
        $faction = $faction_by_roster[0]['catalogue_name'];
        $point = $faction_by_roster[0]['cost'];
        $data['faction'] = $faction;
        $data['points'] = $point;
        $data['status'] = 1;
        $data['mode'] = sanitizer($this->input->post('main_mode'));
        $data['language'] = sanitizer($this->input->post('language'));
        $data['roster_id'] = $roster_id;
        $date = new DateTime('now');

        $data['create_at'] = $date->format('Y-m-d H:i:s');
        $data['update_at'] = $date->format('Y-m-d H:i:s');

        $this->db->insert('queue', $data);

        $this->session->set_flashdata('flash_message', get_phrase('search_queued_successfully_done'));

        sleep(5);
        //check if there is opponent
        return $this->check_queue($data['user_id']);

    }

    public function check_queue($user_id){
       
        $current_search = $this->db->get_where('queue',array('user_id'=>$user_id))->result_array();
        $current_search_roster_id = $current_search[0]['roster_id']   ;  
        $current_search_lang = explode(',', $current_search[0]['language']);
        $current_search_point = $current_search[0]['points'];
        $current_search_mode = $current_search[0]['mode'];
        $current_search_faction = $current_search[0]['faction'];
        $current_search_status = $current_search[0]['status'];
        // if you are selected , then finish search automatically and goto match page
        if($current_search_status == 2){
            $current_search_match_id = $current_search[0]['match_id'];
            //delete queue
            $this->delete_queue($user_id);
            //add to current match 
            $this->add_current_match($user_id, $current_search_match_id);

            $this->session->set_flashdata('flash_message', "Match created successfully");
            return $current_search_match_id;
        }else{
            $queues = $this->db->order_by('create_at', 'ASC')->get('queue')->result_array();
            foreach($queues as $queue){
    
                
                $queue_lang = explode(',',$queue['language']);
                $queue_point = $queue['points'];
                $queue_mode = $queue['mode'];
                $queue_user_id = $queue['user_id'];
                $queue_faction = $queue['faction'];
                $queue_roster_id = $queue['roster_id'];                
    
                if($queue_user_id == $user_id) continue;
    
                //check language
    
                if (count(array_intersect($current_search_lang, $queue_lang)) == 0){
                    
                    continue;
                } 
    
                //check points
                if($current_search_point <= 1000 && $queue_point > 1000) continue;
                if($current_search_point > 1000 && $queue_point <= 1000) continue;
    
                // make match        

    
                $match_id = $this->add_match($user_id, $queue_user_id, $current_search_faction, $queue_faction,$current_search_roster_id,$queue_roster_id,$current_search_point<=1000 ? 0 : 1);
                
                $this->session->set_flashdata('flash_message', "Match created successfully");
                //add match id to opponents queue
                $this->update_queue($queue_user_id,$match_id);
                $this->add_current_match($user_id, $match_id);
                $this->delete_queue($user_id);
                return $match_id;                
            }        
    
            return false;
        }


    }

    public function check_opponent( $match_id,$opponent_id){
        $match = $this->db->get_where('match',array('id'=>$match_id))->result_array();
        $current_match = $match[0];

        // var_dump($opponent_id);
        // die();

        $data['status'] = $current_match['status'];

        if($opponent_id == $current_match['player1_id']){
            $data['score'] = $current_match['player1_score'];
            $data['comment'] = $current_match['player1_comment'];
            $data['agree_status'] = $current_match['player1_agree_status'];
            $data['secondary'] = json_decode($current_match['player1_secondary_score']);
            
        }else{
            $data['score'] = $current_match['player2_score'];
            $data['comment'] = $current_match['player2_comment'];
            $data['agree_status'] = $current_match['player2_agree_status'];
            $data['secondary'] = json_decode($current_match['player2_secondary_score']);
        }

        if($current_match['player1_agree_status'] == '1' && $current_match['player2_agree_status'] == '1' ){
            $data['html'] = '<button style="float:right" id="finish_match" class="btn btn-success" onClick="finish_match()">Finish Match</button>
            <script>
            function finish_match(){
                $.post("/user/current_match/complete/'.$match_id.' ", {
			
			},
			function (data) {

                location.reload();
			}
		);

            }
            </script>';
        }else{
            $data['html'] = '';
        }
        return json_encode($data);
    }

    public function complete_match($match_id){
        $match = $this->db->get_where('match',array('id'=>$match_id))->result_array();
        $current_match = $match[0];
        $player1_secondary_scores = json_decode($current_match['player1_secondary_score']);
        $player2_secondary_scores = json_decode($current_match['player2_secondary_score']);

        $player1_score = intval($current_match['player1_score']);
        $player2_score = intval($current_match['player2_score']);

        foreach($player1_secondary_scores as $player1_secondary_score){
            $player1_score += intval($player1_secondary_score);
        }

        foreach($player2_secondary_scores as $player2_secondary_score){
            $player2_score += intval($player2_secondary_score);
        }

        if($current_match['player1_agree_status'] == '1' && $current_match['player2_agree_status'] == '1' ){
            $data['status']  = 1;
            if($player1_score > $player2_score){
                $data['winner'] = $current_match['player1_id'];
            }else if($player1_score < $player2_score){
                $data['winner'] = $current_match['player2_id'];
            }else{
                $data['winner'] = 0;
            }
            $date = new DateTime('now');
            $data['finished_at'] = $date->format('Y-m-d H:i:s');
            $this->db->where('id', $match_id);
            $this->db->update('match',$data);
            $this->session->set_flashdata('flash_message', get_phrase('match_completed_successfully'));
        }else{
            $this->session->set_flashdata('flash_message', get_phrase('match_can_not_complete'));
        }
    }

    public function leave_match(){
        $user_id = $this->session->userdata('user_id');
        $current_match_id = $this->db->get_where('current_match',array('user_id'=>$user_id))->row('match_id');

        $data['status'] = '2';
        $this->db->where('id', $current_match_id);
        $this->db->update('match',$data);
        $this->session->set_flashdata('flash_message', get_phrase('you_left_match'));
    }

    public function add_current_match($user_id, $match_id){
        $data['user_id'] = $user_id;
        $data['match_id'] = $match_id;

        $res = $this->db->get_where('current_match', array('user_id'=>$user_id))->result_array();
        if(count($res)){
            $this->db->where('user_id', $user_id);
            $this->db->update('current_match', $data);
        }else{
            $this->db->insert('current_match', $data);
        }
    }


    public function save_current_match($user_id){
        $user_id = sanitizer($this->input->post('user_id'));
        $match_id = sanitizer($this->input->post('match_id'));
        $score = sanitizer($this->input->post('score'));
        $comment = sanitizer($this->input->post('comment'));

        $secondary_names = sanitizer($this->input->post('secondary_name'));
        $secondary_scores = sanitizer($this->input->post('secondary_score'));

        $secodary = array();
        for($i=0;$i<count($secondary_names);$i++){
            $secodary[$secondary_names[$i]] = $secondary_scores[$i];
        }

        $agree_status = sanitizer($this->input->post('agree_status'));
        
        
        $match = $this->db->get_where('match',array('id'=>$match_id))->result_array();
        
        $current_match = $match[0];
    
        if($current_match['player1_id'] == $user_id){
            $data['player1_score'] = $score;
            $data['player1_comment'] = $comment;
            $data['player1_agree_status'] = $agree_status ? 1 : 0;
            $data['player1_secondary_score'] = json_encode($secodary);

            $this->db->where('id', $match_id);
            $this->db->update('match',$data);
            
        }else if($current_match['player2_id'] == $user_id){
            $data['player2_score'] = $score;
            $data['player2_comment'] = $comment;
            $data['player2_agree_status'] = $agree_status ? 1 : 0;
            $data['player2_secondary_score'] = json_encode($secodary);

            $this->db->where('id', $match_id);
            $this->db->update('match',$data);
        }
    
    }

    public function update_queue($user_id, $match_id){
        $data['match_id'] = $match_id;
        $data['status'] = 2;
        
        $this->db->where('user_id', $user_id);
        $this->db->update('queue', $data);

    }

    public function delete_queue($user_id){
        $this->db->where('user_id', $user_id);
        $this->db->delete('queue');

    }

    public function add_match($player1_id, $player2_id, $player1_faction, $player2_faction,$player1_roster_id, $player2_roster_id, $points){

        $data['player1_id'] = $player1_id;
        $data['player2_id'] = $player2_id;        

        $data['player1_faction'] = $player1_faction;
        $data['player2_faction'] = $player2_faction;
       
        $data['player1_roster_id'] = $player1_roster_id;
        $data['player2_roster_id'] = $player2_roster_id;

        $data['points'] = $points;
        
   
        $date = new DateTime('now');
        $data['created_at'] = $date->format('Y-m-d H:i:s');
        $data['status'] = 0;
        
        $this->db->insert('match', $data);
        $last_id = $this->db->insert_id();

        $this->session->set_flashdata('flash_message', get_phrase('match_created_successfully'));

        return $last_id;
    }



    public function upload_roster_file($roster_name) {
        if (isset($_FILES['roster_file']) && $_FILES['roster_file']['name'] != "") {
            move_uploaded_file($_FILES['roster_file']['tmp_name'], 'uploads/rosters/'.$roster_name.'.rosz');
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

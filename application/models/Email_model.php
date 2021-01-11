<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->library('email');
	}

	function password_reset_email($new_password = '' , $email = '')
	{
		$query = $this->db->get_where('user' , array('email' => $email));
		if($query->num_rows() > 0)
		{

			$email_msg	=	"Your password has been changed.";
			$email_msg	.=	"Your new password is : ".$new_password."<br />";

			$email_sub	=	"Password reset request";
			$email_to	=	$email;

			$this->send_smtp_mail($email_msg , $email_sub , $email_to);
			//$this->sent_smtp_mail_with_php_mailer_library($email_msg , $email_sub , $email_to);
			return true;
		}
		else
		{
			return false;
		}
	}

	public function send_email_verification_mail($to = "", $verification_code = "") {
		$redirect_url = site_url('login/verify_email_address/'.$verification_code);
		$subject 		= "Verify Email Address";
		$email_msg	=	"<h3>".get_settings('website_title')."</h3>";
		$email_msg	.=	"<b>Hello,</b>";
		$email_msg	.=	"<p>Please click the link below to verify your email address.</p>";
		$email_msg	.=	"<a href = ".$redirect_url." target = '_blank'>Verify Your Email Address</a>";
		$this->send_smtp_mail($email_msg, $subject, $to);
		//$this->sent_smtp_mail_with_php_mailer_library($email_msg, $subject, $to);
	}

	public function restaurant_booking_mail($data = "") {
		$total_people = $data['adult_guests_for_booking'] + $data['child_guests_for_booking'];
		$date = date('D, d-M-Y', strtotime($data['date']));
		$subject 		= "Table Booking Request on $date";
		$email_msg	=	"<b>Hello,</b>";
		$email_msg	.=	"<p>I would like to book a table for ". $total_people ." people. Adults in number is ".$data['adult_guests_for_booking']." and Child in number is ".$data['child_guests_for_booking'].".</p>";
		$email_msg	.=	"<p>I would like to book this on ".$date.". Please let me know from your side.</p>";

		$user_details = $this->user_model->get_all_users($this->session->userdata('user_id'))->row_array();

		$this->send_smtp_mail($email_msg, $subject, $data['to'], $user_details['email']);
		//$this->sent_smtp_mail_with_php_mailer_library($email_msg, $subject, $data['to'], $user_details['email']);
	}

	public function beauty_service_mail($data = "") {
		$date = date('D, d-M-Y', strtotime($data['date']));
		$subject 		= "Appointment Booking Request on $date";
		$user_details = $this->user_model->get_all_users($this->session->userdata('user_id'))->row_array();
		$email_msg	=	"<b>Hello,</b>";
		$email_msg	.=	"<p>Time : ".$this->input->post('time')."</p>";
		$email_msg  .=  "<p>Phone: ".$user_details['phone']."</p>";
		$email_msg	.=	"<p>Service : ".$this->db->get_where('beauty_service', array('id' => $this->input->post('service')))->row('name')."</p>";
		$email_msg	.=	"<p>I need to take care of my beauty. Please accept my request and let me know from your side.</p>";

		$this->send_smtp_mail($email_msg, $subject, $data['to'], $user_details['email']);
		//$this->sent_smtp_mail_with_php_mailer_library($email_msg, $subject, $data['to'], $user_details['email']);
	}

	public function hotel_booking_mail($data = "") {
		$total_people = $data['adult_guests_for_booking'] + $data['child_guests_for_booking'];
		$book_from = $data['book_from'];
		$book_to = $data['book_to'];
		$subject 		= "Hotel Room Booking Request from $book_from to $book_to";
		$email_msg	=	"<b>Hello,</b>";
		$email_msg	.=	"<p>I would like to book a ".$data['room_type']." room for ". $total_people ." people. Adults in number is ".$data['adult_guests_for_booking']." and Child in number is ".$data['child_guests_for_booking'].".</p>";
		$email_msg	.=	"<p>I would like to book this from ".$book_from." to ".$book_to.". Please let me know from your side.</p>";

		$user_details = $this->user_model->get_all_users($this->session->userdata('user_id'))->row_array();

		$this->send_smtp_mail($email_msg, $subject, $data['to'], $user_details['email']);
		//$this->sent_smtp_mail_with_php_mailer_library($email_msg, $subject, $data['to'], $user_details['email']);
	}

	public function request_approved_mail($booking_id = "") {
		$booking = $this->db->get_where('booking', array('id' => $booking_id))->row_array();
		$email_msg = '<b>Congratulations ! </b>';
		$email_msg .= '<p>'.$this->db->get_where('listing', array('id' => $booking['listing_id']))->row('name').'</p>';
		$email_msg .= '<p>Your request has been accepted.</p>';
		$email_msg .= '<p>At the right time '.$this->db->get_where('listing', array('id' => $booking['listing_id']))->row('name').' is being asked to attend the '.$booking['listing_type'].' .</p>';
		$subject = 'Approved your request';
		$to		 = $this->db->get_where('user', array('id' => $booking['requester_id']))->row('email');
		$from	 = $this->db->get_where('user', array('id' => $booking['user_id']))->row('email');
		$this->send_smtp_mail($email_msg, $subject, $to, $from);
		//$this->sent_smtp_mail_with_php_mailer_library($email_msg, $subject, $to, $from);

	}

	public function contact_us_mail($data = "") {
		$subject 		= "Contact us";
		$email_msg	=	"Hello, This is <b>".$data['name']."</b>";
		$email_msg	.=	"<p>".$data['message']."</p>";

		$user_details = $this->user_model->get_all_users($this->session->userdata('user_id'))->row_array();
		$this->send_smtp_mail($email_msg, $subject, $data['to'], $user_details['email']);
		//$this->sent_smtp_mail_with_php_mailer_library($email_msg, $subject, $data['to'], $user_details['email']);
	}

	// more stable function
	public function send_smtp_mail($msg=NULL, $sub=NULL, $to=NULL, $from=NULL) {
		//Load email library
		$this->load->library('email');

		if($from == NULL){
				$from		=	get_settings('system_email');
		}

		//SMTP & mail configuration
		$config = array(
			'protocol'  => get_settings('protocol'),
			'smtp_host' => get_settings('smtp_host'),
			'smtp_port' => get_settings('smtp_port'),
			'smtp_user' => get_settings('smtp_user'),
			'smtp_pass' => get_settings('smtp_pass'),
			'mailtype'  => 'html',
			'charset'   => 'utf-8'
			//,
			// 'smtp_timeout' => '30',
			// 'mailpath' => '/usr/sbin/sendmail',
			// 'wordwrap' => TRUE
		);
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");

		$htmlContent = $msg;

		$this->email->to($to);
		$this->email->from($from, get_settings('website_title'));
		$this->email->subject($sub);
		$this->email->message($htmlContent);

		//Send email
		$this->email->send();
	}

	public function sent_smtp_mail_with_php_mailer_library($msg=NULL, $sub=NULL, $to=NULL, $from=NULL) {
		if($from == NULL){
			$from = get_settings('system_email');
		}

		$this->load->library('phpmailer_lib');
		$mail = $this->phpmailer_lib->load();

		$mail->isSMTP();
		$mail->Host 	  = get_settings('smtp_host');
		$mail->SMTPAuth   = true;
		$mail->Username   = get_settings('smtp_user');
		$mail->Password   = get_settings('smtp_pass');
		$mail->SMTPSecure = 'tls';
		$mail->Port 	  = get_settings('smtp_port');

		$mail->setFrom(get_settings('smtp_user'), get_settings('website_title'));
		$mail->addReplyTo($from, get_settings('website_title'));

		//Sent message
		$mail->addAddress($to);

		$mail->Subject = $sub;

		$mail->isHTML(true);

		$mail->Body = $msg;
		if($mail->send()){

		}else{
			$this->session->set_flashdata('error_message', 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo);
		}
	}
}

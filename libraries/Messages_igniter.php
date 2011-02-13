<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Messages Igniter Library
*
* @package		Social Igniter
* @subpackage	Messages Igniter Library
* @author		Brennan Novak
* @link			http://social-igniter.com/pages/modules/messages
*
* Contains methods for Messages Module
*/

class Messages_igniter
{
	function __construct()
	{
		$this->ci =& get_instance();
		
		$this->ci->load->model('messages_model');

		// Config Email	
		$this->ci->load->library('email');
		
		$this->config_email['protocol']  	= config_item('site_email_protocol');
		$this->config_email['mailtype']  	= 'html';
		$this->config_email['charset']  	= 'UTF-8';
		$this->config_email['crlf']			= "\r\n";
		$this->config_email['newline'] 		= "\r\n"; 			
		$this->config_email['wordwrap']  	= FALSE;
		$this->config_email['validate']		= TRUE;
		$this->config_email['priority']		= 1;
		
		if (config_item('site_email_protocol') == 'smtp')
		{
			$this->config_email['smtp_host'] 	= config_item('site_smtp_host');
			$this->config_email['smtp_user'] 	= config_item('site_smtp_user');
			$this->config_email['smtp_pass'] 	= config_item('site_smtp_pass');
			$this->config_email['smtp_port'] 	= config_item('site_smtp_port');
		}

		$this->ci->email->initialize($this->config_email);		
		
	}
	
	/* Messages */
	function get_message($message_id)
	{
		return $this->ci->messages_model->get_message($message_id);
	}

	function get_message_replies($reply_to_id)
	{
		return $this->ci->messages_model->get_message_replies($reply_to_id);
	}
		
	function get_inbox($user_id)
	{
		return $this->ci->messages_model->get_inbox($user_id);
	}

	function get_sent($sender_id)
	{
		return $this->ci->messages_model->get_sent($sender_id);
	}
	
	function get_drafts($sender_id)
	{
		return $this->ci->messages_model->get_drafts($sender_id);
	}

	function get_inbox_new_count($receiver_id)
	{
		return $this->ci->messages_model->get_inbox_new_count($receiver_id);
	}

	function add_message($message_data)
	{		
		if ($message_id = $this->ci->messages_model->add_message($message_data))
		{
			$message	= $this->get_message($message_id);
			
			// If email is enabeled
			if (config_item('messages_notifications_email') == 'TRUE')
			{
				$receiver	= $this->ci->social_auth->get_user($message_data['receiver_id']);
	
				if ($message->reply_to_id)
				{
					$message_id_link = $message->reply_to_id;
				}
				else
				{
					$message_id_link = $message->message_id;
				}
				
				$email_data = array(
					'message_id'		=> $message_id_link,
					'message_subject'	=> $message->subject,
					'message_message'	=> $message->message,
					'message_profile'	=> base_url().'profile/'.$message->username,
					'message_sender'	=> $message->name
				);
			
				$email_message = $this->ci->load->view('../modules/messages/views/emails/message', $email_data, true);
	
				$this->ci->email->set_newline("\r\n");
				$this->ci->email->from(config_item('site_admin_email'), $message->name.' at '.config_item('site_title'));
				$this->ci->email->to($receiver->email);
				$this->ci->email->subject($message->subject);
				$this->ci->email->message($email_message);
				$this->ci->email->send();
			}
		
			return $message;
		}
		else
		{
			return FALSE;
		}
	}

	function update_message_value($message_data)
	{
		if ($update = $this->ci->messages_model->update_message($message_data))
		{
			return $update;
		}

		return FALSE;	
	}
}
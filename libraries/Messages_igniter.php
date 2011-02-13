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
			return $this->get_message($message_id);
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
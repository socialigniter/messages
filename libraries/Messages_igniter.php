<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Blog Library
*
* @package		Social Igniter
* @subpackage	Blog Igniter Library
* @author		Brennan Novak
* @link			http://social-igniter.com
*
* Contains basic blog information
*/
 
class Messages_igniter
{

	function __construct()
	{
		$this->ci =& get_instance();
		
		// Load Universal Models
		$this->ci->load->model('messages_model');

		// Define Congfig Variables
		$this->site_id					= config_item('site_id');

	}
	
	/* Messages */
	function get_inbox($receiver_id)
	{
		return $this->ci->messages_model->get_inbox($receiver_id);
	}

	function get_inbox_new_count($receiver_id)
	{
		return $this->ci->messages_model->get_inbox_new_count($receiver_id);
	}

	function get_sent_or_drafts($sender_id, $status)
	{
		return $this->ci->messages_model->get_sent_or_drafts($sender_id, $status);
	}

	function add_message($message_data)
	{
		$result = $this->ci->messages_model->add_message($this->site_id, $message_data);
		return $result;
	}	

	

	/* Settings */

}
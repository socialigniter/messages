<?php
class Home extends Dashboard_Controller 
{
    function __construct() 
    {
        parent::__construct();

		$this->load->helper('messages');
		$this->load->library('messages_igniter');

		$this->data['page_title']	= 'Messages';
    }
 
 	function mailbox()
 	{
 		$this->data['sub_title']	= ucwords($this->uri->segment(3));
 	
		if ($this->uri->segment(3) == 'inbox')
		{
			$messages = $this->messages_igniter->get_inbox($this->session->userdata('user_id'));	
		}
		elseif ($this->uri->segment(3) == 'sent')
		{
			$messages = $this->messages_igniter->get_sent($this->session->userdata('user_id'));
		}
		elseif ($this->uri->segment(3) == 'drafts')
		{
			$messages = $this->messages_igniter->get_drafts($this->session->userdata('user_id'));	
		}
		else
		{
			redirect(base_url().'home/messages/inbox', 'refresh');
		}

		// Mailbox
		$mailbox_view = NULL;		
		
		if (!empty($messages))
		{
			foreach($messages as $message)
			{
				$this->data['message_id'] 			= $message->message_id;
				$this->data['message_type']			= $message->type;
				$this->data['message_viewed']		= item_viewed('item', $message->viewed);
				$this->data['message_avatar']		= $this->social_igniter->profile_image($message->user_id, $message->image, $message->email);
				$this->data['message_userlink']		= base_url().'profile/'.$message->username;
				$this->data['message_user']			= $message->name;

				$this->data['message_subject']		= character_limiter($message->subject, 45);
				$this->data['message_subject_link']	= base_url().$message->module.'/view/'.$message->message_id;
				$this->data['message_message']		= character_limiter($message->message, 40);
				$this->data['message_sent_date']	= format_datetime(config_item('messages_date_style'), $message->sent_at);

				// Alerts
				$this->data['message_alerts']		= item_alerts_message($message, $this->uri->segment(3));			
				
				// Actions
				$this->data['message_status']		= $message->status;
				$this->data['message_read']			= base_url().'home/messages/read/'.$message->message_id;
				$this->data['message_delete']		= base_url().'api/messages/destroy/id/'.$message->message_id;
				
				// View
				$mailbox_view .= $this->load->view('../modules/messages/views/partials/item_mailbox.php', $this->data, true);
			}
		}
	 	else
	 	{
	 		$mailbox_view = '<li>No messages in '.ucwords($this->uri->segment(3)).'</li>';
 		}

		// Output
		$this->data['mailbox_view'] = $mailbox_view;
		$this->render();
	}
	
	function read()
	{
		$message = $this->messages_igniter->get_message($this->uri->segment(4));
		
		$this->data['read_message']	= $message;
		$this->data['sub_title']	= 'Read';
	
		$this->render();
	}
	
	function compose()
	{		
		$this->data['wysiwyg']	 			= $this->load->view($this->config->item('dashboard_theme').'/partials/wysiwyg', $this->data, true);
		$this->data['users'] 				= $this->social_auth->get_users();

 		$this->data['sub_title']			= 'Compose';
			
		$this->render();
	}

}
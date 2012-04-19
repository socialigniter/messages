<?php
class Home extends Dashboard_Controller 
{
    function __construct() 
    {
        parent::__construct();

		$this->load->helper('messages');
		$this->load->library('messages_igniter');

		$this->data['page_title']	= 'Messages';
		
 		// Folders
 		$this->data['folders'] = $this->social_tools->make_categories_dropdown(array('module' => 'messages', 'type' => 'folder'), $this->session->userdata('user_id'), $this->session->userdata('user_level_id'), '+ Add Folder');		
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
			redirect(base_url().'home/messages/'.$this->uri->segment(3), 'refresh');
		}

		// Mailbox
		$mailbox_view = NULL;		
		
		if (!empty($messages))
		{		
			foreach($messages as $message)
			{		
				$this->data['message_id'] 			= $message->message_id;
				$this->data['message_viewed']		= item_viewed('item', $message->viewed);
				$this->data['message_avatar']		= $this->social_igniter->profile_image($message->user_id, $message->image, $message->gravatar);
				$this->data['message_userlink']		= base_url().'profile/'.$message->username;
				$this->data['message_user']			= $message->name;

				$this->data['message_subject']		= character_limiter($message->subject, 40);
				$this->data['message_message']		= character_limiter($message->message, 40);
				$this->data['message_sent_date']	= format_datetime(config_item('messages_date_style'), $message->sent_at);

				// Alerts
				$this->data['message_alerts']		= item_alerts_message($message, $this->uri->segment(3));			
				
				// Actions
				$this->data['message_status']		= $message->status;
				
				if ($message->reply_to_id)
				{
					$message_id_link = $message->reply_to_id;
				}
				else
				{
					$message_id_link = $message->message_id;
				}
				
				$this->data['message_read']			= base_url().'home/messages/'.$this->uri->segment(3).'/'.$message_id_link;
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
		$this->render('dashboard_wide');
	}
	
	function read()
	{
		$messages_base 			= $this->messages_igniter->get_message($this->uri->segment(4));
		$messages_thread_view	= NULL;

		if ($messages_base)
		{
			$this->data['sub_title'] = $messages_base->subject;

			// Mark as viewed
			if ($messages_base->viewed == 'N') $this->messages_igniter->update_message_value(array('message_id' => $messages_base->message_id, 'viewed' => 'Y'));
		
			$this->data['message_thread_id']	= $messages_base->message_id;
			$this->data['message_id']			= $messages_base->message_id;
			$this->data['message_subject']		= $messages_base->subject;		
			$this->data['message_avatar']		= $this->social_igniter->profile_image($messages_base->user_id, $messages_base->image, $messages_base->gravatar);
			$this->data['message_userlink']		= base_url().'profile/'.$messages_base->username;
			$this->data['message_user']			= $messages_base->name;
			
			if ($messages_base->stripped_html != '') $this->data['message_message'] = strip_tags($messages_base->stripped_html, '<img><b><strong><i><em><p><a><br>');
			else $this->data['message_message']	= $messages_base->message;

			$this->data['message_sent_date']	= format_datetime(config_item('messages_date_style'), $messages_base->sent_at);
		
			$messages_thread		= $this->messages_igniter->get_message_replies($messages_base->message_id);			
			$messages_thread_view  .= $this->load->view('../modules/messages/views/partials/item_message.php', $this->data, true);

			foreach($messages_thread as $message)
			{
				// Mark as viewed
				if (($message->receiver_id == $this->session->userdata('user_id')) && ($message->viewed == 'N')) $this->messages_igniter->update_message_value(array('message_id' => $message->message_id, 'viewed' => 'Y'));

				$this->data['message_id'] 			= $message->message_id;
				$this->data['message_avatar']		= $this->social_igniter->profile_image($message->user_id, $message->image, $message->gravatar);
				$this->data['message_userlink']		= base_url().'profile/'.$message->username;
				$this->data['message_user']			= $message->name;

				$this->data['message_message']		= character_limiter($message->message, 40);
				$this->data['message_sent_date']	= format_datetime(config_item('messages_date_style'), $message->sent_at);			
				
				// Actions
				$this->data['message_status']		= $message->status;
				$this->data['message_delete']		= base_url().'api/messages/destroy/id/'.$message->message_id;
				
				// View
				$messages_thread_view .= $this->load->view('../modules/messages/views/partials/item_message.php', $this->data, true);
			}
		}
	 	else
	 	{
			redirect(base_url().'home/messages/inbox');
 		}

		// Output		
		$this->data['message_thread']		= $messages_thread_view;		
	
		$this->render('dashboard_wide');
	}
	
	function compose()
	{		
		$this->data['wysiwyg']	 			= $this->load->view($this->config->item('dashboard_theme').'/partials/wysiwyg', $this->data, true);
		$this->data['users'] 				= $this->social_auth->get_users('active', 1);

 		$this->data['sub_title']			= 'Compose';
		
		$this->render('dashboard_wide');
	}

	function responses()
	{
		
	
		$this->render('dashboard_wide');
	}
	
	/* Partials */
	function item_message()
	{
		$this->data['message_id']			= '{MESSAGE_ID}';
		$this->data['message_avatar']		= '{AVATAR}';
		$this->data['message_userlink']		= '{USERLINK}';
		$this->data['message_user']			= '{USER}';
		$this->data['message_sent_date']	= '{MESSAGE_DATE}';
		$this->data['message_message']		= '{MESSAGE}';

		$this->load->view('../modules/messages/views/partials/item_message', $this->data);
	}	

}
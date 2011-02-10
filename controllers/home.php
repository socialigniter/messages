<?php
class Home extends Dashboard_Controller 
{
    function __construct() 
    {
        parent::__construct();

		$this->load->library('messages_igniter');

		$this->data['page_title']	= 'Messages';
    }
 
 	function mailbox()
 	{ 	
		if ($this->uri->segment(3) == 'inbox')
		{
			$messages 	= $this->messages_igniter->get_inbox($this->session->userdata('user_id'));	
			$sub_title	= 'Inbox';
		}
		elseif ($this->uri->segment(3) == 'sent')
		{
			$messages 	= $this->messages_igniter->get_sent($this->session->userdata('user_id'));
			$sub_title	= 'Sent';	
		}
		elseif ($this->uri->segment(3) == 'drafts')
		{
			$messages 	= $this->messages_igniter->get_drafts($this->session->userdata('user_id'));	
			$sub_title	= 'Drafts';
		}
		else
		{
			redirect(base_url().'home/messages/inbox', 'refresh');
		}
 		
 		$this->data['sub_title']	= $sub_title;
 		$this->data['messages'] 	= $messages;	
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
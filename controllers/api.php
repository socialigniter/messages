<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * Messages API : Module : Social-Igniter
 *
 */
class Api extends Oauth_Controller
{
    function __construct()
    {
        parent::__construct();  
        
		$this->load->library('messages_igniter');            
	}
	
    function all_get()
    {
    	$messages = $this->messages_model->get_messages();
        
        if($messages)
        {
            $message = array('status' => 'success', 'message' => 'Yay, we found some messages', 'data' => $messages);
        }
        else
        {
            $message = array('status' => 'error', 'message' => 'Could not find any messages');
        }
        
        $this->response($message, 200);        
    }
    
    function view_get()
    {
    	$search_by	= $this->uri->segment(4);
    	$search_for	= $this->uri->segment(5);
    	$messages = $this->messages_model->get_messages_view($search_by, $search_for);

        $this->response($messages, $response);
    }

	function new_authd_get()
	{	
		if ($message_count = $this->messages_igniter->get_inbox_new_count($this->oauth_user_id))
		{
         	$messages = array('status' => 'success', 'message' => 'New messages found', 'data' => $message_count);	
		}
		else
		{
         	$messages = array('status' => 'error', 'message' => 'New messages found', 'data' => $message_count);			
		}	

        $this->response($messages, 200);
	}

    function compose_authd_post()
    {
		$this->form_validation->set_rules('receiver_id', 'Receiver', 'required');
		$this->form_validation->set_rules('module', 'Module', 'required');
		$this->form_validation->set_rules('type', 'Type', 'required');
		$this->form_validation->set_rules('message', 'Message', 'required');

		// Validation
		if ($this->form_validation->run() == true)
		{			
			$receiver = $this->social_auth->get_user('user_id', $this->input->post('receiver_id'));
			
			if (!$this->input->post('site_id')) $site_id = config_item('site_id');
			else 								$site_id = $this->input->post('site_id');

			if (!$this->input->post('status'))	$status	= 'P';
			else 								$status = $this->input->post('status');
			
			if ($receiver)
			{
	        	$message_data = array(
	    			'site_id'		=> $site_id,
	        		'reply_to_id'	=> $this->input->post('reply_to_id'),
	    			'receiver_id'	=> $this->input->post('receiver_id'),	
					'sender_id'		=> $this->oauth_user_id,
					'module'		=> $this->input->post('module'),
	    			'type'			=> $this->input->post('type'),
	    			'subject'		=> $this->input->post('subject'),
	    			'message'		=> $this->input->post('message'),
	    			'geo_lat'		=> $this->input->post('geo_lat'),
	    			'geo_long'		=> $this->input->post('geo_long'),
	    			'viewed'		=> 'N',
	    			'status'		=> $status  			
	        	);
	        	
				// Insert
			    $result = $this->messages_igniter->add_message($message_data, $receiver);
	
				if ($result)
				{
		        	$message = array('status' => 'success', 'message' => 'Message sent to', 'data' => $result, 'receiver' => $receiver);
		        }
		        else
		        {
			        $message = array('status' => 'error', 'message' => 'Oops unable to send your message');
		        }
			}
			else
			{
		        $message = array('status' => 'error', 'message' => 'The person you are trying to message does not exist');
			}
		}
		else 
		{	
	        $message = array('status' => 'error', 'message' => validation_errors());
		}			

        $this->response($message, 200);
    }

    function reply_authd_post()
    {
		$this->form_validation->set_rules('message', 'Message', 'required');

		// Validation
		if ($this->form_validation->run() == true)
		{			
			$message = $this->messages_igniter->get_message($this->get('id'));
			
			if ($message)
			{
				// Site (will need to revise later
				if (!$this->input->post('site_id')) $site_id = config_item('site_id');
				else $site_id = $this->input->post('site_id');	
				
				// Receiver
				if ($message->sender_id == $this->oauth_user_id) $receiver_id = $message->receiver_id;
				else $receiver_id = $message->sender_id;
				
				// Viewed State
				if ($receiver_id == $this->oauth_user_id) $viewed = 'Y';
				else $viewed = 'N';
			
	        	$message_data = array(
	    			'site_id'		=> $site_id,
	        		'reply_to_id'	=> $message->message_id,
	    			'receiver_id'	=> $receiver_id,	
					'sender_id'		=> $this->oauth_user_id,
					'module'		=> $this->input->post('module'),
	    			'type'			=> $this->input->post('type'),
	    			'subject'		=> $message->subject,
	    			'message'		=> $this->input->post('message'),
	    			'geo_lat'		=> $this->input->post('geo_lat'),
	    			'geo_long'		=> $this->input->post('geo_long'),
	    			'viewed'		=> $viewed,
	    			'status'		=> 'P'  			
	        	);
	        	
				// Insert
			    $result = $this->messages_igniter->add_message($message_data);
	
				if ($result)
				{
		        	$message = array('status' => 'success', 'message' => 'Message was sent', 'data' => $result);
		        }
		        else
		        {
			        $message = array('status' => 'error', 'message' => 'Oops unable to send your message');
		        }
			}
			else
			{
		        $message = array('status' => 'error', 'message' => 'That user does exist');
			}
		}
		else 
		{	
	        $message = array('status' => 'error', 'message' => validation_errors());
		}			

        $this->response($message, 200);
    }
    
    function viewed_authd_get()
	{
        if ($this->messages_igniter->update_message_value(array('message_id' => $this->get('id'), 'viewed' => 'Y')))
        {
            $message = array('status' => 'success', 'message' => 'Message viewed');
        }
        else
        {
            $message = array('status' => 'error', 'message' => 'Message could not be marked as viewed');
        }    

        $this->response($message, 200);
    }   
    
    function send_authd_get()
    {
        if ($this->messages_igniter->update_message_value(array('message_id' => $this->get('id'), 'status' => 'P')))
        {
            $message = array('status' => 'success', 'message' => 'Message was sent');
        }
        else
        {
            $message = array('status' => 'error', 'message' => 'Message could not be sent');
        }

        $this->response($message, 200);
    }     
      
    function destroy_get()
    {		
    	if ( $this->social_auth->has_access_to_modify('message', $this->get('id')))
        {   
        	$this->social_tools->delete_message($this->get('id'));
        	        
        	$message = array('status' => 'success', 'message' => 'Message deleted');
        }
        else
        {
            $message = array('status' => 'error', 'message' => 'Could not delete that message');
        }

        $this->response($message, 200);        
    }
}
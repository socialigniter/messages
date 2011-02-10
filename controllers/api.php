<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * Messages API : Core : Social-Igniter
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
            $message 	= array('status' => 'success', 'data' => $messages);
            $response	= 200;
        }
        else
        {
            $message 	= array('status' => 'error', 'message' => 'Could not find any messages');
            $response	= 404;
        }
        
        $this->response($message, $response);        
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
         	$messages = array('status' => 'success', 'message' => $message_count);	
		}
		else
		{
         	$messages = array('status' => 'error', 'message' => $message_count);			
		}

        $this->response($messages, 200);
	}



	/* POST types */
    function send_authd_post()
    {
		$this->form_validation->set_rules('receiver_id', 'Receiver', 'required');
		$this->form_validation->set_rules('module', 'Module', 'required');
		$this->form_validation->set_rules('type', 'Type', 'required');
		$this->form_validation->set_rules('message', 'Message', 'required');

		// Validation
		if ($this->form_validation->run() == true)
		{			
			$receiver = $this->social_auth->get_user($this->input->post('receiver_id'));
			
			if (!$this->input->post('site_id')) $site_id = config_item('site_id');
			else $site_id = $this->input->post('site_id');
			
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
	    			'geo_accuracy'	=> $this->input->post('geo_accuracy')    			
	        	);
	        	
				// Insert
			    $result = $this->messages_igniter->add_message($message_data);
	
				if ($result)
				{
		        	$message = array('status' => 'success', 'data' => $result, 'receivers' => $receiver);
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
	        $message = array('status' => 'error', 'message' => 'Hrmm '.validation_errors());
		}			

        $this->response($message, 200);
    }
      
    function destroy_delete()
    {		
		// Make sure user has access to do this func
		$access = $this->social_tools->has_access_to_modify('comment', $this->get('id'));
    	
    	if ($access)
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
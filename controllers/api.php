<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * Messages API : App : Social-Igniter
 *
 */
class Api extends Oauth_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->helper('messages');
		$this->load->library('messages_igniter');
	}
	
    /* Install App */
	function install_get()
	{
		// Load
		$this->load->library('installer');
		$this->load->config('install');        
		$this->load->dbforge();

		// Settings & Create Folders
		$settings = $this->installer->install_settings('messages', config_item('messages_settings'));

		// Create Messages Table
		$this->dbforge->add_key('message_id', TRUE);
		$this->dbforge->add_field(array(
			'message_id' => array(
				'type' 					=> 'INT',
				'constraint' 			=> 16,
				'unsigned' 				=> TRUE,
				'auto_increment'		=> TRUE
			),
			'site_id' => array(
				'type' 					=> 'INT',
				'constraint' 			=> '6',
				'null'					=> TRUE
			),
			'category_id' => array(
				'type' 					=> 'INT',
				'constraint' 			=> '6',
				'null'					=> TRUE
			),
			'reply_to_id' => array(
				'type' 					=> 'INT',
				'constraint'			=> 16,
				'null' 					=> TRUE
			),
			'receiver_id' => array(
				'type'					=> 'INT',
				'constraint'			=> 16,
				'null'					=> TRUE
			),
			'sender_id' => array(
				'type'					=> 'INT',
				'constraint'			=> 16,
				'null'					=> TRUE
			),
			'module' => array(
				'type'					=> 'VARCHAR',
				'constraint'			=> 32,
				'null'					=> TRUE
			),
			'type' => array(
				'type'					=> 'VARCHAR',
				'constraint'			=> 32,
				'null'					=> TRUE
			),
			'subject' => array(
				'type'					=> 'VARCHAR',
				'constraint'			=> 255,
				'null'					=> TRUE
			),
			'message' => array(
				'type'					=> 'TEXT',
				'null'					=> TRUE
			),
			'attachments' => array(
				'type'					=> 'TEXT',
				'null'					=> TRUE
			),
			'geo_lat' => array(
				'type'					=> 'VARCHAR',
				'constraint'			=> 16,
				'null'					=> TRUE
			),
			'geo_long' => array(
				'type'					=> 'VARCHAR',
				'constraint'			=> 16,
				'null'					=> TRUE
			),
			'viewed' => array(
				'type'					=> 'CHAR',
				'constraint'			=> 1,
				'null'					=> TRUE
			),			
			'status' => array(
				'type'					=> 'CHAR',
				'constraint'			=> 8,
				'null'					=> TRUE
			),
			'sent_at' => array(
				'type'					=> 'DATETIME',
				'default'				=> '9999-12-31 00:00:00'
			),
			'opened_at' => array(
				'type'					=> 'DATETIME',
				'default'				=> '9999-12-31 00:00:00'
			)			
		));

		$this->dbforge->create_table('messages');

		if ($settings == TRUE)
		{
            $message = array('status' => 'success', 'message' => 'Yay, the Messages App was installed');
        }
        else
        {
            $message = array('status' => 'error', 'message' => 'Dang Messages App could not be uninstalled');
        }		
		
		$this->response($message, 200);
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

    function mailgun_post()
    {
    	$folders 		= $this->social_tools->get_categories_view_multiple(array('module' => 'messages', 'type' => 'folder'));
    	$filters		= array(); // Query users_meta & use that to store user specific filters! Also need "global filters"
    	$category_id	= 0;
    	$recipient		= $this->input->post('recipient');
    	$check_flags	= messages_check_for_flags($recipient);
		$to_email		= str_replace($check_flags.'+', '', $recipient);

    	// 'To' User
    	if ($to_user = $this->social_auth->get_user('email', $to_email)) $receiver_id = $to_user->user_id;
    	else $receiver_id = config_item('superadmin_user_id');
    	

    	// 'From'
    	$from 			= $this->input->post('from');
    	$from_email		= parse_email_and_name($from, 'email');
    	$from_name		= parse_email_and_name($from, 'name');
		$filter_id		= messages_check_for_filters($filters, $from_email);


    	// 'From' User
    	if ($from_user = $this->social_auth->get_user('email', $from_email)) $sender_id = $from_user->user_id;
    	else $sender_id = 0;


   		// Process Category	
    	foreach ($folders as $folder)
    	{
    		// Check flag+ (maybe check for flag@ in the future OR better even both)
    		if ($folder->category_url == $check_flags)
    		{
    			$category_id = $folder->category_id;
    			break;
    		}
    		
    		// Do Global, then Personal Filters
    		if ($folder->category_id == $filter_id)
    		{
    		
    		}
    	}
/*
		echo 'to_email: '.$to_email.'<br>';		
    	echo 'category_id: '.$category_id.'<br>';
		echo 'receiver_id: '.$receiver_id.'<br>';
		echo 'sender_id: '.$sender_id.'<br>';
    	echo '<pre>';
    	print_r($to_user);
    	print_r($folders);
    	die();
*/
    	$message_data = array(
			'site_id'		=> config_item('site_id'),
    		'category_id'	=> $category_id,
    		'reply_to_id'	=> 0,
			'receiver_id'	=> $receiver_id,
			'receiver'		=> $to_email,	
			'sender_id'		=> $sender_id,
			'sender'		=> $this->input->post('sender'),
			'from'			=> $from_email,
			'module'		=> 'messages',
			'type'			=> 'email',
			'subject'		=> $this->input->post('subject'),
			'message'		=> $this->input->post('body-plain'),
			'body_html'		=> $this->input->post('body-html'),
			'stripped_html'	=> $this->input->post('stripped-html'),
			'geo_lat'		=> $this->input->post('geo_lat'),
			'geo_long'		=> $this->input->post('geo_long'),
			'attachments_count'	=> $this->input->post('attachment-count'),
			'attachments'	=> $this->input->post('attachment-x'),
			'viewed'		=> 'N',
			'status'		=> 'P',
			'sent_at'		=>  unix_to_mysql($this->input->post('timestamp'))
    	);
    	
		// Insert
	    $result = $this->messages_model->add_message($message_data);    	
    }
}
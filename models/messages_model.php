<?php

class Messages_model extends CI_Model
{    
    function __construct()
    {
        parent::__construct();
    }
    
    function get_message($message_id, $direction)
    {
    	if ($direction == 'sender')
    	{
    		$join = 'messages.sender_id';
    	}
    	else
    	{
    		$join = 'messages.reciver_id';
    	}
    	
 		$this->db->select('*');
 		$this->db->from('messages');    
 		$this->db->join('users', $join); 				
		$this->db->where('messages.message_id', $message_id);
 		$result = $this->db->get()->row();	
 		return $result;	      
    } 
    
    function get_inbox($receiver_id)
    {
 		$this->db->select('*');
 		$this->db->from('messages');    
 		$this->db->join('users', 'messages.sender_id = users.user_id'); 				
		$this->db->where('messages.receiver_id', $receiver_id);
		$this->db->where('messages.status', 'P');
 		$result = $this->db->get();	
 		return $result->result();	      	
    }
 
    function get_sent($sender_id)
    {
 		$this->db->select('*');
 		$this->db->from('messages');    
 		$this->db->join('users', 'messages.sender_id = users.user_id'); 				
		$this->db->where('messages.sender_id', $sender_id);
		$this->db->where('messages.status', 'P');
 		$result = $this->db->get();	
 		return $result->result();	      	
    }    

    function get_drafts($receiver_id)
    {
 		$this->db->select('*');
 		$this->db->from('messages');    
 		$this->db->join('users', 'messages.sender_id = users.user_id'); 				
		$this->db->where('messages.receiver_id', $receiver_id);
		$this->db->where('messages.status', 'S');
 		$result = $this->db->get();	
 		return $result->result();	      	
    }
    
    function get_inbox_new_count($receiver_id)
    {    	
 		$this->db->from('messages')->where(array('receiver_id' => $receiver_id, 'viewed' => 'N'));
 		return $this->db->count_all_results();
    }
    
    function add_message($message_data)
    {
 		$message_data['viewed']		= 'N';
		$message_data['status']		= 'S';
		$message_data['sent_at']	= unix_to_mysql(now());
		$message_data['opened_at']	= unix_to_mysql(now());
		
		$this->db->insert('messages', $message_data);
		$message_id = $this->db->insert_id();
		return $this->db->get_where('messages', array('message_id' => $message_id))->row();	
    }
    
}
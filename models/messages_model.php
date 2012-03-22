<?php
class Messages_model extends CI_Model
{    
    function __construct()
    {
        parent::__construct();
    }
    
    function get_message($message_id)
    {
 		$this->db->select('*');
 		$this->db->from('messages');    
 		$this->db->join('users', 'messages.sender_id = users.user_id', 'left'); 				
 		$this->db->join('sites', 'messages.site_id = sites.site_id');
		$this->db->where('messages.message_id', $message_id);
 		$result = $this->db->get()->row();	
 		return $result;	      
    } 

    function get_message_replies($reply_to_id)
    {
 		$this->db->select('*');
 		$this->db->from('messages');    
 		$this->db->join('users', 'messages.sender_id = users.user_id'); 				
 		$this->db->join('sites', 'messages.site_id = sites.site_id');
		$this->db->where('messages.reply_to_id', $reply_to_id);
		$this->db->order_by('messages.sent_at', 'asc');
 		$result = $this->db->get();	
 		return $result->result();    
    } 
    
    function get_inbox($receiver_id)
    {
 		$this->db->select('*');
 		$this->db->from('messages');    
 		$this->db->join('users', 'messages.sender_id = users.user_id', 'left'); 				
 		$this->db->join('sites', 'messages.site_id = sites.site_id');
		$this->db->where('messages.receiver_id', $receiver_id);
		$this->db->where('messages.status', 'P');
		$this->db->order_by('sent_at', 'desc'); 
 		$result = $this->db->get();	
 		return $result->result();	      	
    }
 
    function get_sent($sender_id)
    {
 		$this->db->select('*');
 		$this->db->from('messages');    
 		$this->db->join('users', 'messages.receiver_id = users.user_id');
 		$this->db->join('sites', 'messages.site_id = sites.site_id'); 		
		$this->db->where('messages.sender_id', $sender_id);
		$this->db->where('messages.status', 'P');
		$this->db->order_by('sent_at', 'desc');		
 		$result = $this->db->get();	
 		return $result->result();	      	
    }    

    function get_drafts($receiver_id)
    {
 		$this->db->select('*');
 		$this->db->from('messages');
 		$this->db->join('users', 'messages.receiver_id = users.user_id');
 		$this->db->join('sites', 'messages.site_id = sites.site_id'); 								
		$this->db->where('messages.sender_id', $receiver_id);
		$this->db->where('messages.status', 'S');
		$this->db->order_by('sent_at', 'desc');		
 		$result = $this->db->get();	
 		return $result->result();	      	
    }
    
    function get_inbox_new_count($receiver_id)
    {    	
 		$this->db->from('messages')->where(array('receiver_id' => $receiver_id, 'viewed' => 'N', 'status' => 'P'));
 		return $this->db->count_all_results();
    }
    
    function add_message($message_data)
    {
    	if (!isset($message_data['sent_at']))
    	{
			$message_data['sent_at'] = unix_to_mysql(now());
		}

		$message_data['opened_at'] = unix_to_mysql(now());

		$this->db->insert('messages', $message_data);
		return $this->db->insert_id();
    }
    
    function update_message($message_data)
    {
    	if ($message_data['viewed'] == 'Y')
    	{
	 		$message_data['opened_at'] = unix_to_mysql(now());
 		}
 		
		$this->db->where('message_id', $message_data['message_id']);
		$this->db->update('messages', $message_data);
		return $this->db->get_where('messages', array('message_id' => $message_data['message_id']))->row();		
    }
}
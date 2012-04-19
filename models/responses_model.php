<?php
class Responses_model extends CI_Model
{    
    function __construct()
    {
        parent::__construct();
    }
    
    function get_content($content_id)
    {
 		$this->db->select('*');
 		$this->db->from('content');  
  		$this->db->join('users', 'users.user_id = content.user_id');		  
 		$this->db->where('content_id', $content_id);
		$this->db->limit(1);    
 		$result = $this->db->get()->row();	
 		return $result;
    }   

    function get_content_view($parameter, $value, $status, $limit)
    {
 		if (in_array($parameter, array('site_id','parent_id','category_id', 'module','type','user_id', 'details')))
    	{
	 		$this->db->select('content.*, users.username, users.gravatar, users.name, users.image');
	 		$this->db->from('content');
 			$this->db->join('users', 'users.user_id = content.user_id');
	 		$this->db->where('content.'.$parameter, $value);
			$this->db->limit($limit); 		
	 		$this->db->order_by('content.created_at', 'desc');
	 		$result = $this->db->get();	
	 		return $result->result();	      
		}
		else
		{
			return FALSE;
		}
    }

    function get_content_multiple($parameter, $value_array)
    {
 		$this->db->select('content.*, users.username, users.gravatar, users.name, users.image');
 		$this->db->from('content');
  		$this->db->join('users', 'users.user_id = content.user_id');
 		$this->db->or_where_in($parameter, $value_array);	 	
	 	$this->db->where('content.status !=', 'D');
 		$result = $this->db->get();	
 		return $result->result();
    } 
    
    function add_content($content_data)
    {
 		$content_data = array(
			'created_at' 		=> unix_to_mysql(now()),
			'updated_at' 		=> unix_to_mysql(now())
		);
		
		$insert = $this->db->insert('content', $content_data);
		
		if ($content_id = $this->db->insert_id())
		{
			return $content_id;	
    	}
    	
    	return FALSE;
    }


    function update_content($content_data)
    {
 		$content_data['updated_at'] = unix_to_mysql(now());
 		
		$this->db->where('content_id', $content_data['content_id']);
		$this->db->update('content', $content_data);
		return $this->db->get_where('content', array('content_id' => $content_data['content_id']))->row();		
    }

    function delete_content($content_id)
    {
    	$this->db->where('content_id', $content_id);
    	$this->db->delete('content'); 
		return TRUE;
    }         
    
}
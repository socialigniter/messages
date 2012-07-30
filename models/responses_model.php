<?php
class Responses_model extends CI_Model
{    
    function __construct()
    {
        parent::__construct();
    }
    
    function get_response($response_id)
    {
 		$this->db->select('responses.*, users.username, users.gravatar, users.name, users.image');
 		$this->db->from('responses');  
  		$this->db->join('users', 'users.user_id = responses.user_id');		  
 		$this->db->where('response_id', $response_id);
		$this->db->limit(1);    
 		$result = $this->db->get()->row();	
 		return $result;
    }   

    function get_responses_user($user_id, $limit='all')
    {
 		$this->db->select('responses.*, users.username, users.gravatar, users.name, users.image');
 		$this->db->from('responses');
		$this->db->join('users', 'users.user_id = responses.user_id');
 		$this->db->where('responses.user_id', $user_id);
 		
 		if ($limit != 'all')
 		{
			$this->db->limit($limit); 		
 		}

 		$this->db->order_by('responses.created_at', 'desc');
 		$result = $this->db->get();	
 		return $result->result();	      
    }

    function get_responses_access($access_value, $limit='all')
    {
 		$this->db->select('*');
 		$this->db->from('responses');
 		$this->db->where('access_value', $access_value);

 		if ($limit != 'all')
 		{
			$this->db->limit($limit); 		
 		}

 		$this->db->order_by('responses.created_at', 'desc');
 		$result = $this->db->get();	
 		return $result->result();	      
    }

    function get_responses_multiples($response_id_array)
    {
    	if (count($response_id_array))
    	{
	 		$this->db->select('*');
	 		$this->db->from('responses');
	 		$this->db->or_where_in('response_id', $response_id_array);
	 		$result = $this->db->get();
	 		return $result->result();
 		}
 		
 		return FALSE;
    }
    
    function add_response($response_data)
    {
 		$response_data['created_at'] = unix_to_mysql(now());
 		$response_data['updated_at'] = unix_to_mysql(now());
		$insert = $this->db->insert('responses', $response_data);

		if ($response_id = $this->db->insert_id())
		{
			$response = $this->get_response($response_id);
			return $response;
    	}
    	
    	return FALSE;
    }


    function update_response($response_id, $response_data)
    {
 		$response_data['updated_at'] = unix_to_mysql(now());
 		
		$this->db->where('response_id', $response_id);
		$this->db->update('responses', $response_data);
		return $this->db->get_where('responses', array('response_id' => $response_id))->row();		
    }

    function delete_response($response_id)
    {
    	$this->db->where('response_id', $response_id);
    	$this->db->delete('responses'); 
		return TRUE;
    }         
    
}

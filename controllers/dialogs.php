<?php
class Dialogs extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->config('messages');
        $this->load->library('messages_igniter');
        $this->load->model('responses_model');
	}
	
	
	function response_manager()
	{		
		if ($this->uri->segment(4))
		{
			$response = $this->responses_model->get_response($this->uri->segment(4));

			$this->data['response']			= $response->response;
			$this->data['access'] 			= $response->access;
			$this->data['access_value']		= $response->access_value;
		}
		else
		{
			$this->data['response']			= '';
			$this->data['access'] 			= 'E';
			$this->data['access_value']		= '';
		}

		$this->data['modules'] = $this->social_igniter->scan_modules();

		$this->load->view('dialogs/response_manager', $this->data);
	}
	
	function response_list()
	{
		if ($this->uri->segment(4) == 'access_value')
		{
			$responses = $this->responses_model->get_responses_access($this->uri->segment(5));
		}
		elseif ($this->uri->segment(4) == 'user_id')
		{
			$responses = $this->responses_model->get_responses_user($this->uri->segment(5));			
		}
		else
		{
			$responses = $this->responses_model->get_responses();
		}
		
		$this->data['responses'] = $responses;
		
		$this->load->view('dialogs/response_list', $this->data);
	}

}
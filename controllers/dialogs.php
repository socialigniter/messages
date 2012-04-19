<?php
class Dialogs extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->config('messages');
        $this->load->library('messages_igniter');
	}
	
	
	function response_manager()
	{
		// Key Details
		$this->data['wysiwyg_name']			= 'response';
		$this->data['wysiwyg_id']			= 'wysiwyg_response';
		$this->data['wysiwyg_class']		= 'wysiwyg_norm_full';
		$this->data['wysiwyg_js']			= TRUE;
		$this->data['wysiwyg_width']		= 500;
		$this->data['wysiwyg_height']		= 300;
		$this->data['wysiwyg_resize']		= TRUE;
		$this->data['wysiwyg_media']		= FALSE;
		$this->data['wysiwyg_value']		= '';
		$this->data['wysiwyg_response']		= $this->load->view($this->config->item('dashboard_theme').'/partials/wysiwyg', $this->data, true);

		$this->data['access'] 			= 'FALSE';
		$this->data['access_value']		= '';
	
		$this->load->view('dialogs/response_manager', $this->data);	
	}


	
}
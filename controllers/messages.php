<?php
class Messages extends Public_Controller
{
    function __construct()
    {
        parent::__construct();
		
	}
	
	function index()
	{
		$this->render();	
	}
	
	/* Widgets */
	function widgets_sidebar()
	{
		
		$this->load->view('partials/widgets_sidebar', $this->data);
	
	}	

	
}

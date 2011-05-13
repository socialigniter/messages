<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:		Social Igniter : Messages Module : Config
* Author: 	Brennan Novak
* 		  	contact@social-igniter.com
*         	@brennannovak
*          
* Created by Brennan Novak
*
* Project:	http://social-igniter.com
* Source: 	http://github.com/social-igniter/core
*          
*/

// Messages Settings
$config['messages_path']			= 'messsages/';
$config['messages_display_style']	= array(
	'linear'	=> 'Linear',
	'threaded'	=> 'Threaded'
);

$config['messages_notifications_method'] = array(
	'none'			=> 'None',
	'email'			=> 'Email',
);
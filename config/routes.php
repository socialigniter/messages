<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:		Social Igniter : Messages Module : Routes
* Author: 	Brennan Novak
* 		  	contact@social-igniter.com
*
* Project:	http://social-igniter.com/pages/modules/messages
* Source: 	http://github.com/socialigniter/messages
*
* Routes for Messages Module.
*/

/* Api */
$route['messages/api/viewed/(:any)/(:any)']		= 'api/viewed/$1/$2';
$route['messages/api/send/(:any)/(:any)']		= 'api/send/$1/$2';

/* Home */
$route['messages/home/compose']		= 'home/compose';
$route['messages/home/inbox']		= 'home/mailbox';
$route['messages/home/drafts']		= 'home/mailbox';
$route['messages/home/sent']		= 'home/mailbox';
$route['messages/home/read/(:any)']	= 'home/read';
$route['messages/home/read']		= 'home/read';
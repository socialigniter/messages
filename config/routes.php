<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:		Social Igniter : Messages Module : Routes
* Author: 	Brennan Novak
* 		  	contact@social-igniter.com
*
* Project:	http://social-igniter.com/
* Source: 	http://github.com/socialigniter/core
*
* Standard installed routes for Cart Module. 
*
* All routes must route to the controller 'cart' the 1st URI segment can be something
* more custom like 'classes' or 'products'
*/

$route['home/messages/compose']			= 'home/compose';
$route['messages/home/inbox']			= 'home/mailbox';
$route['messages/home/drafts']			= 'home/mailbox';
$route['messages/home/sent']			= 'home/mailbox';
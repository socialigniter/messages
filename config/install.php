<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:			Social Igniter : Messages : Install
* Author: 		Brennan Novak
* 		  		contact@social-igniter.com
*         		@brennannovak
*          
* Created: 		Brennan Novak
*
* Project:		http://social-igniter.com/
* Source: 		http://github.com/socialigniter/messages
*
* Description: 	Install values for Messages App for Social Igniter 
*/
/* Settings */
$config['messages_settings']['enabled']				= 'TRUE';
$config['messages_settings']['display_style'] 		= 'linear';
$config['messages_settings']['date_style']			= 'DIGITS';
$config['messages_settings']['notifications_email']	= 'TRUE';

/* Database Table */
$config['database_messages_messages_table'] = array(
'message_id' => array(
	'type' 					=> 'INT',
	'constraint' 			=> 16,
	'unsigned' 				=> TRUE,
	'auto_increment'		=> TRUE
),
'site_id' => array(
	'type' 					=> 'INT',
	'constraint' 			=> '6',
	'null'					=> TRUE
),
'category_id' => array(
	'type' 					=> 'INT',
	'constraint' 			=> '6',
	'null'					=> TRUE
),
'reply_to_id' => array(
	'type' 					=> 'INT',
	'constraint'			=> 16,
	'null' 					=> TRUE
),
'receiver_id' => array(
	'type'					=> 'INT',
	'constraint'			=> 16,
	'null'					=> TRUE
),
'sender_id' => array(
	'type'					=> 'INT',
	'constraint'			=> 16,
	'null'					=> TRUE
),
'module' => array(
	'type'					=> 'VARCHAR',
	'constraint'			=> 32,
	'null'					=> TRUE
),
'type' => array(
	'type'					=> 'VARCHAR',
	'constraint'			=> 32,
	'null'					=> TRUE
),
'subject' => array(
	'type'					=> 'VARCHAR',
	'constraint'			=> 255,
	'null'					=> TRUE
),
'message' => array(
	'type'					=> 'TEXT',
	'null'					=> TRUE
),
'attachments' => array(
	'type'					=> 'TEXT',
	'null'					=> TRUE
),
'geo_lat' => array(
	'type'					=> 'VARCHAR',
	'constraint'			=> 16,
	'null'					=> TRUE
),
'geo_long' => array(
	'type'					=> 'VARCHAR',
	'constraint'			=> 16,
	'null'					=> TRUE
),
'viewed' => array(
	'type'					=> 'CHAR',
	'constraint'			=> 1,
	'null'					=> TRUE
),			
'status' => array(
	'type'					=> 'CHAR',
	'constraint'			=> 8,
	'null'					=> TRUE
),
'sent_at' => array(
	'type'					=> 'DATETIME',
	'default'				=> '9999-12-31 00:00:00'
),
'opened_at' => array(
	'type'					=> 'DATETIME',
	'default'				=> '9999-12-31 00:00:00'
));

$config['database_messages_responses_table'] = array(
'response_id' => array(
	'type' 					=> 'INT',
	'constraint' 			=> 11,
	'unsigned' 				=> TRUE,
	'auto_increment'		=> TRUE
),
'user_id' => array(
	'type' 					=> 'INT',
	'constraint' 			=> '11',
	'null'					=> TRUE
),
'response' => array(
	'type'					=> 'TEXT',
	'null'					=> TRUE
),
'access' => array(
	'type'					=> 'CHAR',
	'constraint'			=> 1,
	'null'					=> TRUE
),
'access_value' => array(
	'type'					=> 'VARCHAR',
	'constraint'			=> 32,
	'null'					=> TRUE
),
'created_at' => array(
	'type'					=> 'DATETIME',
	'default'				=> '9999-12-31 00:00:00'
),
'updated_at' => array(
	'type'					=> 'DATETIME',
	'default'				=> '9999-12-31 00:00:00'
));
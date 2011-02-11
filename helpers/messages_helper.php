<?php
/**
* Messages Helper
*
* @package		Social Igniter
* @subpackage	Messages Helper
* @link			http://social-igniter.com/pages/modules/messages
*
* Description: 	For messages module 
*/
function item_alerts_message($message, $mailbox)
{
	$message_alerts = NULL;

	if (($mailbox == 'drafts') && ($message->status == 'S'))
	{
		$message_alerts .= '<span class="item_send item_alert_send" id="item_alert_send_'.$message->message_id.'">Send</span>';
	}
	
	if (($mailbox == 'inbox')  && ($message->viewed == 'N')) 
	{
		$message_alerts .= '<span class="item_alert_new" id="item_alert_new_'.$message->message_id.'">New</span>';
	}
	elseif (($mailbox == 'sent')  && ($message->viewed == 'N'))
	{
		$message_alerts .= '<span class="item_alert_unread" id="item_alert_unread_'.$message->message_id.'">Unread</span>';	
	}

	return $message_alerts;
}

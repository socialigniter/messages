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


function parse_email($whole_string) 
{
    preg_match("/<?([^<]+?)@([^>]+?)>?$/", $whole_string, $matches);

    return $matches[1] . "@" . $matches[2];
}


function parse_email_and_name($string, $value=FALSE)
{
	// Has Bracket (thus name)
    if (strpos($string, '<'))
    {
    	$string = str_replace('"', '', $string);
        preg_match('!(.*?)\s?<\s*(.*?)\s*>!', $string, $matches);
        
        $result = array(
            'email'	=> $matches[2],
            'name'	=> $matches[1]
        );
    } 
    else
    {
        $result = array(
            'email' => $string,
            'name'	=> 'No Name'
        );
    }

	// Return Specific Value	    
    if ($value)
    {
    	$result = $result[$value];
    }    

    return $result;
}

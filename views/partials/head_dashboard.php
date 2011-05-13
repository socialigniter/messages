<style type="text/css">
#mailbox						{ margin: 0; }
#mailbox span.item_alerts		{ position: relative; top: 0; right: 10px; }
#mailbox ul.item_actions		{ margin: 0; position: relative; top: -15px; right: 10px !important; }

#mailbox li.item							{ width: 100%; margin: 0; padding: 0; }
#mailbox li.item:hover ul.item_actions		{ visibility: visible; }
#mailbox li.item:hover ul.item_actions span.actions { position: relative; top: -1px; left: 0; }
#mailbox li.item_new						{ width: 100%; margin: 0; padding: 0; background: #ececec; }
#mailbox li.item_new:hover ul.item_actions 	{ visibility: visible; }
#mailbox li.item_new:hover ul.item_actions span.actions { position: relative; top: -1px; left: 0; }

div.item_message_avatar					{ width: 48px; height: 48px; float: left; margin: 12px 0 5px 15px; }

/* Mailbox */
div.item_message_mailbox_col_1			{ width: 130px; float: left; margin: 12px 0 0 15px; }
div.item_message_mailbox_col_2			{ width: 270px; float: left; margin: 12px 0 0 15px; }
a.item_message_mailbox_username			{ width: 130px; display: block; margin: 0 0 8px 0; }
span.item_message_subject 				{ display: block; font-size: 14px; margin: 0 0 8px 0; }
span.item_message_alerts				{ height: 30px; float: right; display: block; margin: 12px 0 0 0; }
span.item_message_meta 					{ font-size: 12px; color: #999999; }

/* Read */
#message_read_subject					{ margin: 0 0 15px 15px; }
#message_read_buttons					{ margin: 25px 0 20px 15px; }
div.item_message_read_info				{ width: 550px; float: left; margin: 12px 0 0 15px; }

a.item_message_read_username 			{ display: block; float: left; margin: 0 8px 0 0; }
span.item_message_read_date 			{ font-size: 12px; color: #999999; display: block; float: left; margin: 8px 0 0 0; }
div.item_message_read_message			{ width: 475px; float: left; margin: 10px 0 10px 15px; word-wrap: break-word; line-height: 18px; }

#message_read_reply						{ width: 575px; margin: 15px 0 0 15px; }
#message_read_reply_avatar				{ width: 48px; height: 48px; float: left; }
#message_read_reply_form				{ width: 500px; float: left; margin: 0 0 0 15px; }
#message_read_reply_message				{ margin: 0 0 15px 0; }

/* Alerts */
span.item_alert_send 					{ width: 30px; display: block; padding: 3px 8px; cursor: pointer; color: #f2edda; background: #1c952d; font-size: 11px; line-height: 21px; font-weight: bold; float: right; margin: 0 0 0 10px; border-radius: 5px; -webkit-border-radius: 5px; -moz-border-radius: 5px;  text-shadow:1px 1px 1px #666666;  text-align: center; }
span.item_alert_unread 					{ width: 45px; display: block; padding: 3px 8px; cursor: pointer; color: #999999; background: #d3d3d3; font-size: 11px; line-height: 21px; font-weight: bold; float: right; margin: 0 0 0 10px; border-radius: 5px; -webkit-border-radius: 5px; -moz-border-radius: 5px;  text-shadow:1px 1px 1px #eeeeee;  text-align: center; }
</style>

<script type="text/javscript">
$(document).ready(function()
{	
	$('.item_send, .item_alert_send').live('click', function(eve)
	{
		eve.preventDefault();
		var item_attr_id		= $(this).attr('id');
		var item_attr_array		= item_attr_id.split('_');
		var item_id				= item_attr_array[3];
		var item_url			= base_url + 'api/messages/send/id/' + item_id;
				
		$(this).oauthAjax(
		{
			oauth 		: user_data,		
			url			: item_url,
			type		: 'GET',
			dataType	: 'json',
		  	success		: function(result)
		  	{		  	
				if (result.status == 'success')
				{	
					$('#item_alert_send_'+item_id).fadeOut('normal');
				}
				else
				{
					alert(result.message);
				}		  	
		  	}		
		});			
	});
});
</script>
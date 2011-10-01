<h2 id="message_read_subject"><?= $message_subject ?></h2>

<div id="message_read_buttons">
	<input type="button" value="Back"> <input type="button" value="Mark as Unread"> <input type="button" value="Delete">
</div>

<ol id="message_thread">
	<li><span class="item_separator"></span><div class="clear"></div></li>
	<?= $message_thread ?>
</ol>

<div id="message_read_reply">
	<div id="message_read_reply_avatar"><img src="<?= $logged_image ?>"></div>
	<form name="message_read_reply_form" id="message_read_reply_form" action="<?= base_url() ?>api/messages/reply" method="post" enctype="multipart/form-data">
		<textarea name="message" id="message_read_reply_message" class="textarea_large" rows="4"></textarea>
		<input type="hidden" name="geo_lat" id="geo_lat" value="" />
		<input type="hidden" name="geo_long" id="geo_long" value="" />
		<input type="submit" name="reply" value="Reply" />
	</form>
	<div class="clear"></div>
</div>

<script type="text/javascript">
$(document).ready(function()
{
	// Placeholders
	doPlaceholder('#message_read_reply_message', 'Your reply goes here...');
	
	// Write Article
	$("#message_read_reply_form").bind('submit', function(eve)
	{
		eve.preventDefault();
		var valid_message	= isFieldValid('#message_read_reply_message', 'Your reply goes here...', 'You need to type a reply');

		// Validation
		if (valid_message == true)
		{	
			var message_data = $('#message_read_reply_form').serializeArray();
			message_data.push({'name':'module','value':'messages'},{'name':'type','value':'message'});

			$.oauthAjax(
			{
				oauth 		: user_data,
				url			: base_url + 'api/messages/reply/id/<?= $message_thread_id ?>',
				type		: 'POST',
				dataType	: 'json',
				data		: message_data,
		  		success		: function(result)
		  		{		  				  			
					if (result.status == 'success')
					{
						$.get(base_url + 'home/messages/item_message', function(item_html)
						{						
							var item_message_html = $.template(item_html, 
							{
								'MESSAGE_ID'	: result.data.occurrence_id,
								'AVATAR'		: user_data.image,
								'USERLINK'		: result.data.username,
								'USER'			: result.data.name,
								'MESSAGE_DATE'	: 'just now',
								'MESSAGE'		: result.data.message
							});
	
							$('#message_thread').append(item_message_html);
							$('#message_read_reply_message').val('');
							$('#message_read_reply_message').doPlaceholder('#message_read_reply_message', 'Your reply goes here...');
						});
				 		
				 	}
				 	else
				 	{
				 		alert(result.message);
				 	}	
			 	}
			});
		}
		else
		{
			eve.preventDefault();
		}		
	});	
});
</script>
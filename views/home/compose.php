<form name="message_compose" id="message_compose" action="<?= base_url() ?>api/messages/send" method="post" enctype="multipart/form-data">

    <p><select name="receiver_id">
    <?php foreach ($users as $user): ?>
    	<option value="<?= $user->user_id ?>"><?= $user->name ?></option>
    <?php endforeach; ?>
    </select></p>

	<p><input type="text" name="subject" id="message_subject" class="input_large" value="" /></p>
		
	<p><textarea name="message" id="message_body" class="textarea_large" rows="4"></textarea></p>

	<input type="hidden" name="geo_lat" id="geo_lat" value="" />
	<input type="hidden" name="geo_long" id="geo_long" value="" />
	<input type="hidden" name="geo_accuracy" id="geo_accuracy" value="" />

	<input type="submit" name="send" value="Send" />

</form>

<div class="clear"></div>

<script type="text/javascript">
$(document).ready(function()
{
	// Placeholders
	doPlaceholder('#message_subject', 'Howdi');
	doPlaceholder('#message_body', 'Your message goes here...');
	
	// Write Article
	$("#message_compose").bind('submit', function(eve)
	{
		eve.preventDefault();
		var valid_subject	= isFieldValid('#message_subject', 'Howdi');
		var valid_message	= isFieldValid('#message_body', 'Your message goes here...');

		// Validation
		if (valid_subject == true && valid_message == true)
		{	
			var message_data = $('#message_compose').serializeArray();
			message_data.push({'name':'module','value':'messages'},{'name':'type','value':'personal'});

			console.log(message_data);

			$(this).oauthAjax(
			{
				oauth 		: user_data,
				url			: base_url + 'api/messages/send',
				type		: 'POST',
				dataType	: 'json',
				data		: message_data,
		  		success		: function(result)
		  		{		  				  			  			
					if (result.status == 'success')
					{
				 		$('#content_message').notify({message: result.message + ' <a href="' + base_url + 'blog/view/' + result.data.content_id + '">' + result.data.title + '</a>'});
				 	}
				 	else
				 	{
				 	}	
			 	}
			});
		}
		else
		{
			eve.preventDefault();
		}		
	});

	// Add Category
	$('[name=category_id]').change(function()
	{	
		if($(this).val() == 'add_category')
		{
			$('[name=category_id]').find('option:first').attr('selected','selected');
			$.uniform.update('[name=category_id]');

			$.categoryEditor(
			{
				url_api		: base_url + 'api/categories/view/module/users',
				url_pre		: base_url + 'blog/categories/',
				url_sub		: base_url + 'api/categories/create',		
				module		: 'messages',
				type		: 'group',
				title		: 'Add Channel',
				slug_value	: '',
				trigger		: $('.content [name=category_id]')
			});			
		}
	});		
});
</script>
<div id="content_wide_content">
	<h2>Responses</h2>
	<input type="button" id="create_response" data-action_type="Add" value="Add Response">	
	<div class="clear"></div>
	<ul id="responses">
		<?php foreach ($response_list as $item):?>
		<li class="item_data" id="item_<?= $item->response_id ?>" data-response_id="<?= $item->response_id ?>">
			<span class="item_data_text"><?= character_limiter(strip_tags($item->response), 50) ?></span>
			<ul class="item_data_actions">
				<li><a href="#" data-response_id="<?= $item->response_id?>" class="edit_item"><span class="actions action_edit"></span> Edit</a></li>
				<li><a href="#" data-response_id="<?= $item->response_id?>" class="delete_item"><span class="actions action_delete"></span> Delete</a></li>
			</ul>
		</li>
		<?php endforeach;?>
	</ul>
</div>
<!--
<div id="content_wide_toolbar">
	<h2>Actions</h2>
	<input type="button" id="create_action" data-action_type="Add" value="Add Action">	
	<span class="item_separator"></span>
	<div class="clear"></div>
	<p>These will be actions that get triggered by various message events, e.g. signatures, autoresponders<p>
</div>
-->
<div class="clear"></div>

<link rel="stylesheet" href="<?= base_url() ?>css/redactor.css">
<script src="<?= base_url() ?>js/redactor.min.js"></script>
<script src="<?= $modules_assets ?>messages.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
	$('#create_response').bind('click', function(e)
	{
		e.preventDefault();
		$.responseEditor(
		{
			url_html	: 'messages/dialogs/response_manager',
			url_submit	: 'api/messages/create_response',
			action		: 'create',
			title		: 'Create Response',
			after 		: function(result)
			{
				if (result.status == 'success')
				{
					$('#responses').prepend('<li class="item_data" id="item_' + result.response.response_id + '">\
						<span id="item_response_' + result.response.response_id + '">' + $(result.response.response).text() + '</span>\
						<ul class="item_actions">\
							<li><a href="#" data-response_id="' + result.response.response_id + '" class="edit_item"><span class="actions action_edit"></span> Edit</a></li>\
							<li><a href="#" data-response_id="' + result.response.response_id + '" class="delete_item"><span class="actions action_delete"></span> Delete</a></li>\
						</ul>\
					</li>');
				}
				else
				{				
					$('#content_message').notify({status:result.status,message:result.message});		
				}		
			}
		});
	});

	$('.edit_item').bind('click', function(e)
	{
		e.preventDefault();
		var response_id = $(this).data('response_id');
		$.responseEditor(
		{
			url_html	: 'messages/dialogs/response_manager/' + response_id,
			url_submit	: 'api/messages/modify_response/id/' + response_id,
			action		: 'edit',
			title		: 'Edit Response',
			after 		: function(result)
			{
				if (result.status == 'success')
				{
					var response = result.response.response.replace(/<(?:.|\n)*?>/gm, '');	
					$('#item_' + result.response.response_id + ' span.item_data_text').html(response);
				}
				else
				{
					$('#content_message').notify({status:result.status,message:result.message});					
				}
			}
		});
	});

	$('.delete_item').bind('click', function(e)
	{
		e.preventDefault();
		var response_id = $(this).data('response_id');

		 $.oauthAjax(
		 {
			oauth 		: user_data,
			url			: base_url + 'api/messages/destroy_response/id/' + response_id,
			type		: 'GET',
			dataType	: 'json',
		  	success	: function(result)
		  	{				
		  		console.log(result);
		  		if (result.status == 'success')
		  		{
			  		$('#item_' + response_id).fadeOut(function(){});
		  		}
		  		else
		  		{
					$('#content_message').notify({status:result.status,message:result.message});			  		
		  		}
		  	}		
		});
	});

	/* Actions */
	$('#create_action').bind('click', function(e)
	{
		e.preventDefault();
		alert('This will eventually create an action');	
	});

});
</script>

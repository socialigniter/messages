<div id="content_wide_content">

	<h2>Responses</h2>
	<input type="button" id="create_response" data-action_type="Add" value="Add Response">	
	<span class="item_separator"></span>
	<div class="clear"></div>

	<ul id="responses">
		<?php foreach ($response_list as $item):?>
		<li class="item_data" id="item_<?= $item->response_id ?>">
			<span class="occurrence_location"><?= $item->heading?> | <?= character_limiter(strip_tags($item->response), 55) ?></span>
			<ul class="item_actions">
				<li><a href="#" id="edit_item" data-response_id="<?= $item->response_id?>" class="edit_item"><span class="actions action_edit"></span> Edit</a></li>
				<li><a href="#" id="delete_item" data-response_id="<?= $item->response_id?>" class="delete_item"><span class="actions action_delete"></span> Delete</a></li>
			</ul>
		</li>
		<?php endforeach;?>
	</ul>

</div>
<div id="content_wide_toolbar">
	<h2>Actions</h2>

	<input type="button" id="create_action" data-action_type="Add" value="Add Action">	
	<span class="item_separator"></span>
	<div class="clear"></div>
	
	<p>These will be actions that get triggered by various message events, e.g. signatures, autoresponders<p>
</div>
<div class="clear"></div>

<link rel="stylesheet" href="<?= base_url() ?>css/wysiwyg.css" type="text/css" />
<script type="text/javascript" src="<?= base_url() ?>js/jquery.wysiwyg.js"></script>

<script type="text/javascript">
$(document).ready(function()
{
	$('#create_response').bind('click', function(e)
	{
		e.preventDefault();
	
		var action_type = $(this).attr('data-action_type');
	
		$.get(base_url + 'messages/dialogs/response_manager',function(partial_html)
		{
			$('<div />').html(partial_html).dialog(
			{
				width	: 525,
				modal	: true,
				close	: function(){$(this).remove()},
				title	: action_type + ' Response',
				create	: function()
				{
					$parent_dialog = $(this);

					// WYSIWYG					
					$('#wysiwyg_response').wysiwyg(
					{	
						autoGrow: true,
						resizeOptions: { maxWidth : 500, minWidth : 500, minHeight : 300 },
						controls:
						{
							separator				: { visible : false },
							strikeThrough			: { visible : true },
							underline 				: { visible : true },
							justifyLeft				: { visible : true },
							justifyCenter			: { visible : true },
							justifyRight			: { visible : true },
							justifyFull				: { visible : false },
							indent					: { visible : false },
							outdent					: { visible : false },
							subscript				: { visible : false },
							superscript				: { visible : false },
							undo					: { visible : false },
							redo					: { visible : false },
							insertImage				: { visible : false },
							insertOrderedList		: { visible : false },
							insertUnorderedList		: { visible : false },
							insertHorizontalRule	: { visible : false },
							cut						: { visible	: false },
							copy					: { visible : false },
							paste					: { visible : false },
							html					: { visible : true }	
						}
					});
				},
				buttons	:
				{
					'Save':function()
					{
						var response_data = $('#response_editor').serializeArray();
	
						 $.oauthAjax(
						 {
							oauth 		: user_data,
							url			: base_url + 'api/messages/create_response',
							type		: 'POST',
							dataType	: 'json',
							data		: response_data,
						  	success	: function(result)
						  	{				
						  		console.log(result);
						  		
								$('#responses').append('<li class="item_data" id="item_' + result.response.response_id + '">\
									<span class="occurrence_location">' + result.response.heading + ' | ' + $(result.response.response).text() + '</span>\
									<ul class="item_actions">\
										<li><a href="#" id="edit_item" data-response_id="' + result.response.response_id + '" class="edit_item"><span class="actions action_edit"></span> Edit</a></li>\
										<li><a href="#" id="delete_item" data-response_id="' + result.response.response_id + '" class="delete_item"><span class="actions action_delete"></span> Delete</a></li>\
									</ul>\
								</li>');
  	
								$('#content_message').notify({scroll:true,status:result.status,message:result.message});									
								$parent_dialog.dialog('close');
						  	}		
						});
					},
					'Cancel':function()
					{
						$parent_dialog.dialog('close');
					}
				}
	    	});
		});		
	});


	$('.edit_item').bind('click', function(e)
	{
		e.preventDefault();
		var response_data = $('#response_editor').serializeArray();
	
		 $.oauthAjax(
		 {
			oauth 		: user_data,
			url			: base_url + 'api/messages/update_resp',
			type		: 'POST',
			dataType	: 'json',
			data		: response_data,
		  	success	: function(result)
		  	{				
		  		console.log(result);
					  	
				$('#content_message').notify({scroll:true,status:result.status,message:result.message});									
				$parent_dialog.dialog('close');
		  	}		
		});	
	});


	$('#delete_item').bind('click', function(e)
	{
		e.preventDefault();
						var item_id = $(this).data('object_id');
	
						 $.oauthAjax(
						 {
							oauth 		: user_data,
							url			: base_url + 'api/messages/destroyresponse',
							type		: 'POST',
							dataType	: 'json',
							data		: item_id,
						  	success	: function(result)
						  	{				
						  		console.log(result);
						  				  	
								$('#content_message').notify({scroll:true,status:result.status,message:result.message});									
								$parent_dialog.dialog('close');
						  	}		
						});
		
	//	alert('Delete shizzle');
	
	});

	/* Actions */
	$('#create_action').bind('click', function(e)
	{
	
		e.preventDefault();
		
		alert('This will eventually create an action');
	
	});

});
</script>

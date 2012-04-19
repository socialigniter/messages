<div id="content_wide_content">
	<h2>Responses</h2>
	<input type="button" id="create_response" data-action_type="Add" value="Add Response">	
	<span class="item_separator"></span>
	<div class="clear"></div>
	

	<ul>
		<li>List of responses</li>
		<li>More response</li>
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
					// Do Custom Things
				},
				buttons	:
				{
					'Save':function()
					{
						var data = $('#form_name').serializeArray();
						data.push({'name':'module','value':'widgets'});
	
						 $.oauthAjax(
						 {
							oauth 	: user_data,
							url		: base_url + 'api/messages/create_reponse',
							type		: 'POST',
							dataType	: 'json',
							data		: data,
						  	success	: function(result)
						  	{							  	
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


	$('#create_action').bind('click', function(e)
	{
	
		e.preventDefault();
		
		alert('This will eventually create an action');
	
	});

});
</script>
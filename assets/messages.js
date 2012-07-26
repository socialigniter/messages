/* Messages Responses */
(function($)
{
	$.responseEditor = function(options)
	{
		var settings = {
			url_html		: '',
			url_submit		: '',
			action			: '',
			title			: '',
			after 			: function(){}
		};

		options = $.extend({}, settings, options);

		$.get(base_url + options.url_html,function(partial_html)
		{
			$('<div />').html(partial_html).dialog(
			{
				width	: 525,
				modal	: true,
				close	: function(){$(this).remove()},
				title	: options.title,
				create	: function()
				{
					$parent_dialog = $(this);

					// WYSIWYG
					var obj = $('#response_textarea').redactor(
					{
						buttons: [ 
							'formatting', '|', 
							'bold', 'italic', '|', 
							'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
							'image', 'link', '|', 
							'fontcolor', '|', 
							'html',
						],
						autoresize: true,
						removeStyles: true,
						focus: false						
					});
					
					// Access Module
					$('#access').change(function()
					{
						if ($(this).val() == 'M')
						{
							$('#access_value').fadeIn();		
						}
						else
						{
							$('#access_value').fadeOut();	
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
							url			: base_url + options.url_submit,
							type		: 'POST',
							dataType	: 'json',
							data		: response_data,
						  	success	: function(result)
						  	{				
						  		console.log(result);
						  		
						  		if (options.action == 'create')
						  		{
									$('#responses').append('<li class="item_data" id="item_' + result.response.response_id + '">\
										<span id="item_response_' + result.response.response_id + '">' + $(result.response.response).text() + '</span>\
										<ul class="item_actions">\
											<li><a href="#" data-response_id="' + result.response.response_id + '" class="edit_item"><span class="actions action_edit"></span> Edit</a></li>\
											<li><a href="#" data-response_id="' + result.response.response_id + '" class="delete_item"><span class="actions action_delete"></span> Delete</a></li>\
										</ul>\
									</li>');
								}
								else if (options.action == 'edit')
								{
									$('#item_response_' + result.response.response_id).html(result.response.response);
								}
  	
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
	};
})(jQuery);
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
			access			: '',
			access_value	: '',
			after 			: function(){}
		};

		options = $.extend({}, settings, options);

		$.get(base_url + options.url_html,function(partial_html)
		{
			$('<div />').html(partial_html).dialog(
			{
				width	: 450,
				modal	: true,
				close	: function(){$(this).remove()},
				title	: options.title,
				position: ['center', 150],
				create	: function()
				{
					$parent_dialog = $(this);

					// WYSIWYG
					var obj = $('#response_textarea').redactor(
					{
						buttons: [
							'formatting', '|', 'bold', 'italic', '|', 
							'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
							'image', 'link', '|', 'fontcolor', '|', 'html'
						],
						autoresize: true,
						removeStyles: true,
						focus: false
					});

					// Access
					if (options.access != '')
					{
						$parent_dialog.find('#response_access').hide();						
						$parent_dialog.find('#response_spacer').show();
					}
					else
					{					
						if ($('#access_value').val() != '')
						{
							$('#access_value').fadeIn();
						}
									
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
					}
				},
				buttons	:
				{
					'Save':function()
					{
						var response_data = $('#response_editor').serializeArray();
						
						// Access
						if (options.access != '')
						{
							response_data.push({'name':'access','value':options.access});
							response_data.push({'name':'access_value','value':options.access_value});
						}
	
						 $.oauthAjax(
						 {
							oauth 		: user_data,
							url			: base_url + options.url_submit,
							type		: 'POST',
							dataType	: 'json',
							data		: response_data,
						  	success	: function(result)
						  	{				
						  		options.after(result);  	
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
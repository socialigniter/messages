<link type="text/css" href="<?= $this_module_assets ?>messages.css" rel="stylesheet" media="screen" />
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
				
		$.oauthAjax(
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
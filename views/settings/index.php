<form name="settings_update" id="settings_update" method="post" action="<?= base_url() ?>api/settings/modify" enctype="multipart/form-data">

<div class="content_wrap_inner">

	<div class="content_inner_top_right">
		<h3>Module</h3>
		<p><?= form_dropdown('enabled', config_item('enable_disable'), $settings['messages']['enabled']) ?></p>
	</div>

	<h3>Display</h3>

	<p>Style
	<?= form_dropdown('display_style', config_item('messages_display_style'), $settings['messages']['display_style']) ?>
	</p>

	<p>Date
	<?= form_dropdown('date_style', config_item('date_style_types'), $settings['messages']['date_style']) ?>
	</p>
		
</div>

<span class="item_separator"></span>

<div class="content_wrap_inner">
	
	<h3>Notifications</h3>	

	<p>Email
	<?= form_dropdown('notifications_email', config_item('enable_disable'), $settings['messages']['notifications_email']) ?>	
	</p>

	<input type="hidden" name="module" value="messages">

	<p><input type="submit" name="save" value="Save" /></p>
	
</div>

</form>

<?= $shared_ajax ?>
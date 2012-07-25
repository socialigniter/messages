<form id="response_editor" name="response_editor" method="post">

	<h3>Title</h3>
	<p><input type="text" id="heading" name="heading" value="<?= $heading ?>" placeholder="Standard Out of Office Reply" class="input_large"></p>

	<h3>Response</h3>
	<div id="response_textarea"></div>

	<h3>Access</h3>
	<p><?= form_dropdown('access', config_item('access'), $access) ?></p>
	
	<p><input type="text" name="access_value" id="access_value" value="<?= $access_value ?>"></p>

	<h3>Status</h3>
	<p><?= form_dropdown('status', config_item('status'), $status) ?></p>

</form>

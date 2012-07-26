<form id="response_editor" name="response_editor" method="post">

	<textarea id="response_textarea" name="response" style="height: 100px; width: 400px;"><?= $response ?></textarea>

	<h3>Access</h3>
	<p>
		<?= form_dropdown('access', config_item('access'), $access, 'id="access"') ?> 
		<select name="access_value" id="access_value" class="hide">
			<?php foreach ($modules as $module): if (check_app_installed($module)): ?>
			<option value="<?= $module ?>" <?php if ($access_value == $module) echo 'selected="selected"'; ?>><?= display_nice_file_name($module) ?></option>
			<?php endif; endforeach; ?>
		</select>
	</p>

	<h3>Status</h3>
	<p><?= form_dropdown('status', config_item('status'), $status) ?></p>

</form>

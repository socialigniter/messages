<form id="response_editor" name="response_editor" method="post">

	<h3>Title</h3>
	<input type="text" id="heading" name="heading" value='' class="input_large">

	<h3>Response</h3>
	<?= $wysiwyg_response ?>

	<h3>Access</h3>
	<?= form_dropdown('access', config_item('yes_or_no'), $acess) ?>

	<input type="text" name="access_value" id="access_value" value="">

</form>
<style type="text/css">
#wysiwyg_response { width: 500px; height: 300px; }

</style>
<form id="response_editor" name="response_editor" method="post">

	<h3>Title</h3>
	<input type="text" id="heading" name="heading" value='' class="input_large">

	<h3>Response</h3>
	<?= $wysiwyg_response ?>

	<h3>Access</h3>
	<?= form_dropdown('access', config_item('access'), $access) ?>
	
	<p><input type="text" name="access_value" id="access_value" value="<?= $access_value ?>"></p>

</form>
<html>
<head><title><?= $message_subject ?></title></head>
<body>

	<h3><?= $message_subject ?></h3>

	<p><?= $message_message ?></p>

	<p>Read & reply <a href="<?= base_url().'home/messages/read/'.$message_id ?>">this message</a> on <a href="<?= base_url() ?>"><?= config_item('site_title') ?></a></p>

	<p>This message was sent by <a href="<?= $message_profile ?>"><?= $message_sender ?></a></p>

</body>
</html>
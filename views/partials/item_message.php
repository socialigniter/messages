<li class="item" id="item_<?= $message_id; ?>" rel="messages">

	<div class="item_message_avatar"><img src="<?= $message_avatar ?>"></div>

	<div class="item_message_read_info">
		<a class="item_message_username" href="<?= $message_userlink ?>"><?= $message_user ?></a> <span class="item_message_meta"><?= $message_sent_date ?></span>
	</div>

	<div class="item_message_read_message">
		<?= $message_message ?>		
	</div>

	<div class="clear"></div>
	<span class="item_separator"></span>
</li>
<li class="<?= $message_viewed ?>" id="item_<?= $message_id; ?>" rel="messages">

	<div class="item_message_avatar"><img src="<?= $message_avatar ?>"></div>
	
	<div class="item_message_mailbox_col_1">
		<a class="item_message_mailbox_username" href="<?= $message_userlink ?>"><?= $message_user ?></a>
		<span class="item_message_mailbox_data item_message_meta"><?= $message_sent_date ?></span>
	</div>
	
	<div class="item_message_mailbox_col_2">
		<span class="item_message_subject"><a href="<?= $message_read ?>"><?= $message_subject ?></a></span>
		<span class="item_message_meta"><?= $message_message ?></span>		
	</div>
	
	<span class="item_alerts" id="message_alerts_<?= $message_id ?>"><?= $message_alerts ?></span>
	
	<div class="clear"></div>

	<ul class="item_actions" rel="messages">						
		<?php if ($message_status == 'S'): ?>
		<li><a class="item_<?= $message_status ?>" href="<?= $message_status ?>" rel="messages" id="item_action_<?= $message_status.'_'.$message_id ?>"><span class="actions action_<?= $message_status ?>"></span> Send</a></li>
		<?php endif; ?>
		<li><a class="item_read" href="<?= $message_read ?>" id="item_action_read_<?= $message_id ?>"><span class="actions action_reply"></span> Read</a></li>
		<li><a class="item_delete" href="<?= $message_delete ?>" id="item_action_delete_<?= $message_id ?>"><span class="actions action_delete"></span> Delete</a></li>
	</ul>

	<div class="clear"></div>	
	<span class="item_separator"></span>		
</li>
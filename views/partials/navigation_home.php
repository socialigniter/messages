<h2 class="content_title"><img src="<?= $dashboard_assets ?>icons/messages_32.png"> Messages</h2>
<ul class="content_navigation">
	<?= navigation_list_btn('home/messages', 'Inbox') ?>
	<?= navigation_list_btn('home/messages/sent', 'Sent') ?>
	<?= navigation_list_btn('home/messages/drafts', 'Drafts') ?>
</ul>
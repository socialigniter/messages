<h2 class="content_title"><img src="<?= $modules_assets ?>messages_32.png"> Messages</h2>
<ul class="content_navigation">
	<?= navigation_list_btn('home/messages/inbox', 'Inbox', $this->uri->segment(4)) ?>
	<?= navigation_list_btn('home/messages/sent', 'Sent', $this->uri->segment(4)) ?>
	<?= navigation_list_btn('home/messages/drafts', 'Drafts', $this->uri->segment(4)) ?>
	<?= navigation_list_btn('home/messages/compose', 'Compose') ?>
</ul>
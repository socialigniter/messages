<h2 class="content_title"><img src="<?= $modules_assets ?>messages_32.png"> Messages</h2>

<p id="home_groups_nav"> <?= form_dropdown('category_id', $folders, $this->uri->segment(4), 'id="select_folder"') ?></p>

<ul class="content_navigation">
	<?= navigation_list_btn('home/messages/inbox', 'Inbox', $this->uri->segment(4)) ?>
	<?= navigation_list_btn('home/messages/sent', 'Sent', $this->uri->segment(4)) ?>
	<?= navigation_list_btn('home/messages/drafts', 'Drafts', $this->uri->segment(4)) ?>
	<?= navigation_list_btn('home/messages/compose', 'Compose') ?>
	<?= navigation_list_btn('home/messages/responses', 'Responses') ?>
</ul>

<script type="text/javascript">
$(document).ready(function()
{
	// Add Category
	$('#select_folder').categoryManager(
	{
		action		: 'create',		
		module		: 'messages',
		type		: 'folder',
		title		: 'Add Folder'
	});
});
</script>
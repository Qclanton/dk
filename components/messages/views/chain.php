<? 
	$this->content['head'] .= '<link rel="stylesheet" type="text/css" href="' . $this->site_url . 'components/messages/views/css/messages.css" />';
?>
<div id="message-wrapper">
	<table class="message-wrapper-table">
		<? foreach ($messages as $message) { ?>			
			<tr>
				<td class="message-list-col--1"><img src="<?= $message->image; ?>">
				<td class="message-list-col--2"><span class="message-author"><?= $message->author; ?></span><?= $message->text; ?></td>
				<td class="message-list-col--3"><span class="message-creation-date"> <?= $message->creation_date; ?></span></td>
			</tr>			
		<? } ?>
	</table>
</div>
<script>
 $(function() {
	$('#message-wrapper').scrollTop(100500);
});
</script>

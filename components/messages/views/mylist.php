<? 
	$this->content['head'] .= '<link rel="stylesheet" type="text/css" href="' . $this->site_url . 'components/messages/views/css/messages.css" />';
?>
<div id="messages-list-wrapper">
<? foreach ($messages as $message) { ?>
	<table class="messages-list">
		<tr>
			<td class="messages-list-col--1"><img src="<?= $message->image; ?>">
			<td class="messages-list-col--2"><span class="message-author"><?= $message->author; ?></span><span class="messages-creation-date"> <?= $message->creation_date; ?></span></td>
			<td class="messages-list-col--3"><a href="<?= $this->site_url; ?>index.php/?component=messages&action=showchain&author_id=<?= $message->author_id; ?>"><?= $message->shorttext; ?>...</a></td>
		</tr>
	</table>
<? } ?>
</div>


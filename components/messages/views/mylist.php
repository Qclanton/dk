<? if ($messages) { ?>
	<ul>
		<? foreach ($messages as $message) { ?>
			<li>
				Author: <b><?= $message->author; ?></b>
				Text: <a href="<?= $this->site_url; ?>index.php/?component=messages&action=showchain&author_id=<?= $message->author_id; ?>"><?= $message->shorttext; ?>...</a>
			</li>
		<? } ?>
	</ul>
<? } ?>

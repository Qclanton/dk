<div class="messages-wrapper">
	<? foreach ($messages as $message) { ?>
		<div class="message-wrapper">
			Автор: <?= $message->author; ?>
			Текст: <?= $message->text; ?>
		</div>
	<? } ?>
</div>

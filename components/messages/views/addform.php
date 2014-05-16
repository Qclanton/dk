<div class="addform-wrapper">
	<form action="<?= $this->site_url; ?>index.php?component=messages&action=add" method="post">
		<input type="hidden" name="recipient_id" value="<?= $recipient_id; ?>"></input>
		<input type="hidden" name="return_url" value="<?= $this->current_url; ?>"></input>
		
		<textarea cols="30" rows="5" name="text"></textarea>
		<button>Отправить</button>
	</form>
</div>

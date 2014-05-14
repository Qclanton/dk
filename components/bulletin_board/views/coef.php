<? 
	$this->content['head'] .= '<link rel="stylesheet" type="text/css" href= ' . $this->site_url . 'components/bulletin_board/views/css/bulletin_board.css" />';
	$text_submit = (($bulletin->id) ? 'Сохранить' : 'Создать'); 
?>
<div class="bulletin-coef-wrapper">
	<form action="<?= $this->site_url; ?>index.php?component=bulletin_board&action=set" method="post">
		<input type="hidden" name="id" value="<?= $bulletin->id; ?>"></input>
		<input type="hidden" name="creation_date" value="<?= $bulletin->creation_date; ?>"></input>
		<input type="hidden" name="return_url" value="<?= $this->site_url; ?>"></input>
		
		<? if ($bulletin->id) { ?>
			Дата создания: <?= $bulletin->creation_date; ?>
		<? } ?>
		Название: <input type="text" name="title" value="<?= $bulletin->title; ?>"></input>
		Описание: <textarea name="description"><?= $bulletin->description; ?></textarea>
		Цена: <input type="number" step="0.01" placeholder="0.00" name="cost" value="<?= $bulletin->cost; ?>"></input>
		
		<button><?= $text_submit; ?></button>
	</form>
</div>

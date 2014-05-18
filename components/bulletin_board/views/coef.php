<? 
	$this->content['head'] .= '<link rel="stylesheet" type="text/css" href="' . $this->site_url . 'components/bulletin_board/views/css/bulletin_board.css" />';
	$this->content['head'] .= '<script src="' . $this->site_url . 'components/bulletin_board/views/js/jquery.cookie.js"></script>';
	$text_submit = (($bulletin->id) ? 'Сохранить' : 'Создать'); 
?>
<div class="bulletin-coef-wrapper">
	<form id="bulletin-coef" action="<?= $this->site_url; ?>index.php?component=bulletin_board&action=set" method="post">
		<input type="hidden" name="id" value="<?= $bulletin->id; ?>"></input>
		<input type="hidden" name="creation_date" value="<?= $bulletin->creation_date; ?>"></input>
		<input type="hidden" name="return_url" value="<?= $this->site_url; ?>index.php/?component=bulletin_board&action=showmylist"></input>
		
		<? if ($bulletin->images) { ?>
			Previews of the attached images:
			<? foreach ($bulletin->images as $image) { ?>
				<img src="<?= $image->link; ?>"></img>
			<? } ?>
		<? } ?>

		<? if ($unattached_images) { ?>
			Previews of the unattached images:
			<? foreach ($unattached_images as $image) { ?>
				<input type="hidden" name="images[]" value="<?= $image->link; ?>"></input>
				<img src="<?= $image->link; ?>"></img>
			<? } ?>
		<? } ?>
		
		<? if ($bulletin->id) { ?>
			Дата создания: <?= $bulletin->creation_date; ?>
		<? } ?>
		<table class="bulletin-top-title">
			<tr>
				<td>
					<div class="bulletin-title"><h3>Название:</h3> <input class="bulletin-name" type="text" name="title" value="<?= $bulletin->title; ?>"></input></div>
				</td>
				<td>
					<div class="bulletin-title"><h3>Цена:</h3>  <input class="bulletin-price" type="number" step="0.01" placeholder="0.00" name="cost" value="<?= $bulletin->cost; ?>"></input></div>
				</td>
				<td>
					<div class="bulletin-title"><h3>Размер:</h3> <input class="bulletin-size" type="text" name="size" value="<?= $bulletin->size; ?>"></input></div>
				</td>
			</tr>
		</table>
		
		<div class="bulletin-description">
			<h3>Описание:</h3> 
			<textarea name="description"><?= $bulletin->description; ?></textarea>
		</div>		
	</form>

	<form id="uploader-form" enctype="multipart/form-data" action="index.php/?component=bulletin_board&action=upload" method="post">
		<input id="uploader-return_url" type="hidden" name="return_url" value="<?= $this->current_url; ?>"></input>
			
		<a style="cursor: pointer;" id="uploader-choose-button">Выбрать</a>
		<input id="uploader-choose-input" name="upl[]" type="file" accept="image/jpeg,image/png,image/gif" multiple></input>
	</form>
	
	<button id="bulletin-coef-submit-button"><?= $text_submit; ?></button>
</div>
<script>
	$(function() {
		$('#uploader-choose-button').on('click', function() {
			$('#uploader-choose-input').click();
		});
		
		// Upload images
		$('#uploader-form').on('change', function() {
			var return_url = $('#uploader-return_url').val();
			var coef_vars = $('#bulletin-coef').serialize();

			$.cookie('bulletin_stored_data--<?= ($bulletin->id ? $bulletin->id : 'new'); ?>', coef_vars, { expires: 1 });
			
			$(this).submit();
		});
		
		$('#bulletin-coef-submit-button').on('click', function() {
			$('#bulletin-coef').submit();
		});	
	});
</script>

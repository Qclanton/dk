<?
	$this->content['head'] .= '<script src="' . $this->site_url . 'components/partner_finder/views/js/jquery.chained.js"></script>';
	$this->content['head'] .= '<script src="' . $this->site_url . 'components/partner_finder/views/js/jquery.cookie.js"></script>';
?>
<div class="profile-wrapper">
	<form id="profile-coef" action="<?= $this->site_url; ?>index.php?component=partner_finder&action=set" method="post">
		<input type="hidden" name="id" value="<?= $profile->id; ?>">
		<input type="hidden" name="station_id" value="<?= $profile->station_id; ?>">
		<input type="hidden" name="creation_date" value="<?= $profile->creation_date; ?>">
		<input type="hidden" name="return_url" value="<?= $this->current_url; ?>">
		
		<table>
			<tr>
				<td>Пол:</td>
				<td>
					<select name="sex">
						<option value="MALE" <? if ($profile->sex == "MALE") { echo 'selected="selected"'; } ?>>Мужской</option>
						<option value="FEMALE" <? if ($profile->sex == "FEMALE") { echo 'selected="selected"'; } ?>>Женский</option>
					</select>
				</td>
			</tr>			
			<tr>
				<td>Дата рождения:</td>
				<td><input type="date" name="birth_date" value="<?= $profile->birth_date; ?>"></input></td>
			</tr>			
			<tr>
				<td>Рост (без обуви):</td>
				<td><input type="number" name="height" min="100" max="300" value="<?= $profile->height; ?>"></input></td>
			</tr>										
			<tr>
				<td>Рост (с обувью):</td>
				<td><input type="number" name="heightshoes" min="100" max="300" value="<?= $profile->heightshoes; ?>"></input></td>
			</tr>
			<tr>
				<td>Тип танца:</td>
				<td>
					<select name="dance_type_id">
						<? foreach ($dance_types as $dance_type) { ?>						
							<option value="<?= $dance_type->id; ?>" <? if ($dance_type->id == $profile->dance_type_id) { echo 'selected="selected"'; } ?>><?= $dance_type->title; ?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Класс танцора: </td>
				<td>
					<select name="dancer_class_id">
						<? foreach ($dancers_classes as $dancer_class) { ?>						
							<option 
									class="<?= $dancer_class->dance_type_id; ?>"
									value="<?= $dancer_class->id; ?>" 
									<? if ($dancer_class->id == $profile->dancer_class_id) { echo 'selected="selected"'; } ?>
								>
								<?= $dancer_class->title; ?>
							</option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Страна: </td>
				<td>
					<select name="country_id">
						<? foreach ($countries as $country) { ?>						
							<option value="<?= $country->id; ?>" <? if ($country->id == $profile->country_id) { echo 'selected="selected"'; } ?>><?= $country->title; ?></option>
						<? } ?>
					</select>
				</td>
			</td>
			<tr>
				<td>Регион: </td>
				<td>
					<select name="region_id">
						<? foreach ($regions as $region) { ?>						
							<option
									class="<?= $region->country_id; ?>"
									value="<?= $region->id; ?>" 
									<? if ($region->id == $profile->region_id) { echo 'selected="selected"'; } ?>
								>
								<?= $region->title; ?>
							</option>
						<? } ?>
					</select>
				</td>
			</tr>		
			<tr>
				<td>Город: </td>
				<td><div id="city_id-wrapper"></div></td>
			</tr>
			<tr>
				<td>Номер телефона: </td>
				<td><input type="text" name="phone" value="<?= $profile->phone; ?>"></input></td>
			</tr>
		</table>
		
		<? if ($unattached_image) { ?>
			Фотография (свежезагруженная):
			<input type="hidden" name="image" value="<?= $unattached_image->link; ?>"></input>
			<img src="<?= $unattached_image->link; ?>"></img>
		<? } elseif ($profile->image) { ?>
			Фотография:
			<input type="hidden" name="image" value="<?= $profile->image; ?>"></input>
			<img src="<?= $profile->image; ?>"></img>
		<? } ?>			
	</form>
	
	<form id="uploader-form" enctype="multipart/form-data" action="index.php/?component=partner_finder&action=upload" method="post">
		<input id="uploader-return_url" type="hidden" name="return_url" value="<?= $this->current_url; ?>"></input>
			
		<a style="cursor: pointer;" id="uploader-choose-button">Выбрать</a>
		<input id="uploader-choose-input" name="upl" type="file" accept="image/jpeg,image/png,image/gif"></input>
	</form>
	
	<button id="profile-coef-submit-button">Сохранить</button>
</div>

<script>
	$(function() {
		// Set cities depends of region			
		$('select[name=region_id]').on('change', function() {
			$('#city_id-wrapper').html();
			$('#city_id-wrapper').load('<?= $this->site_url ?>index.php/?load_template_fl=no&component=partner_finder&action=getcities&region_id=' + $(this).val());
		})
		
		// Set regions depends of country
		$('select[name=region_id]').chained('select[name=country_id]');
		
		// Set dancers classes depends of dance type
		$('select[name=dancer_class_id]').chained('select[name=dance_type_id]');
		

		
	
		// Upload images
		$('#uploader-form').on('change', function() {
			var return_url = $('#uploader-return_url').val();
			var coef_vars = $('#profile-coef').serialize();

			$.cookie('profile_stored_data', coef_vars, { expires: 1 });
			
			$(this).submit();
		});
		
		$('#profile-coef-submit-button').on('click', function() {
			$('#profile-coef').submit();
		});
		
		
		
		
		// Set default city
		$('#city_id-wrapper').load('<?= $this->site_url ?>index.php/?load_template_fl=no&component=partner_finder&action=getcities&region_id=<?= $profile->region_id; ?>', function() {
			$('#city_id-wrapper select[name=city_id] [value=<?= $profile->city_id; ?>]').attr('selected', 'selected');
		});
	});
</script>

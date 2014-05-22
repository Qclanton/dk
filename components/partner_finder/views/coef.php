<?
	$this->content['head'] .= '<link rel="stylesheet" type="text/css" href="' . $this->site_url . 'components/partner_finder/views/css/profile.css" />';
	$this->content['head'] .= '<link rel="stylesheet" type="text/css" href="' . $this->site_url . 'components/partner_finder/views/css/jquery-ui.css" />';
	
	$this->content['head'] .= '<script src="' . $this->site_url . 'components/partner_finder/views/js/jquery.chained.js"></script>';
	$this->content['head'] .= '<script src="' . $this->site_url . 'components/partner_finder/views/js/jquery.cookie.js"></script>';
	$this->content['head'] .= '<script src="' . $this->site_url . 'components/partner_finder/views/js/jquery-ui.min.js"></script>';
?>
<div class="profile-wrapper">
	<form id="profile-coef" action="<?= $this->site_url; ?>index.php?component=partner_finder&action=set" method="post">
		<input type="hidden" name="id" value="<?= $profile->id; ?>">
		<input type="hidden" name="station_id" value="<?= $profile->station_id; ?>">
		<input type="hidden" name="creation_date" value="<?= $profile->creation_date; ?>">
		<input type="hidden" name="return_url" value="<?= $this->current_url; ?>">
		<table class="personal-menu">
			<tr>
				<td>
<<<<<<< HEAD
					<a>Моя анкета</a>
				</td>
				<td>
					<a>Мои объявления</a>
				</td>
				<td>
					<a>Создать объявления</a>
				</td>
				<td>				
					<a>Мои сообщения</a>
				</td>
				<td>
					<a>Найти партнера</a>
=======
					<a href="<?= $this->site_url; ?>index.php/?component=partner_finder&action=profile&id=<?= $this->user_id; ?>">Моя анкета</a>
				</td>
				<td>
					<a href="<?= $this->site_url; ?>index.php/?component=bulletin_board&action=showmylist‏">Мои объявления</a>
				</td>
				<td>
					<a href="<?= $this->site_url; ?>index.php/?component=bulletin_board&action=create‏‏">Создать объявления</a>
				</td>
				<td>				
					<a href="<?= $this->site_url; ?>index.php/?component=messages&action=showmylist‏‏">Мои сообщения</a>
				</td>
				<td>
					<a href="<?= $this->site_url; ?>index.php/?component=partner_finder&action=search‏">Найти партнера</a>
>>>>>>> 8090a12edbe9a4c06ce870712e066c3846c63bd0
				</td>
			</tr>
		</table>
		<table class="profile-photo">
			<tr>
				<td class="profile-photo-title">
					<h3>Фотография профиля</h3>
				</td>
			</tr>
			<tr>
				<td class="profile-photo-content">
					<? if ($unattached_image) { ?>
						<input type="hidden" name="image" value="<?= $unattached_image->link; ?>"></input>
						<img src="<?= $unattached_image->link; ?>"></img>
					<? } elseif ($profile->image) { ?>
						<input type="hidden" name="image" value="<?= $profile->image; ?>"></input>
						<img src="<?= $profile->image; ?>"></img>
					<? } ?>	
				</td>
			</tr>
		</table>

		
		<table class="profile-table-edit">
			<tr>
				<td class="profile-table-edit-title">Пол:</td>
				<td>
					<select name="sex">
						<option value="MALE" <? if ($profile->sex == "MALE") { echo 'selected="selected"'; } ?>>Мужской</option>
						<option value="FEMALE" <? if ($profile->sex == "FEMALE") { echo 'selected="selected"'; } ?>>Женский</option>
					</select>
				</td>
			</tr>			
			<tr>
				<td class="profile-table-title">Дата рождения:</td>
				<td><input type="text" class="date" name="birth_date" value="<?= $profile->birth_date; ?>"></input></td>
			</tr>			
			<tr>
				<td class="profile-table-title">Рост (без обуви):</td>
				<td><input type="number" name="height" min="100" max="300" value="<?= $profile->height; ?>"></input></td>
			</tr>										
			<tr>
				<td class="profile-table-title">Рост (с обувью):</td>
				<td><input type="number" name="heightshoes" min="100" max="300" value="<?= $profile->heightshoes; ?>"></input></td>
			</tr>
			<tr>
				<td class="profile-table-title">Тип танца:</td>
				<td>
					<select name="dance_type_id">
						<? foreach ($dance_types as $dance_type) { ?>						
							<option value="<?= $dance_type->id; ?>" <? if ($dance_type->id == $profile->dance_type_id) { echo 'selected="selected"'; } ?>><?= $dance_type->title; ?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="profile-table-title">Класс танцора: </td>
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
				<td class="profile-table-title">Страна: </td>
				<td>
					<select name="country_id">
						<? foreach ($countries as $country) { ?>						
							<option value="<?= $country->id; ?>" <? if ($country->id == $profile->country_id) { echo 'selected="selected"'; } ?>><?= $country->title; ?></option>
						<? } ?>
					</select>
				</td>
			</td>
			<tr>
				<td class="profile-table-title">Регион: </td>
				<td>
					<div id="region_id-wrapper">
						<select name="region_id">
							<? foreach ($regions as $region) { ?>						
								<option
										value="<?= $region->id; ?>" 
										<? if ($region->id == $profile->region_id) { echo 'selected="selected"'; } ?>
									>
									<?= $region->title; ?>
								</option>
							<? } ?>
						</select>
					</div>
				</td>
			</tr>		
			<tr>
				<td class="profile-table-title">Город: </td>
				<td>
					<div id="city_id-wrapper">
						<select name="city_id">
							<? foreach ($cities as $city) { ?>						
								<option
										value="<?= $city->id; ?>" 
										<? if ($city->id == $profile->city_id) { echo 'selected="selected"'; } ?>
									>
									<?= $city->title; ?>
								</option>
							<? } ?>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<td class="profile-table-title">Номер телефона: </td>
				<td><input type="text" name="phone" value="<?= $profile->phone; ?>"></input></td>
			</tr>
		</table>		
	</form>
	
	<form id="uploader-form" enctype="multipart/form-data" action="index.php/?component=partner_finder&action=upload" method="post">
		<input id="uploader-return_url" type="hidden" name="return_url" value="<?= $this->current_url; ?>">Обновить фотографию профиля</input>
		<input id="uploader-choose-input" name="upl" type="file" accept="image/jpeg,image/png,image/gif"></input>
	</form>
	
	<button id="profile-coef-submit-button">Сохранить</button>
</div>

<script>
$(function() {
	function setCities(region_id) {
		var country_id = $('select[name=country_id]').val();
		
		$('#city_id-wrapper').html('<img class="loading" src="<?= $this->site_url ?>components/partner_finder/views/images/loading.gif"></img>');		
		if (country_id == '1') {			
			$('#city_id-wrapper').load('<?= $this->site_url ?>index.php/?load_template_fl=no&component=partner_finder&action=getcities&region_id=' + region_id);
		}
		else {			
			$('#city_id-wrapper').html('<input type="text" name="city"></input>');
		}
	}
	
	// Set regions depends of country
	$('select[name=country_id]').on('change', function() {
		$('#region_id-wrapper').html('<img class="loading" src="<?= $this->site_url ?>components/partner_finder/views/images/loading.gif"></img>');
		$('#region_id-wrapper').load('<?= $this->site_url ?>index.php/?load_template_fl=no&component=partner_finder&action=getregions&country_id=' + $(this).val(), function() { 
		
			// Set cities handler
			$('select[name=region_id]').on('change', function() { setCities($(this).val()); });	
			
			//Init cities handler
			$('select[name=region_id]').change();			
		});
	});		

	// Set cities depends of regions
	$('select[name=region_id]').on('change', function() { setCities($(this).val()); });
	
	
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
	

});
</script>
<script>
$(function() {
	$('.date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd'
	});
});
</script>

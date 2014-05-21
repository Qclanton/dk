<?
	// echo '<br><br><br>'; var_dump($search->confines);
	$this->content['head'] .= '<script src="' . $this->site_url . 'components/partner_finder/views/js/jquery.chained.js"></script>';
	$this->content['head'] .= '<link rel="stylesheet" type="text/css" href="' . $this->site_url . 'components/partner_finder/views/css/searchform.css" />';
?>
<div class="searchpartner_form-wrapper">
	<form id="searchpartner-form" action="<?= $this->site_url; ?>index.php?component=partner_finder&action=search" method="post">
		
		<input type="hidden" name="search[confines][order][0][column]" value="<?= $search->confines['order'][0]['column']; ?>"></input>
		<input type="hidden" name="search[confines][order][0][side]" value="<?= $search->confines['order'][0]['side']; ?>"></input>
		<h3 class="searchform-table-header">Поиск партнера:</h3>
		<table class="searchform-table">
			<tr>
				<td class="searchfotm-name-title">
					Имя: 
				</td>
				<td>
					<input type="text" name="search[name]" value="<?= $search->name; ?>"></input>
				</td>
			</tr>
			<tr>
				<td class="searchfotm-name-title">
					Пол:
				</td>
				<td>
					<select name="search[sex]">
					<option value="">Любой</option>
					<option value="MALE" <? if ($search->sex == "MALE") { echo 'selected="selected"'; } ?>>Мужской</option>
					<option value="FEMALE" <? if ($search->sex == "FEMALE") { echo 'selected="selected"'; } ?>>Женский</option>
				</select>
				</td>
			</tr>
			<tr>
				<td class="searchfotm-name-title">
					Тип танца:  
				</td>
				<td>
					<select name="search[dance_type_id]">
							<option value="">Любой</option>
						<? foreach ($dance_types as $dance_type) { ?>						
							<option value="<?= $dance_type->id; ?>" <? if ($dance_type->id == $search->dance_type_id) { echo 'selected="selected"'; } ?>><?= $dance_type->title; ?></option>
						<? } ?>
					</select>	
				</td>
			</tr>
			<tr>
				<td class="searchfotm-name-title">
					Класс танцора: 
				</td>
				<td>
					<select name="search[dancer_class_id]">
							<option class="" value="">Любой</option>
						<? foreach ($dancers_classes as $dancer_class) { ?>						
							<option class="<?= $dancer_class->dance_type_id; ?>"value="<?= $dancer_class->id; ?>" <? if ($dancer_class->id == $search->dancer_class_id) { echo 'selected="selected"'; } ?>><?= $dancer_class->title; ?></option>
						<? } ?>
					</select>	
				</td>
			</tr>
			<tr>
				<td class="searchfotm-name-title">
					Год рождения:
				</td>
				<td>
					От:		
					<select class="from-to" name="search[birth_year_after]">
							<option value="">---</option>
						<? for($i=date('Y')-70; $i<=date('Y')-4; $i++) { ?>						
							<option value="<?= $i; ?>" <? if ($i == $search->birth_year_after) { echo 'selected="selected"'; } ?>><?= $i; ?></option>
						<? } ?>
					</select>
					До: 		
					<select class="from-to" name="search[birth_year_before]">
							<option value="">---</option>
						<? for($i=date('Y')-66; $i<=date('Y')-4; $i++) { ?>						
							<option value="<?= $i; ?>" <? if ($i == $search->birth_year_before) { echo 'selected="selected"'; } ?>><?= $i; ?></option>
						<? } ?>
					</select>	
				</td>
			</tr>
		<!---</table>
		<table class="searchform-table-part2">--->
			<tr>
				<td class="searchfotm-name-title">
					Рост:
				</td>
				<td>
					От:		
					<select class="from-to" name="search[height_after]">
							<option value="">---</option>
						<? for($i=100; $i<=300; $i++) { ?>						
							<option value="<?= $i; ?>" <? if ($i == $search->height_after) { echo 'selected="selected"'; } ?>><?= $i; ?></option>
						<? } ?>
					</select>
					До: 		
					<select class="from-to" name="search[height_before]">
							<option value="">---</option>
						<? for($i=100; $i<=300; $i++) { ?>						
							<option value="<?= $i; ?>" <? if ($i == $search->height_before) { echo 'selected="selected"'; } ?>><?= $i; ?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="searchfotm-name-title">
					Страна:
				</td>
				<td>
					<select name="search[country_id]">
						<option class="" value="">Любая</option>
					<? foreach ($countries as $country) { ?>						
						<option value="<?= $country->id; ?>" <? if ($country->id == $search->country_id) { echo 'selected="selected"'; } ?>><?= $country->title; ?></option>
					<? } ?>
					</select>
				</td>
			</tr>	
			<tr>
				<td class="searchfotm-name-title">
					Регион:
				</td>
				<td>
					<select name="search[region_id]">
						<option class="" value="">Любой</option>
								
						<? if ($regions) { ?>
							<? foreach ($regions as $region) { ?>						
								<option
										value="<?= $region->id; ?>" 
										<? if ($region->id == $search->region_id) { echo 'selected="selected"'; } ?>
									>
									<?= $region->title; ?>
								</option>
							<? } ?>	
						<? } ?>					
					</select>
				</td>
			</tr>		
			<tr>
				<td class="searchfotm-name-title">
					Город:
				</td>
				<td>
					<select name="search[city_id]">
						<option class="" value="">Любой</option>
						<? if ($cities) { ?>
							<? foreach ($cities as $city) { ?>						
								<option
										value="<?= $city->id; ?>" 
										<? if ($city->id == $search->city_id) { echo 'selected="selected"'; } ?>
									>
									<?= $city->title; ?>
								</option>
							<? } ?>
						<? } ?>
					</select>
				</td>
			</tr>
		</table>
		
		<button class="search-button">Искать!</button>
	</form>
</div>
<script>
	function setCities(region_id) {
		var country_id = $('select[name="search[country_id]"]').val();
		
		$('#city_id-wrapper').html('<img class="loading" src="<?= $this->site_url ?>components/partner_finder/views/images/loading.gif"></img>');		
		if (country_id == '1') {			
			$('#city_id-wrapper').load('<?= $this->site_url ?>index.php/?load_template_fl=no&component=partner_finder&action=getcities&&listname=<?= urlencode('search[city_id]'); ?>&region_id=' + region_id);
		}
		else {
			$('#city_id-wrapper').html('<select name="search[city_id]"><option class="" value="">Любой</option></select>');
		}
	}
	
	// Set regions depends of country
	$('select[name="search[country_id]"]').on('change', function() {
		$('#region_id-wrapper').html('<img class="loading" src="<?= $this->site_url ?>components/partner_finder/views/images/loading.gif"></img>');
		$('#region_id-wrapper').load('<?= $this->site_url ?>index.php/?load_template_fl=no&component=partner_finder&action=getregions&listname=<?= urlencode('search[region_id]'); ?>&country_id=' + $(this).val(), function() { 
					
			// Set cities handler	
			$('select[name="search[region_id]"]').on('change', function() { setCities($(this).val()); });	
		
			//Init cities handler
			$('select[name="search[region_id]"]').change();			
		});
	});	
	
	
	$('select[name="search[dancer_class_id]"]').chained('select[name="search[dance_type_id]"]');
</script>

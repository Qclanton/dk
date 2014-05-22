<table class="personal-menu">
	<tr>
		<td>
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
		</td>
	</tr>
</table>

<? if (!$results) { ?> <div class="no-content">К сожалению, нет анкет, удовлетворяющих критериям поиска. Попробуйте их изменить :)</div>
<? } else { ?>
	
<div class="search-results-wrapper">
	<table class="search-results" cellspacing="0">
		<thead>
				<tr>
					<th class="order" column="name">Имя</th>
					<th class="order" column="sex">Пол</th>
					<th class="order" column="birth_date">Дата рождения</th>
					<th class="order" column="dance_type">Тип танца</th>
					<th class="order" column="dancer_class">Класс тацора</th>
					<th class="order" column="city">Город</th>
				</tr>
		</thead>
		
		<tbody>
			<? foreach ($results as $result) { ?>
				<tr class="search-result-tr">
					<td><a href="<?= $this->site_url ?>index.php/?component=partner_finder&action=profile&id=<?= $result->user_id; ?>"><?= $result->name; ?></td>
					<td><?= $result->sex; ?></td>
					<td><?= $result->birth_date; ?></td>
					<td><?= $result->dance_type; ?></td>
					<td><?= $result->dancer_class; ?></td>
					<td><?= $result->city; ?></td>
				</tr>
			<? } ?>	
		</tbody>	
	</table>
</div>
<script>
 $(function() {
	$('.order').on('click', function() {
		// Set column
		$('input[name="search[confines][order][0][column]"]').val($(this).attr('column'));
		
		// Change side
		var new_side = ('<?= $order->side; ?>' == 'ASC' ? 'DESC' : 'ASC');

		// Set side
		$('input[name="search[confines][order][0][side]"]').val(new_side);
		
		// Submit form
		$('#searchpartner-form').submit();
	});
});
</script>

<? } ?>

<? if (!$results) { ?> <div class="no-content">К сожалению, нет анкет, удовлетворяющих критериям поиска. Попробуйте их изменить :)</div>
<? } else { ?>
	
<table>
	<thead>
			<tr>
				<th class="order" column="name">Имя</th>
				<th class="order" column="sex">Пол</th>
				<th class="order" column="birth_date">Дата рождения</th>
				<th class="order" column="dance_type">Тип танца</th>
				<th class="order" column="dancer_class">Класс тацора</th>
				<th class="order" column="country">Страна</th>
				<th class="order" column="region">Регион</th>
				<th class="order" column="city">Город</th>
			</tr>
	</thead>
	
	<tbody>
		<? foreach ($results as $result) { ?>
			<tr>
				<td><?= $result->name; ?></td>
				<td><?= $result->sex; ?></td>
				<td><?= $result->birth_date; ?></td>
				<td><?= $result->dance_type; ?></td>
				<td><?= $result->dancer_class; ?></td>
				<td><?= $result->country; ?></td>
				<td><?= $result->region; ?></td>
				<td><?= $result->city; ?></td>
			</tr>
		<? } ?>	
	</tbody>	
</table>

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

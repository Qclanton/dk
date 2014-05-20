<div class="profile-wrapper">		
	<table>
		<tr>
			<td>Пол:</td>
			<td><p><?= $profile->sex; ?></p></td>
		</tr>			
		<tr>
			<td>Дата рождения:</td>
			<td><p><?= $profile->birth_date; ?></p></td>
		</tr>			
		<tr>
			<td>Рост (без обуви):</td>
			<td><p><?= $profile->height; ?></p></td>
		</tr>										
		<tr>
			<td>Рост (с обувью):</td>
			<td><p><?= $profile->heightshoes; ?></p></td>
		</tr>
		<tr>
			<td>Тип танца:</td>
			<td><p><?= $profile->dance_type; ?></p></td>
		</tr>
		<tr>
			<td>Класс танцора: </td>
			<td><p><?= $profile->dancer_class; ?></p></td>
		</tr>
		<tr>
			<td>Страна: </td>
			<td><p><?= $profile->country; ?></p></td>
		</td>
		<tr>
			<td>Регион: </td>
			<td><p><?= $profile->region; ?></p></td>
		</tr>		
		<tr>
			<td>Город: </td>
			<td><p><?= $profile->city; ?></p></td>
		</tr>
		<tr>
			<td>Номер телефона: </td>
			<td><p><?= $profile->phone; ?></p></td>
		</tr>
		<tr>
			<td>Фото: </td>
			<td><p><?= $profile->image; ?></p></td>
		</tr>
	</table>
</div>

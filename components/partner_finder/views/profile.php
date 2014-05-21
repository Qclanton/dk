<?
	$this->content['head'] .= '<link rel="stylesheet" type="text/css" href="' . $this->site_url . 'components/partner_finder/views/css/profile.css" />';
?>


<div class="profile-wrapper">
	<h3 class="profile-name">
		<?= $profile->name; ?>
	</h3>
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
	<table class="profile-photo">
		<tr>
			<td class="profile-photo-title">
				<h3>Фотография профиля</h3>
			</td>
		</tr>
		<tr>
			<td class="profile-photo-content">
				<img src="<?= $profile->image; ?>"></img>
			</td>
		</tr>

		<tr>
			<td class="send-message-button">
				<? if ($this->user_id != $profile->user_id) { ?>
					<a class="send-message" href="<?= $this->site_url; ?>index.php/?component=messages&action=showchain&author_id=<?= $profile->user_id; ?>">
						<span class="send-message-text">Отправить Сообщение </span>
						<img class="message-img" src="<?= $this->site_url ?>components/partner_finder/views/images/messages.png"></img> 
					</a>
				<? } else { ?>
					<a href="<?= $this->site_url; ?>index.php/?component=partner_finder&action=myprofile"> Редактировать профиль </a>
				<? } ?>
			</td>
		</tr>

	</table>
	<table class="profile-table">
		<tr>
			<td class="profile-table-title">Пол:</td>
			<td>
				<?= $profile->sex; ?>
			</td>
		</tr>			
		<tr>
			<td class="profile-table-title">Дата рождения:</td>
			<td>
				<?= $profile->birth_date; ?>
			</td>
		</tr>			
		<tr>
			<td class="profile-table-title">Рост (без обуви):</td>
			<td>
				<?= $profile->height; ?>
			</td>
		</tr>										
		<tr>
			<td class="profile-table-title">Рост (с обувью):</td>
			<td>
				<?= $profile->heightshoes; ?>
			</td>
		</tr>
		<tr>
			<td class="profile-table-title">Тип танца:</td>
			<td>
				<?= $profile->dance_type; ?>
			</td>
		</tr>
		<tr>
			<td class="profile-table-title">Класс танцора: </td>
			<td>
				<?= $profile->dancer_class; ?>
			</td>
		</tr>
		<tr>
			<td class="profile-table-title">Страна: </td>
			<td>
				<?= $profile->country; ?>
			</td>
		</td>
		<tr>
			<td class="profile-table-title">Регион: </td>
			<td>
				<?= $profile->region; ?>
			</td>
		</tr>		
		<tr>
			<td class="profile-table-title">Город: </td>
			<td>
				<?= $profile->city; ?>
			</td>
		</tr>
		<tr>
			<td class="profile-table-title">Номер телефона: </td>
			<td>
				<?= $profile->phone; ?>
			</td>
		</tr>
	</table>
	
</div>

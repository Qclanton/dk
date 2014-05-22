<?
	$this->content['head'] .= '<script> var max_text = ' . $pagination->rows . '; </script>';
	$this->content['head'] .= '<script src="' . $this->site_url . 'components/bulletin_board/views/js/pagination.js"></script>';
	$this->content['head'] .= '<link rel="stylesheet" type="text/css" href="' . $this->site_url . 'components/bulletin_board/views/css/bulletin-list.css" />';
?>

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
<? if (!$bulletins) { ?><div id="no-content">Объявлений нет</div><? } else { ?>
<div class="bulletin-list-wrapper">		
	<? $i=1; $j=1; foreach ($bulletins as $bulletin) { ?>
		<table class="page--<?= $j; ?><? if ($j == $pagination->page) { echo ' opened'; } ?> bulletin-list">
			<tr>
				<td class="bulletin-list-title">
					<a href="<?= $this->site_url ?>index.php/?component=bulletin_board&action=edit&id=<?= $bulletin->id ?>"><?= $bulletin->title ?></a>
				</td>
			</tr>
			<tr>			
				<td class="bulletin-list-img">
					<img src="<?= $bulletin->default_image ?>">
				</td>
			</tr>
			<tr>
				<td class="bulletin-list-price">
					<span><?= $bulletin->cost ?> руб</span>
				</td>
			</tr>
		</table>
		<? if ($i % $pagination->rows_per_page == 0) { $j++; } $i++; ?>
	<? } ?>
</div>	
<div class="pages-changer-wrapper">
	<table id="pages-changer-block">
		<tr>
			<? for ($j=1; $j<=$pagination->total_pages; $j++) { ?>
				<td id="page-change--<?= $j ?>" class="pages-changer"><?= $j ?></li>
			<? } ?>
		</tr>
	</table>
</div>
<? } ?>

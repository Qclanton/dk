<?
	$this->content['head'] .= '<script> var max_text = ' . $pagination->rows . '; </script>';
	$this->content['head'] .= '<script src="' . $this->site_url . 'components/bulletin_board/views/js/pagination.js"></script>';
?>
<? if (!$bulletins) { ?><div id="no-content">Объявлений нет</div><? } else { ?>
	
<table>
	<tr>
		<? $i=1; $j=1; foreach ($bulletins as $bulletin) { ?>
			<td class="page--<?= $j; ?><? if ($j == $pagination->page) { echo ' opened'; } ?>">
				<a href="<?= $this->site_url ?>index.php/?component=bulletin_board&action=edit&id=<?= $bulletin->id ?>"><?= $bulletin->title ?></a>
			</td>
			
			<? if ($i % $pagination->rows_per_page == 0) { $j++; } $i++; ?>
		<? } ?>
	</tr>
</table>

<table id="pages-changer-block">
	<tr>
		<? for ($j=1; $j<=$pagination->total_pages; $j++) { ?>
			<td id="page-change--<?= $j ?>" class="pages-changer"><?= $j ?></li>
		<? } ?>
	</tr>
</table>

<? } ?>

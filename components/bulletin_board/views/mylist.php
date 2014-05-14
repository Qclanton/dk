<ul>
	<? foreach ($bulletins as $bulletin) { ?>
		<li><a href="<?= $this->site_url ?>index.php/?component=bulletin_board&action=edit&id=<?= $bulletin->id ?>"><?= $bulletin->title ?></a></li>
	<? } ?>
</ul>

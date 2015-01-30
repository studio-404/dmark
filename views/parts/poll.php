<?php if($this->studio404_poll) : ?>
<div class="poll">
	<?=$this->studio404_poll?>
	<div class="all_poll">
		<a href="<?=$_GET["lang"]?>/polls"><?=strtoupper($allpolls)?></a>
	</div>
</div>
<?php endif; ?>
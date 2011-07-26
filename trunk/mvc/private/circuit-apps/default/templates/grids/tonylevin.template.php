<?php
$zones   = $this->get('zones');
$configs = $this->get('zone_configs');
?>
<!-- START GRID: TONY LEVIN -->
<div id="gaia_content" class="grid_tony_levin">

	<? if (isset($zones['hd'])) : ?>
		<!-- START HEADER -->
		<div id="hd">
			<? foreach ($zones['hd'] as $zone) : ?>
				<? $this->render($zone['name']); ?>
			<? endforeach; ?>
		</div>
		<!-- END HEADER -->
	<? endif; ?>

	<div id="bd">
		<div class="grid_rc_container_top">
			<div class="rc_top_left">&nbsp;</div>
			<div class="rc_top_right">&nbsp;</div>
		</div>

		<div class="yui-gb">
			<!-- START ZONE: 1A -->
			<div class="yui-u first">
				<? foreach ($zones['1a'] as $zone) : ?>
					<? $this->render($zone['name']); ?>
				<? endforeach; ?>
			</div>
			<!-- END ZONE: 1A -->

			<!-- START ZONE: 1B -->
			<div class="yui-u">
				<? foreach ($zones['1b'] as $zone) : ?>
					<? $this->render($zone['name']); ?>
				<? endforeach; ?>
			</div>
			<!-- END ZONE: 1B -->

			<!-- START ZONE: LREC -->
			<div class="yui-u last">
				<? $this->render('Default.Ads.WSkyscraper'); ?>
			</div>
			<!-- END ZONE: LREC -->
		</div>

		<div class="grid_rc_container_bottom">
			<div class="rc_bottom_left">&nbsp;</div>
			<div class="rc_bottom_right">&nbsp;</div>
		</div>
	</div>

	<? if (isset($zones['ft'])) : ?>
	<!-- START FOOTER -->
		<div id="ft">
			<? foreach ($zones['ft'] as $zone) : ?>
				<? $this->render($zone['name']); ?>
			<? endforeach; ?>
		</div>
	<!-- END FOOTER -->
	<? endif; ?>
</div>
<!-- END GRID: TONY LEVIN -->

<?
unset($zones, $configs);
?>
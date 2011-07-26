<?php
$zones   = $this->get('zones');
$configs = $this->get('zone_configs');
?>
<!-- START GRID: VIVALDI -->
<div id="gaia_content" class="grid_vivaldi">

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

		<!-- START ROW 1 -->
		<div id="yui-main">

			<div class="yui-gc">
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
			</div>


		</div>
		<!-- END ROW 1 -->

		<!-- START ROW 2 -->
		<div class="yui-gc">
			<!-- START ZONE: 2A -->
			<div class="yui-u first">
				<div class="yui-b first">
					<? foreach ($zones['2a'] as $zone) : ?>
						<? $this->render($zone['name']); ?>
					<? endforeach; ?>
				</div>
			<!-- END ZONE: 2A -->

			<!-- START ZONE: 2B -->
				<div class="yui-b">
					<? foreach ($zones['2b'] as $zone) : ?>
						<? $this->render($zone['name']); ?>
					<? endforeach; ?>
				</div>
			</div>
			<!-- END ZONE: 2B -->

			<!-- START ZONE: 2C -->
			<div class="yui-u ">
				<div class="lrec" id="vivaldi_lrec">
					<? $this->render('Default.Ads.LREC'); ?>				
				</div>
				<? foreach ($zones['2c'] as $zone) : ?>
					<? $this->render($zone['name']); ?>
				<? endforeach; ?>
			</div>
			<!-- END ZONE: 2C -->
			<div class="clear"></div>
		</div>
		<!-- END ROW 2 -->
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
<!-- END GRID:VIVALDI -->

<?php
unset($zones, $configs);
?>
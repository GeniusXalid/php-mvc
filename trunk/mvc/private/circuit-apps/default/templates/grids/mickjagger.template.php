<?php
$zones   = $this->get('zones');
$configs = $this->get('zone_configs');
?>
<!-- START GRID: MICK JAGGER -->
<div id="gaia_content" class="grid_mick_jagger">

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

				<div class="yui-u">
					<!-- START ZONE: 2A -->
					<div class="fixedContent_314x154">
						<? foreach ($zones['1b'] as $zone) : ?>
							<? $this->render($zone['name']); ?>
						<? endforeach; ?>
					</div>
					<!-- END ZONE: 2A -->

					<!-- START ZONE: 3A -->
					<div class="fixedContent_314x154">
						<? foreach ($zones['1c'] as $zone) : ?>
							<? $this->render($zone['name']); ?>
						<? endforeach; ?>
					</div>
					<!-- END ZONE: 3A -->
				</div>
			</div>

		</div>
		<!-- END ROW 1 -->

		<!-- START ROW 2 -->
		<div class="yui-gb">
			<!-- START ZONE: 2A -->
			<div class="yui-u first">
				<? foreach ($zones['2a'] as $zone) : ?>
					<? $this->render($zone['name']); ?>
				<? endforeach; ?>
			</div>
			<!-- END ZONE: 2A -->

			<!-- START ZONE: 2B -->
			<div class="yui-u">
				<? foreach ($zones['2b'] as $zone) : ?>
					<? $this->render($zone['name']); ?>
				<? endforeach; ?>
			</div>
			<!-- END ZONE: 2B -->

			<!-- START ZONE: 2C -->
			<div class="yui-u last">
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
<!-- END GRID: MICK JAGGER -->

<?php
unset($zones, $configs);
?>
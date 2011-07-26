<?php
$zones   = $this->get('zones');
$configs = $this->get('zone_configs');
?>
<!-- START GRID: GAIA MESSAGING -->
<div id="gaia_content" class="grid_gaia_messaging">

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
			<!-- START ZONE: 1A -->
			<div class="yui-g">
				<? foreach ($zones['1a'] as $zone) : ?>
					<? $this->render($zone['name']); ?>
				<? endforeach; ?>
			</div>
			<!-- END ZONE: 1A -->
			<div class="clear"></div>
		</div>
		<!-- END ROW 1 -->

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
<!-- END GRID: GAIA MESSAGING -->

<?php
unset($zones, $configs);
?>
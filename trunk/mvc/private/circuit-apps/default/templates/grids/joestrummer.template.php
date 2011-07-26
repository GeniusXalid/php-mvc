<?php
$zones   = $this->get('zones');
$configs = $this->get('zone_configs');
?>
<!-- START GRID: RAY DAVIES -->
<div id="gaia_content" class="grid_joe_strummer">

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
		</div>
		<!-- END ROW 1 -->
		<!-- START ROW 2 -->
		<!-- START ZONE 2A -->
		<div class="yui-g">
			<? foreach ($zones['2a'] as $zone) : ?>
            	<? $this->render($zone['name']); ?>
            <? endforeach; ?>
			<? if (!isset($zones['3a'])) : ?>
			<div class="clear"></div>
			<? endif; ?>
		</div>
		<!-- END ZONE 2A -->
		<!-- END ROW 2 -->
		<!-- START ROW 3 -->
		<!-- START ZONE 3A -->
		<? if (isset($zones['3a'])) : ?>
		<div class="yui-g">
			<? foreach ($zones['3a'] as $zone) : ?>
            	<? $this->render($zone['name']); ?>
            <? endforeach; ?>
			<div class="clear"></div>
		</div>
		<? endif; ?>
		<!-- END ZONE 3A -->
		<!-- END ROW 3 -->
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
<!-- END GRID: RAY DAVIES -->

<?php
unset($zones, $configs);
?>
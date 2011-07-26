<?php
$zones   = $this->get('zones');
$configs = $this->get('zone_configs');
?>
<!-- START GRID: RAY DAVIES -->
<div id="gaia_content" class="grid_ray_davies grid_ray_daviescn">

    <? if (isset($zones['hd'])) : ?>
        <!-- START HEADER -->
        <div id="hd">
            <? foreach ($zones['hd'] as $zone) : ?>
                <? $this->render($zone['name']); ?>
            <? endforeach; ?>
        </div>
        <!-- END HEADER -->
    <? endif; ?>
  <? if(isset($zones['td'])): ?>
      <!-- START TAB -->
        <div id="td">
            <? foreach ($zones['td'] as $zone) : ?>
                <? $this->render($zone['name']); ?>
            <? endforeach; ?>
        </div>
        <!-- END TAB -->
	<? endif; ?>
	<div id="bd">

		<div class="grid_rc_container_top">
			<div class="rc_top_left">&nbsp;</div>
			<div class="rc_top_right">&nbsp;</div>
			<div class="top-line"></div>
		</div>

		<!-- START ROW 1 -->
<div class="inner-bd">
<div class="inner-bd-hd">
	<div class="inner-bd-hd-left"></div>
	<div class="inner-bd-hd-right"></div>
</div>
		<div id="yui-main">
			<!-- START ZONE: 1A -->
			<div class="yui-g">
				<? foreach ($zones['1a'] as $zone) : ?>
					<? $this->render($zone['name']); ?>
				<? endforeach; ?>
			</div>
			<!-- END ZONE: 1A -->
			<div class="clear" role="clear"> </div>
		</div>
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
<!-- END GRID: RAY DAVIES -->

<?php
unset($zones, $configs);
?>
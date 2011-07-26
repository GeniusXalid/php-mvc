<?php
$zones   = $this->get('zones');
$configs = $this->get('zone_configs');
?>
<!-- START GRID: ZAKIR HUSSAIN -->

<div id="gaia_content" class="grid_zakir_hussain">

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
			<div id="yui-main">
				<!-- START ZONE 1A -->
				<div class="yui-g<? if (isset($configs['1a']['direction'])) { echo " ".$configs['1a']['direction']; } ?>">
					<? foreach ($zones['1a'] as $zone) : ?>
                        <? $this->render($zone['name']); ?>
                    <? endforeach; ?>
                    <? if (isset($configs['1a']['direction']) && $configs['1a']['direction'] == 'horizontal') : ?> 
                        <div class="clear"></div>
                    <? endif; ?>
				</div>
				<!-- END ZONE 1A -->
			</div>
			<div class="yui-gd">
				<!-- START ZONE 2A -->
				<div class="yui-u first<? if (isset($configs['2a']['direction'])) { echo " ".$configs['2a']['direction']; } ?>">
					<? foreach ($zones['2a'] as $zone) : ?>
                        <? $this->render($zone['name']); ?>
                    <? endforeach; ?>
                    <? if (isset($configs['2a']['direction']) && $configs['2a']['direction'] == 'horizontal') : ?> 
                        <div class="clear"></div>
                    <? endif; ?>
				</div>
				<!-- END ZONE 2A -->
				<!-- START ZONE 2B -->
				<div class="yui-u<? if (isset($configs['2b']['direction'])) { echo " ".$configs['2b']['direction']; } ?>">
					<? foreach ($zones['2b'] as $zone) : ?>
		                <? $this->render($zone['name']); ?>
		            <? endforeach; ?>
		            <? if (isset($configs['2b']['direction']) && $configs['2b']['direction'] == 'horizontal') : ?> 
		                <div class="clear"></div>
		            <? endif; ?>
				</div>
				<!-- END ZONE 2B -->
				<div class="clear"></div>
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

<!-- END GRID: ZAKIR HUSSAIN -->

<?php
unset($zones, $configs);
?> 
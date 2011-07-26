<?php
$zones   = $this->get('zones');
$configs = $this->get('zone_configs');
?>
<!-- START GRID: MIKE RUTHERFORD -->

<div id="gaia_content" class="grid_mike_rutherford">

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
            <? if (isset($zones['bd-hd'])) : ?>
                <!-- START BODY-HEADER -->
                <? foreach ($zones['bd-hd'] as $zone) : ?>
                    <? $this->render($zone['name']); ?>
                <? endforeach; ?>
                <!-- END BODY-HEADER -->
            <? endif; ?>
			<div id="yui-main">
				<!-- START ZONE 1A -->
				<div class="zone-1a yui-g<? if (isset($configs['1a']['direction'])) { echo " ".$configs['1a']['direction']; } ?>">
					<? foreach ($zones['1a'] as $zone) : ?>
                        <? $this->render($zone['name']); ?>
                    <? endforeach; ?>
                    <? if (isset($configs['1a']['direction']) && $configs['1a']['direction'] == 'horizontal') : ?> 
                        <div class="clear"></div>
                    <? endif; ?>
				</div>
				<!-- END ZONE 1A -->
			</div>
			<div class="yui-g">
				<!-- START ZONE 2A -->
				<div class="zone-2a yui-u first<? if (isset($configs['2a']['direction'])) { echo " ".$configs['2a']['direction']; } ?>">
					<? if (is_array($zones['2a'])) : ?>
						<? foreach ($zones['2a'] as $zone) : ?>
							<? $this->render($zone['name']); ?>
						<? endforeach; ?>
					<? endif; ?>
                    <? if (isset($configs['2a']['direction']) && $configs['2a']['direction'] == 'horizontal') : ?> 
                        <div class="clear"></div>
                    <? endif; ?>
				</div>
				<!-- END ZONE 2A -->
				<!-- START ZONE 2B -->
				<div class="zone-2b yui-u<? if (isset($configs['2b']['direction'])) { echo " ".$configs['2b']['direction']; } ?>">
					<? if (is_array($zones['2b'])) : ?>
						<? foreach ($zones['2b'] as $zone) : ?>
							<? $this->render($zone['name']); ?>
						<? endforeach; ?>
					<? endif; ?>
		            <? if (isset($configs['2b']['direction']) && $configs['2b']['direction'] == 'horizontal') : ?> 
		                <div class="clear"></div>
		            <? endif; ?>
				</div>
				<!-- END ZONE 2B -->
			</div>
			<!-- START ZONE 3A -->
			<div class="zone-3a yui-g<? if (isset($configs['3a']['direction'])) { echo " ".$configs['3a']['direction']; } ?>">
				<? if (is_array($zones['3a'])) : ?>
					<? foreach ($zones['3a'] as $zone) : ?>
						<? $this->render($zone['name']); ?>
					<? endforeach; ?>
				<? endif; ?>
                <? if (isset($configs['3a']['direction']) && $configs['3a']['direction'] == 'horizontal') : ?> 
                    <div class="clear"></div>
                <? endif; ?>
			</div>
			<!-- END ZONE 3A -->
			<div class="clear"></div>
            <? if (isset($zones['bd-ft'])) : ?>
                <!-- START BODY-FOOTER -->
                <? foreach ($zones['bd-ft'] as $zone) : ?>
                    <? $this->render($zone['name']); ?>
                <? endforeach; ?>
                <!-- END BODY-FOOTER -->
            <? endif; ?>
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

<!-- END GRID: MIKE RUTHERFORD, "All I need is a miracle..." -->

<?php
unset($zones, $configs);
?>
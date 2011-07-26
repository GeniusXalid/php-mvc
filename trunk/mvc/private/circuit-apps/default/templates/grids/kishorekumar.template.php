
<?php
$zones   = $this->get('zones');
$configs = $this->get('zone_configs');
?>
<!-- START GRID: KISHOREKUMAR -->

<div id="gaia_content" class="grid_kishorekumar">

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
			
			<div class="yui-gd">
				<!-- START ZONE 1A -->
				<div class="yui-u first<? if (isset($configs['1a']['direction'])) { echo " ".$configs['1a']['direction']; } ?>">
					<? foreach ($zones['1a'] as $zone) : ?>
                        <? $this->render($zone['name']); ?>
                    <? endforeach; ?>
                    <? if (isset($configs['1a']['direction']) && $configs['1a']['direction'] == 'horizontal') : ?> 
                        <div class="clear"></div>
                    <? endif; ?>
				</div>
				<!-- END ZONE 1A -->
				<!-- START ZONE 1B -->
				<div class="yui-u<? if (isset($configs['1b']['direction'])) { echo " ".$configs['1b']['direction']; } ?>">
					<? foreach ($zones['1b'] as $zone) : ?>
		                <? $this->render($zone['name']); ?>
		            <? endforeach; ?>
		            <? if (isset($configs['1b']['direction']) && $configs['1b']['direction'] == 'horizontal') : ?> 
		                <div class="clear"></div>
		            <? endif; ?>
				</div>
				<!-- END ZONE 1B -->
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

<!-- END GRID: KISHOREKUMAR -->

<?php
unset($zones, $configs);
?> 
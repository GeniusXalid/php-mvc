<?php
$zones   = $this->get('zones');
$configs = $this->get('zone_configs');
?>

  
<div id="gaia_content" class="grid_ehsaan">

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

		<div class="yui-g">
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
   			<div class="yui-u last">
				<? foreach ($zones['1b'] as $zone) : ?>
                    <? $this->render($zone['name']); ?>
                <? endforeach; ?>
                <? if (isset($configs['1b']['direction']) && $configs['1b']['direction'] == 'horizontal') : ?> 
                    <div class="clear"></div>
                <? endif; ?>
	    	</div>
	    	<!-- END ZONE 1B -->
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

<!-- END GRID: EHSAAN -->

<?php
unset($zones, $configs);
?>
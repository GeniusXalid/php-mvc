<?php
	//$zones = $this->get('zones');
	//$configs = $this->get('zone_configs');
	$blocks = array('hd', '1a', '2a', '1b', '2b', 'ft');
	$config_elements = array('direction');
	$zones = $this->getZones( $blocks );
	$configs = $this->getZoneConfigs($blocks , $config_elements );
?>
<!-- START GRID: RD BURMAN -->
<div id="gaia_content" class="grid_rdburman">

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
	<div class="inner-bd">
<div class="inner-bd-hd">
	<div class="inner-bd-hd-left"></div>
	<div class="inner-bd-hd-right"></div>
</div>	
		<div id="yui-main">
			<div class="yui-g">
				<!-- START ZONE 1A -->
				<div class="yui-g first<? if (isset($configs['1a']['direction'])) { echo " ".$configs['1a']['direction']; } ?>">
					<div class="yui-u first">
						<? foreach ($zones['1a'] as $zone) : ?>
			                <? $this->render($zone['name']); ?>
			            <? endforeach; ?>
			            <? if (isset($configs['1a']['direction']) && $configs['1a']['direction'] == 'horizontal') : ?> 
			                <div class="clear"></div>
			            <? endif; ?>
					</div>
					<div class="yui-u lastrd">
						<!-- START ZONE: 2A -->
						<div class="fixedContent_277x200 first">
							<? if ( $zones['2a'] ) :?>
								<? foreach ($zones['2a'] as $zone) : ?>
									<? $this->render($zone['name']); ?>
								<? endforeach; 
							endif;?>
						</div>
						<!-- END ZONE: 2A -->
						<!-- START ZONE: 2b -->
						<div class="fixedContent_277x200 second">
							<? if ( $zones['2b'] ) :?>
								<? foreach ($zones['2b'] as $zone) : ?>
									<? $this->render($zone['name']); ?>
								<? endforeach;
							endif; ?>							
						</div>
						<!-- END ZONE: 2b -->
					</div>
				</div>
				<!-- END ZONE 1A -->
				<div class="yui-gb">
					<!-- START ZONE 1B -->
					<div class="yui-u first">
						<? foreach ($zones['1b'] as $zone) : ?>
			                <? $this->render($zone['name']); ?>
			            <? endforeach; ?>
			            <? if (isset($configs['1b']['direction']) && $configs['1b']['direction'] == 'horizontal') : ?> 
			                <div class="clear"></div>
			            <? endif; ?>
					</div>
					<!-- END ZONE 1B -->
					<div class="yui-u">
		               <!-- START ZONE: LREC1 -->
					   <? $this->render('Default.Ads.LREC'); ?>
					   <!-- END ZONE: LREC1 -->			
					</div>
				</div>
			</div>
		</div>
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
<!-- END GRID: RD BURMAN -->
<?php
	unset($zones, $configs);
?>
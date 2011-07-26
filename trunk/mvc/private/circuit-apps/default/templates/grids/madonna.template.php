<?php
/*******************************************************
New Home Page Grid
@ author ANia <akurek@gaiaonline.com>
********************************************************/
	$blocks = array('hd', '1a', '1b', '2a', '2b', '3a', '3b', '3c', '3d', 'ft');
	$config_elements = array('direction');
	$zones = $this->getZones( $blocks );
	$configs = $this->getZoneConfigs($blocks , $config_elements );
?>
<!-- START GRID: MADONNA -->
<div id="gaia_content" class="grid_madonna">
	<div id="madonna_container">
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
				<div class="yui-g">
						<? foreach ($zones['1a'] as $zone) : ?>
							<? $this->render($zone['name']); ?>
						<? endforeach; ?>
						<? if (isset($configs['1a']['direction']) && $configs['1b']['direction'] == 'horizontal') : ?> 
							<div class="clear"></div>
						<? endif; ?>	
				</div>	
				<!-- END ZONE 1A-->
			</div>
			<div class="yui-gd">
				<!-- START ZONE 2A -->
				<div class="yui-u first">
					<? foreach ($zones['2a'] as $zone) : ?>
						<? $this->render($zone['name']); ?>
					<? endforeach; ?>
					<? if (isset($configs['2a']['direction']) && $configs['2a']['direction'] == 'horizontal') : ?> 
						<div class="clear"></div>
					<? endif; ?>
				</div>	
				<!-- END ZONE 2A -->	
				<!-- START ZONE 2B -->	
				<div class="yui-u">					
					<? foreach ($zones['2b'] as $zone) : ?>
						<? $this->render($zone['name']); ?>
					<? endforeach; ?>
					<? if (isset($configs['2b']['direction']) && $configs['2b']['direction'] == 'horizontal') : ?> 
						<div class="clear"></div>
					<? endif; ?>
				</div>	
				<!-- END ZONE 2B -->	
			</div>
				<div class="yui-gb">
					<!-- START ZONE 3A -->
					<div class="yui-u first">
						<? foreach ($zones['3a'] as $zone) : ?>
							<? $this->render($zone['name']); ?>
						<? endforeach; ?>
						<? if (isset($configs['3a']['direction']) && $configs['3a']['direction'] == 'horizontal') : ?> 
							<div class="clear"></div>
						<? endif; ?>
					</div>	
					<!-- END ZONE 3A -->	
					<!-- START ZONE 3B -->	
					<div class="yui-u">					
						<? foreach ($zones['3b'] as $zone) : ?>
							<? $this->render($zone['name']); ?>
						<? endforeach; ?>
						<? if (isset($configs['3b']['direction']) && $configs['3b']['direction'] == 'horizontal') : ?> 
							<div class="clear"></div>
						<? endif; ?>
					</div>	
					<!-- END ZONE 3B -->	
					<!-- START ZONE 3C -->	
					<div class="yui-u last">					
						<? foreach ($zones['3c'] as $zone) : ?>
							<? $this->render($zone['name']); ?>
						<? endforeach; ?>
						<? if (isset($configs['3c']['direction']) && $configs['3c']['direction'] == 'horizontal') : ?> 
							<div class="clear"></div>
						<? endif; ?>
					</div>	
					<!-- END ZONE 3C -->				
				</div>	
			<div class="grid_rc_container_bottom">
				<div class="rc_bottom_left">&nbsp;</div>
				<div class="rc_bottom_right">&nbsp;</div>
			</div>
		</div>
		<div id="bd-div"></div>
		<div id="bd-sub">
			<div class="grid_rc_container_top">			
				<div class="rc_top_right">&nbsp;</div>
			</div>
			<div class="yui-b">
				<!-- START ZONE 1B -->
				<div class="yui-u first">
						<? foreach ($zones['1b'] as $zone) : ?>
							<? $this->render($zone['name']); ?>
						<? endforeach; ?>
						<? if (isset($configs['1b']['direction']) && $configs['1b']['direction'] == 'horizontal') : ?> 
							<div class="clear"></div>
						<? endif; ?>
				</div>	
				<!-- END ZONE 1B-->
				<div class="yui-u">
					<div id="advertisement"><p>ADVERTISEMENT</p></div>
					<!-- START ZONE: MREC -->
					<? $this->render('Default.Ads.MREC'); ?>
					<!-- END ZONE: MREC -->			
				</div>
				<!-- START ZONE 3D -->
				<div class="yui-u last">
					<? foreach ($zones['3d'] as $zone) : ?>
						<? $this->render($zone['name']); ?>
					<? endforeach; ?>
					<? if (isset($configs['3d']['direction']) && $configs['3d']['direction'] == 'horizontal') : ?> 
						<div class="clear"></div>
					<? endif; ?>
				</div>	
				<!-- END ZONE 3D -->	
			</div>
			<div class="grid_rc_container_bottom">			
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
</div>
<!-- END GRID: MADONNA -->
<?php
	unset($zones, $configs);
?>
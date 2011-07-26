<?php
$zones   = $this->get('zones');
$configs = $this->get('zone_configs');
?>

  
<div id="gaia_content" class="grid_shankar">

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
				
				<div class="yui-gb vertical">
					<!-- START ZONE 1B -->
					<div class="yui-u first vertical">
						<? foreach ($zones['1b'] as $zone) : ?>
			                <? $this->render($zone['name']); ?>
			            <? endforeach; ?>
			            <? if (isset($configs['1b']['direction']) && $configs['1b']['direction'] == 'horizontal') : ?> 
			                <div class="clear"></div>
			            <? endif; ?>
					</div>
					<!-- END ZONE 1B -->
					<!-- START ZONE: LREC1 -->
					<div class="yui-u vertical">
		               
					   <? $this->render('Default.Ads.LREC'); ?>
					   			
					</div>
					<!-- END ZONE: LREC1 -->

					<!-- START ZONE: LREC2 -->
					<div class="yui-u last vertical">
						<?php
						$r = $this->getRequest(); 
							if( $r->isEmpty('featured') ) : 
						?>	               
					  		<? $this->render('Default.Ads.LREC2'); ?>
						<?php
							endif;
						?>					   			
					</div>
					<!-- END ZONE: LREC2 -->

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

<!-- END GRID: SHANKAR -->

<?php
unset($zones, $configs);
?>

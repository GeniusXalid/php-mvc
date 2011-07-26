<?php
$zones   = $this->get('zones');
$configs = $this->get('zone_configs');
?>

<style type="text/css" media="screen">
/* <![CDATA[ */
/* This css is placed inline due to redesign of UXP 1.0. Grid resets from 1.0 will reside in templates until they are phased out. */

/*** Use the #gaia_content ID to reset width */
#gaia_content{
	width:950px !important;
	padding:10px 9px 10px 9px;
	border-left:1px solid #000;
	border-right:1px solid #000;
	margin:0;
	background:#e4ded8 url(http://<?= GRAPHICS_SERVER ?>/images/gaia_global/body/shared/rs_bodygradient.gif) repeat-x top left;
}

#gaia_content #hd{
	margin:0 0 10px 0;
}
#gaia_content #ft{
	margin:10px 0 0 0;
}
#gaia_content #bd,
#gaia_content #ft{
	clear:both;
}
#gaia_content #bd{
	width:950px;
	background-color:transparent;
}
/***** Haydn */
#gaia_content.grid_haydn #bd .yui-b .yui-gb .yui-u{
	width:310px;
	margin:0 0 0 10px;
}
#gaia_content.grid_haydn #bd .yui-b .yui-gb .first{
	margin:0;
	width:200px;
}
#gaia_content.grid_haydn #bd #yui-main .yui-b .yui-gb .first{
	width:630px;
}
#gaia_content.grid_haydn #bd .yui-b .yui-gb .second{
	width:420px;
}
#gaia_content.grid_haydn #bd #yui-main{
	margin:0 0 10px 0;
	height:250px;
	overflow:hidden;
}
#gaia_content.grid_haydn #bd .middle{
	margin:0 0 10px 0;
	height:260px;
	overflow:hidden;
}

/*** Set Ad default sizes */
#gaia_content .lrec{
	width:300px;
	height:250px;
	margin:0 0 10px 0;
	text-align: left;
	padding: 5px;
	overflow: hidden;
	position: relative;
	background:url(/images/gaia_global/body/shared/rs_lrecborder_310x260.gif) no-repeat;
}

#gaia_content .lrec iframe {
	z-index: 50;
	position: absolute;
	left: 5px;
	top: 5px;
	overflow: hidden;
	width: 300px;
	height: 250px;
	border: 0;
	border-collapse: collapse;
}

/* ]]> */
</style>

<!-- START GRID: HAYDN -->
<div id="gaia_content" class="grid_haydn">
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
		<!-- START ROW: 1 -->
		<div id="yui-main">
			<div class="yui-b">
				<div class="yui-gb">
	
					<!-- START ZONE: 1A -->      
					<div class="yui-u first <? if (isset($configs['1a']['direction'])) { echo $configs['1a']['direction']; } ?>">
						<? foreach ($zones['1a'] as $zone) : ?>
							<? $this->render($zone['name']); ?>
						<? endforeach; ?>
						<? if (isset($configs['1a']['direction']) && $configs['1a']['direction'] == 'horizontal') : ?> 
							<div class="clear"></div>
						<? endif; ?>
					</div>
					<!-- END ZONE: 1A -->					
	
					<div class="yui-u">
	
						<!-- START ZONE: 1B -->   
						<div class="fixedContent_310x120">
							<? foreach ($zones['1b'] as $zone) : ?>
								<? $this->render($zone['name']); ?>
							<? endforeach; ?>
						</div>
						<!-- END ZONE: 1B -->
	
						<!-- START ZONE: 1C -->   
						<div class="fixedContent_310x120">
							<? foreach ($zones['1c'] as $zone) : ?>
								<? $this->render($zone['name']); ?>
							<? endforeach; ?>
						</div>
						<!-- END ZONE: 1C -->
	
					</div>
	
				</div>
			</div>
		</div>
		<!-- END ROW: 1 -->
	
	
		<!-- START ROW: 2 -->
		<div class="yui-b middle">
			<div class="yui-gb">
						
				<!-- START ZONE: 2A -->      
				<div class="yui-u first <? if (isset($configs['2a']['direction'])) { echo $configs['2a']['direction']; } ?>">
					<? foreach ($zones['2a'] as $zone) : ?>
						<? $this->render($zone['name']); ?>
					<? endforeach; ?>
					<? if (isset($configs['2a']['direction']) && $configs['2a']['direction'] == 'horizontal') : ?> 
						<div class="clear"></div>
					<? endif; ?>                
				</div>
				<!-- END ZONE: 2A -->
	
				<!-- START ZONE: 2B -->   
				<div class="yui-u second <? if (isset($configs['2b']['direction'])) { echo $configs['2b']['direction']; } ?>">
					<? foreach ($zones['2b'] as $zone) : ?>
						<? $this->render($zone['name']); ?>
					<? endforeach; ?>
					<? if (isset($configs['2b']['direction']) && $configs['2b']['direction'] == 'horizontal') : ?> 
						<div class="clear"></div>
					<? endif; ?>                                                
				</div>
				<!-- END ZONE: 2B -->
	
				<!-- START ZONE: LREC -->
				<div class="yui-u">
					<? $this->render('Default.Ads.LREC'); ?>
				</div>
				<!-- END ZONE: LREC -->
			</div>
		</div>
		<!-- END ROW: 2 -->
	
		<!-- START ROW: 3 -->
		<div class="yui-b">
			<div class="yui-gb">
	
				<!-- START ZONE: 3A -->      
				<div class="yui-u first <? if (isset($configs['3a']['direction'])) { echo $configs['3a']['direction']; } ?>">
					<? foreach ($zones['3a'] as $zone) : ?>
						<? $this->render($zone['name']); ?>
					<? endforeach; ?>
					<? if (isset($configs['3a']['direction']) && $configs['3a']['direction'] == 'horizontal') : ?> 
						<div class="clear"></div>
					<? endif; ?>                                                
				</div>
				<!-- END ZONE: 3A -->
	
				<!-- START ZONE: 3B -->   
				<div class="yui-u second <? if (isset($configs['3b']['direction'])) { echo $configs['3b']['direction']; } ?>">
					<? foreach ($zones['3b'] as $zone) : ?>
						<? $this->render($zone['name']); ?>
					<? endforeach; ?>
					<? if (isset($configs['3b']['direction']) && $configs['3b']['direction'] == 'horizontal') : ?> 
						<div class="clear"></div>
					<? endif; ?>                                                                
				</div>
				<!-- END ZONE: 3B -->
	
				<!-- START ZONE: 3C -->   
				<div class="yui-u <? if (isset($configs['3c']['direction'])) { echo $configs['3c']['direction']; } ?>">
					<? foreach ($zones['3c'] as $zone) : ?>
						<? $this->render($zone['name']); ?>
					<? endforeach; ?>
					<? if (isset($configs['3c']['direction']) && $configs['3c']['direction'] == 'horizontal') : ?> 
						<div class="clear"></div>
					<? endif; ?>                                                                
				</div>
				<!-- END ZONE: 3C -->
				<div class="clear"></div>
			</div>
		</div>
		<!-- END ROW: 3 -->
	</div> <!-- end bd -->
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
<!-- END GRID: HAYDN -->
            
<?php
unset($zones, $configs);
?>

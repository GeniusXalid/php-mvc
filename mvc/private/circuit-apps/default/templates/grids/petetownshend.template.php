<?php
$zones   = $this->get('zones');
$configs = $this->get('zone_configs');
?>

<style type="text/css" media="screen">
/* <![CDATA[ */
/* This css is placed inline due to redesign of UXP 1.0. Grid resets from 1.0 will reside in templates until they are phased out. */

/*** Use the #gaia_content ID to reset width */
#gaia_content{
	width:960px !important;
	padding:10px 9px 10px 9px;
	border-left:1px solid #000;
	border-right:1px solid #000;
	margin:0 auto;
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

/***** Pete Townshend */
#gaia_content.grid_pete_townshend #bd #yui-main .yui-b .yui-g .yui-u{
	width:470px;
}

/* ]]> */
</style>

<!-- START GRID: PETE TOWNSHEND -->
<div id="gaia_content" class="grid_pete_townshend">	
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
		<div id="yui-main">
			<div class="yui-b">
				<div class="yui-g"> 
	
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
	
					<!-- START ZONE: 1B -->
					<div class="yui-u <? if (isset($configs['1b']['direction'])) { echo $configs['1b']['direction']; } ?>">
						<? foreach ($zones['1b'] as $zone) : ?>
							<? $this->render($zone['name']); ?>
						<? endforeach; ?>
						<? if (isset($configs['1b']['direction']) && $configs['1b']['direction'] == 'horizontal') : ?> 
							<div class="clear"></div>
						<? endif; ?>                                    
					</div>
					<!-- END ZONE: 1B -->
	
				</div> 
			</div>
			<div class="clear"></div>
		</div>
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

<!-- END GRID: PETE TOWNSHEND -->
<?php
unset($zones, $configs);
?>
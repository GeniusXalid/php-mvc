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

/***** Roger Waters */
#gaia_content.grid_roger_waters .yui-b {
    width:280px;
}
#gaia_content.grid_roger_waters #yui-main .yui-b{
    margin-right:290px;
    width:auto;
}


/* ]]> */
</style>

<!-- START GRID: ROGER WATERS -->
<div id="gaia_content" class="grid_roger_waters yui-t5">
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
	
			<!-- START ZONE: 1A -->
			<div class="yui-b">
				<? foreach ($zones['1a'] as $zone) : ?>
					<? $this->render($zone['name']); ?>
				<? endforeach; ?>
				<? if (isset($configs['1a']['direction']) && $configs['1a']['direction'] == 'horizontal') : ?> 
					<div class="clear"></div>
				<? endif; ?>                                                                
			</div>
			<!-- END ZONE: 1A -->
		</div>
	
		<!-- START ZONE: 1B -->
		<div class="yui-b">
			<? foreach ($zones['1b'] as $zone) : ?>
				<? $this->render($zone['name']); ?>
			<? endforeach; ?>
			<? if (isset($configs['1b']['direction']) && $configs['1b']['direction'] == 'horizontal') : ?> 
				<div class="clear"></div>
			<? endif; ?>                                                                        
		</div>
		<!-- END ZONE: 1B -->
		
		<div class="clear"></div>
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
<!-- END GRID: ROGER WATERS -->

<?php
unset($zones, $configs);
?>
    

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

/***** Albert Collins (SRV layout with zone 1A flexi width) */
#gaia_content.grid_albert_collins {
    width: 100% !important;
    padding: 10px 0;
    border: 0;
}
#gaia_content.grid_albert_collins #bd .yui-b {
    width:130px;
    padding-right: 10px;
}
#gaia_content.grid_albert_collins #bd #yui-main .yui-b{
    width: auto;
    padding-left: 10px;
    margin-right:140px;
}

#gaia_content .skyscraper iframe {
	z-index: 50;
	position: absolute;
	left: 5px;
	top: 5px;
	overflow: hidden;
	width: 120px;
	height: 600px;
	border: 0px;
	border-collapse: collapse;
}

#gaia_content .wskyscraper {
	position: relative;
	width:170px;
	height:610px;
	text-align:center;
	background:url(/images/gaia_global/body/shared/rs_skyscraper_border_170x610.gif) center no-repeat;     
}

#gaia_content .wskyscraper iframe {
	z-index: 50;
	position: absolute;
	left: 5px;
	top: 5px;
	overflow: hidden;
	width: 160px;
	height: 600px;
	border: 0px;
	border-collapse: collapse;
}


/* ]]> */
</style>

<!-- START GRID: ALBERT COLLINS -->
<div id="gaia_content" class="grid_albert_collins yui-t4">

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
	
			<!-- START ZONE: 1A -->
			<div class="yui-b <? if (isset($configs['1a']['direction'])) { echo $configs['1a']['direction']; } ?>">
				<? foreach ($zones['1a'] as $zone) : ?>
					<? $this->render($zone['name']); ?>
				<? endforeach; ?>
				<? if (isset($configs['1a']['direction']) && $configs['1a']['direction'] == 'horizontal') : ?> 
					<div class="clear"></div>
				<? endif; ?>
			</div>
			<!-- END ZONE: 1A -->
	
		</div>
		<div class="yui-b">
			<? $this->render('Default.Ads.Skyscraper'); ?>        
		</div>
		<!-- END ROW: 1 -->
		
		<div class="clear"></div>
		
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
<!-- END GRID: ALBERT COLLINS -->
            
<?php
unset($zones, $configs);
?>


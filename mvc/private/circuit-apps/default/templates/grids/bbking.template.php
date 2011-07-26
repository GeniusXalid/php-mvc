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

/***** B.B. King */
#gaia_content.grid_bb_king #bd .yui-b {
	width:130px;
}
#gaia_content.grid_bb_king #bd #yui-main .yui-b{
	margin-right:140px;
	width:auto;
}
#gaia_content.grid_bb_king #bd #yui-main .yui-b .yui-gf .yui-u{
	width:600px;
	margin:0 0 0 10px;
}
#gaia_content.grid_bb_king #bd #yui-main .yui-b .yui-gf .first{
	width:200px;
	margin:0;
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

<!-- START GRID: BB KING -->
<div id="gaia_content" class="grid_bb_king yui-t4">
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
				<div class="yui-gf">
	
					<!-- START ZONE: 1A -->
					<div class="yui-u first">
						<? foreach ($zones['1a'] as $zone) : ?>
							<? $this->render($zone['name']); ?>
						<? endforeach; ?>
						<? if (isset($configs['1a']['direction']) && $configs['1a']['direction'] == 'horizontal') : ?> 
							<div class="clear"></div>
						<? endif; ?>                                                
					</div>
					<!-- END ZONE: 1A -->
					
					<!-- START ZONE: 1B -->
					<div class="yui-u">
						<? foreach ($zones['1b'] as $zone) : ?>
							<? $this->render($zone['name']); ?>
						<? endforeach; ?>
						<? if (isset($configs['1b']['direction']) && $configs['1b']['direction'] == 'horizontal') : ?> 
							<div class="clear"></div>
						<? endif; ?>
					</div>
					<!-- START ZONE: 1B -->
					
				</div>
			</div>
		</div>
	
		<div class="yui-b">
			<div class="skyscraper"></div>
		</div>
	
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
<!-- END GRID: BB KING -->

<?php
unset($zones, $configs);
?>

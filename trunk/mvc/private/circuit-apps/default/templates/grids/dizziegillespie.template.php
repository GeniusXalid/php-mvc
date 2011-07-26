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
	padding-top:10px;
	padding-left:10px;
}

#gaia_content.grid_dizzie_gillespie {
   /* width: 100% !important; */
width: 980px !important;
margin:0 auto;
    padding: 10px 0;
    border: 0;
	
}

/***** Dizzie Gillespie */
#gaia_content.grid_dizzie_gillespie #bd #yui-main{
	margin:0 0 10px 0;
}
#gaia_content.grid_dizzie_gillespie #bd .yui-b .leaderboard{
	margin:0 auto;
}

#gaia_content .leaderboard {
    position: relative;
    width:738px;
    height:100px;
    text-align: center;
    background:url(/images/gaia_global/body/shared/rs_leaderboard_border_738x100.gif) no-repeat;    
}
#gaia_content .leaderboard.undersized {
    width: 478px;
    height: 70px;
}

#gaia_content .leaderboard iframe {
    z-index: 50;
    position: absolute;
    left: 5px;
    top: 5px;
    overflow: hidden;
    width: 728px;
    height: 90px;
    border: 0;
    border-collapse: collapse;
}
#gaia_content .leaderboard.undersized iframe {
    width: 468px;
    height: 60px;
}

/* ]]> */
</style>

<!-- START GRID: DIZZIE GILLESPIE -->
<div id="gaia_content" class="grid_dizzie_gillespie">		
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
			<div class="yui-b first <? if (isset($configs['1a']['direction'])) { echo $configs['1a']['direction']; } ?>">
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
			<? $this->render('Default.Ads.Leaderboard'); ?>
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
<!-- END GRID: DIZZIE GILLESPIE -->
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
/***** Willie Dixon (SRV layout with zone 1A flexi width, wide skyscrapers) */
#gaia_content.ss_2Columns_flexiLeft_wideRight {
   /* width: 100% !important; */
	width: 980px !important;
	margin:0 auto;
    padding: 10px 0;
	padding-top:10px;
    border: 0;
}
#gaia_content.ss_2Columns_flexiLeft_wideRight .yui-b {
    width:170px;
    padding-right: 10px;
}
#gaia_content.ss_2Columns_flexiLeft_wideRight #yui-main .yui-b{
    width: auto;
    padding-left: 10px;
	padding-top:10px;
    margin-right:0px!important;
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

<!-- START GRID: WILLIE DIXON -->
<div id="gaia_content" class="ss_2Columns_flexiLeft_wideRight yui-t4">

    <!-- START ROW: 1 -->
    <div id="yui-main">

        <!-- START ZONE: 1A -->
        <div class="yui-b <? if (isset($configs['1a']['direction'])) { echo $configs['1a']['direction']; } ?>">
            <? foreach ($zones['1a'] as $zone) : ?>
                <? $config = $this->getZoneContentConfig($zone['name']); ?>
                <? isset($config['use_cache'])
                       ? $this->renderCache($zone['name'], $config['use_cache'] === TRUE ? NULL : $config['use_cache'])
                       : $this->render($zone['name']);
                ?>
            <? endforeach; ?>
            <? if (isset($configs['1a']['direction']) && $configs['1a']['direction'] == 'horizontal') : ?> 
                <div class="clear"></div>
            <? endif; ?>
        </div>
        <!-- END ZONE: 1A -->

    </div>
    <div class="yui-b">
        <? //$this->render('Default.Ads.WSkyscraper'); ?>        
    </div>
    <!-- END ROW: 1 -->

    <div class="clear"></div>
</div>
<!-- END GRID: WILLIE DIXON -->
            
<?php
unset($zones, $configs);
?>


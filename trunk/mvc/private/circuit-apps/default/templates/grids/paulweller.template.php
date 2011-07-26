<?php
$zones = $this->getZones(array('head','1a', '1b','foot'));
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

/***** Paul Weller */
#gaia_content.grid_paul_weller #bd .yui-b {
	width:230px;
}
#gaia_content.grid_paul_weller #bd #yui-main .yui-b{
    width: auto;
	margin:0 0 0 240px;
}


/* ]]> */
</style>

<!-- START GRID: PAUL WELLER -->
<div id="gaia_content" class="grid_paul_weller yui-t2">
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
	  <!-- START ZONE: HEAD-->
	  <div id="page_hd" class="hd">
		<? foreach ($zones['head'] as $zone) : ?>
			<? $this->render($zone['name']); ?>
		<? endforeach; ?>
		<div class="clear"></div>
	  </div>
	  <!-- END ZONE: HEAD-->
	  
	  <div id="page_bd" class="bd">
		   <div class="yui-b">
				<? foreach ($zones['1a'] as $zone) : ?>
				<? $this->render($zone['name']); ?>
				<? endforeach; ?>
		   </div>
		   <div id="yui-main">
				   <div class="yui-b">
						<? foreach ($zones['1b'] as $zone) : ?>
							<? $this->render($zone['name']); ?>
						<? endforeach; ?>
				   </div>
		   </div>
		   <div class="clear"></div>
	  </div>
		
	  <!-- START ZONE: FOOT-->
	  <div  id="page_ft" class="ft">
		<? foreach ($zones['foot'] as $zone) : ?>
			<? $this->render($zone['name']); ?>
		<? endforeach; ?>
	   <div class="clear"></div>
	  </div>
	  <!-- END ZONE: FOOT-->
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
<!-- END GRID: PAUL WELLER -->

<?php
$zones = $this->getZones(array('head','1a', '1b','foot'));
?>

<style type="text/css" media="screen">
/* <![CDATA[ */
/* This css is placed inline due to redesign of UXP 1.0. Grid resets from 1.0 will reside in templates until they are phased out. */

/*** Use the #gaia_content ID to reset width */
#gaia_content {
	width:980px;
	margin:0 auto;
	background:#000 url(images/include/body_bg_repeat.gif);
}
#gaia_content #hd {
	margin:0 0 10px 0;
}
#gaia_content #ft {
	margin:10px 0 0 0;
}
#gaia_content #bd, #gaia_content #ft {
	clear:both;
}
#gaia_content #bd {
	width:966px;
	
}
/***** cn_gaia_index */
#gaia_content.grid_cn_gaia_index #bd .yui-b {
	width:230px;
}
#gaia_content.grid_paul_weller #bd #yui-main .yui-b {
	width: 735px;
	margin:0 0 0 230px;
}


/* ]]> */
</style>

<!-- START GRID: PAUL WELLER index -->
<div id="gaia_content" class="grid_paul_weller yui-t2 grid_cn_gaia_index">
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
<!-- END GRID: PAUL WELLER index-->

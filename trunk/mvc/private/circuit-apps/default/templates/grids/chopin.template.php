<?php
$blocks = array('head', '1a', '1b', '2a', '2b', '3a', '3b', 'foot');
$config_elements = array('direction');
$zones   = $this->getZones( $blocks );
$configs = $this->getZoneConfigs($blocks , $config_elements ); 
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

/***** Chopin */
#gaia_content.grid_chopin #bd #yui-main{
	margin:0 0 10px 0;
	height:530px;
	overflow:hidden;
}
#gaia_content.grid_chopin #bd #yui-main .yui-ge .yui-u{
	width:310px;
}
#gaia_content.grid_chopin #bd #yui-main .yui-ge .first{
	width:630px;
}
#gaia_content.grid_chopin #bd #yui-main .yui-ge .yui-u .yui-g{
	width:auto;
}
#gaia_content.grid_chopin #bd #yui-main .yui-ge .yui-u .first{
	margin:0 0 10px 0;
}
#gaia_content.grid_chopin #bd #yui-main .yui-ge .yui-u .yui-g .yui-u{
	width:315px;
}
#gaia_content.grid_chopin #bd #yui-main .yui-ge .yui-u .yui-g .first{
	width:305px;
}
#gaia_content.grid_chopin #bd .yui-gb{
	height:260px;
	overflow:hidden;
}
#gaia_content.grid_chopin #bd .yui-gb .yui-u{
	width:315px;
	margin-left:10px;
}
#gaia_content.grid_chopin #bd .yui-gb .first{
	margin-left:0;
	width:305px;
}
#gaia_content.grid_chopin #bd .yui-gb .last{
	width:310px;
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

<!-- START GRID: CHOPIN -->
<div id="gaia_content" class="grid_chopin">

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
			<div class="yui-ge">
			    
                <div class="yui-u first">
                    
                    <!-- START ZONE: 1A -->
                    <div class="yui-g first <?= $configs['1a']['direction']; ?>">
                        <? foreach ($zones['1a'] as $zone) : ?>
				            <? $this->render($zone['name']); ?>
			            <? endforeach; ?>
			           <? if ( $configs['1a']['direction'] == 'horizontal') : ?> 
				           <div class="clear"></div>
			           <? endif; ?>
					</div>
                    <!-- END ZONE: 1A -->

					<div class="yui-g">
	                
                        <!-- START ZONE: 2A	-->				
                        <div class="yui-u first <?= $configs['2a']['direction']; ?>">
                            <? foreach ($zones['2a'] as $zone) : ?>
				                <? $this->render($zone['name']); ?>
			                <? endforeach; ?>
			                <? if ( $configs['2a']['direction'] == 'horizontal') : ?> 
				                <div class="clear"></div>
			                <? endif; ?>
						</div>
                        <!-- END ZONE: 2A -->

                        <!-- START ZONE: 2B -->
						<div class="yui-u  <?= $configs['2b']['direction']; ?>">
                        <? foreach ($zones['2b'] as $zone) : ?>
				            <? $this->render($zone['name']); ?>
			            <? endforeach; ?>
			            <? if ( $configs['2b']['direction'] == 'horizontal') : ?> 
				            <div class="clear"></div>
			            <? endif; ?>
                        </div>
                        <!-- END ZONE: 2B -->
					
                   </div>
               </div>
    
               <!-- START ZONE: 1B -->
			   <div class="yui-u <?= $configs['1b']['direction']; ?>">
                   <? foreach ($zones['1b'] as $zone) : ?>
				       <? $this->render($zone['name']); ?>
			       <? endforeach; ?>
			       <? if ( $configs['1b']['direction'] == 'horizontal') : ?> 
				       <div class="clear"></div>
			       <? endif; ?>
			   </div>
               <!-- END ZONE: 1B -->
			
            </div>
		</div>

       <!-- START ROW: 3 -->	
	   <div class="yui-gb">
           
           <!-- START ZONE: 3A -->
		   <div class="yui-u first <?= $configs['3a']['direction']; ?>">
               <? foreach ($zones['3a'] as $zone) : ?>
			       <? $this->render($zone['name']); ?>
			   <? endforeach; ?>
			   <? if ( $configs['3a']['direction'] == 'horizontal') : ?> 
			       <div class="clear"></div>
		       <? endif; ?>
		   </div>
           <!-- END ZONE: 3A -->
    
           <!-- START ZONE: 3B -->
		   <div class="yui-u <?= $configs['3b']['direction']; ?>">
		       <? foreach ($zones['3b'] as $zone) : ?>
			       <? $this->render($zone['name']); ?>
			   <? endforeach; ?>
			   <? if ( $configs['3b']['direction'] == 'horizontal') : ?> 
			       <div class="clear"></div>
			   <? endif; ?>
		   </div>
           <!-- END ZONE: 3B -->
		   
           <div class="yui-u last">
           
               <!-- START ZONE: LREC -->
			   <? $this->render('Default.Ads.LREC'); ?>
			   <!-- END ZONE: LREC -->			
		   
           </div>
		</div>
        <!-- END ROW: 3 -->
	
    </div> <!-- end bd -->
    
    <!-- START FOOTER -->
	<div id="ft">
      <? foreach ($zones['ft'] as $zone) : ?>
          <? $this->render($zone['name']); ?>
      <? endforeach; ?>
    </div>
    <!-- END FOOTER -->
 
</div>

<!-- END GRID: CHOPIN -->

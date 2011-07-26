<?php
$zones   = $this->get('zones');
$configs = $this->get('zone_configs');
?>
<!-- START GRID: PAUL CARRACK -->

<div id="gaia_content" class="grid_paul_carrack">

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
			<div class="grid_rc_container_top">
				<div class="rc_top_left">&nbsp;</div>
				<div class="rc_top_right">&nbsp;</div>
				<div class="top-line"></div>
			</div>
<div class="inner-bd">
	<div class="inner-bd-hd">
		<div class="inner-bd-hd-left"></div>
		<div class="inner-bd-hd-right"></div>
	</div>
			<div id="yui-main">
				<!-- START ZONE 1A -->
				<div class="yui-g<? if (isset($configs['1a']['direction'])) { echo " ".$configs['1a']['direction']; } ?>">
					<? foreach ($zones['1a'] as $zone) : ?>
                        <? $this->render($zone['name']); ?>
                    <? endforeach; ?>
                    <? if (isset($configs['1a']['direction']) && $configs['1a']['direction'] == 'horizontal') : ?> 
                        <div class="clear"></div>
                    <? endif; ?>
				</div>
				<!-- END ZONE 1A -->
			</div>

			<!-- START ZONE 2A -->
			<div class="yui-g<? if (isset($configs['2a']['direction'])) { echo " ".$configs['2a']['direction']; } ?>">
				<? foreach ($zones['2a'] as $zone) : ?>
                    <? $this->render($zone['name']); ?>
                <? endforeach; ?>
                <? if (isset($configs['2a']['direction']) && $configs['2a']['direction'] == 'horizontal') : ?> 
                    <div class="clear"></div>
                <? endif; ?>
			</div>
			<!-- END ZONE 2A -->
</div>
			<div class="grid_rc_container_bottom">
				<div class="rc_bottom_left">&nbsp;</div>
				<div class="rc_bottom_right">&nbsp;</div>
			</div>
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

<!-- END GRID: PAUL CARRACK, "Don't Shed A Tear" -->

<?php
unset($zones, $configs);
?>
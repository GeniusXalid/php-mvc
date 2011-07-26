<?php
$layout = $this->getLayoutConfig();
?>

</div>
<!-- END main content -->

<div id="gaia_footer" role="">
    <? if (require_level(USERLEVEL_STAFF_TEAM)) : ?>
        <p><a href="/admin/?">Go to Administration Panel</a></p>
	<p>Page generated in <?= round(array_sum(explode(" ",microtime())) - MICROTIME, 3) ?> seconds</p>
        <p>Time drift: <?= TIME_DRIFT ?>s</p>
        <p>Server IP: <?= $_SERVER['SERVER_ADDR'] ?></p>
    <? endif; ?>
    <? if (!SC::isEmpty('board_config.query_log')) : ?>
	<p><a href="/queryprofiler/?mode=read&ts=<?= SC::get('board_config.time_now') ?>" target="query_log">EXPLAIN</a></p>
    <? endif; ?>

</div>

<!-- For attaching events -->
<div id="fire_dom_ready"></div>

<!-- BEGIN Omniture tracking -->
<? if (!SC::isEmpty('board_config.omniture_enable')) : ?>
    <div style="position: absolute; width: 1px; height: 1px; overflow: hidden; left: -10px; top: -10px;">
       <script type="text/javascript" src="http://<?= GRAPHICS_SERVER ?>/src/common/<?= SC::isEmpty('board_config.test_db') ? 'omniture.js' : 'omniture_dev.js' ?>?<?= $layout->get('master_cachebuster') ?>"></script>
    <? include_once DIR_CIRCUIT_APPS . 'default/templates/footer/omniture.template.php'; ?>
       
    </div>
    <!-- END Omniture tracking -->
<? endif; ?>

<? if ($layout->get('enable_debug')) : ?>
    <div id="YUI_LOG_CONTAINER" style="position: absolute; right: 0; top: 0;"></div>
    <script type="text/javascript"> 
    var GAIA_log_reader = new YAHOO.widget.LogReader("YUI_LOG_CONTAINER", { 
        footerEnabled: true, 	// Don't show filters/pause/resume/clear UI 
        logReaderEnabled: true,	// Pause right away 
        thresholdMax: 100, 		// Show a maximum of 100 messages in the console 
        thresholdMin: 10 		// When thresholdMax is reached, clear out all messages 
        // in the console except the last 10 
    });
    GAIA_log_reader.collapse();
    </script>
<? endif; ?>

<? if ($layout->get('pageload_tracker')) : ?>
    <!-- BEGIN internal pixel tracker -->
    <img src="http://<?= MAIN_SERVER ?>/internal/dev_t.php?ip=<?= ip2long(get_user_ip()) ?>&sip=<?= ip2long($_SERVER['SERVER_ADDR']) ?>&pid=<?= SC::get('session_page') ?>&cls=<?= urlencode(SC::get('CIRCUIT_REQUEST_NAME')) ?>&tm=<?= SC::get('board_config.time_now') ?>" width="1" height="1" border="0" />
    <!-- END internal pixel tracker -->
<? endif; ?>
    
</body>
</html>

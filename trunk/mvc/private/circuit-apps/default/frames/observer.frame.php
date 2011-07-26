<?php
// +---------------------------------------------------------------------------+
// | This file is part of the CIRCUIT MVC Framework.                           |
// +---------------------------------------------------------------------------+
/**
 * Display a floating div that contains the <pre> formatted contents of the 
 * observer and the 'Default.debug' array
 */

class Default_Observer_CircuitFrame
{
    function execute( & $controller )
    {
		$observer =& $controller->getObserver();

		if ( require_level(USERLEVEL_MODERATOR_TEAM) || $observer->get('debug_log') == TRUE) 
		{
			if ($observer->get('debug_log')) $enablednote = "enabled";
			echo "\n\n\n\n<!-- BEGIN Frame: Default.Observer -->\n\n";
			echo "<script>function toggleLayer(whichLayer) { if (whichLayer=='obslink') { ";
			echo "var o = document.getElementById(whichLayer); if ( o.style.width=='15px') { o.style.width='99%'; } ";
			echo "else { o.style.width='15px'; } } else if (document.getElementById) { ";
			echo "var style2 = document.getElementById(whichLayer).style; style2.display = (style2.display=='block')? ";
			echo "\"none\":\"block\"; } } </script>\n<style> <!--\n";
			echo ".obs { font-family: tahoma,arial,helvetica; font-size:11px; color:#333; text-align: left; } \n";
			echo ".deb { font-family: tahoma,arial,helvetica; font-size:11px; color:#214482; text-align: left; } \n";
			echo ".debm { font-family: tahoma,arial,helvetica; font-size:11px; color:#824421; text-align: left; } \n";
			echo "div#obslink { height:22px; border:1px solid #000; padding: 2px; margin: 0px 0px 2px 0px;  background: #ccc; display:block; width:99%; overflow:hidden; line-height: 18px;} \n";
			echo "div#obslink a { text-decoration: none; } \n";
			echo "div#observer { border:1px solid #000; padding: 5px; margin: 0; background: #ccc; display:none; width:100%; z-index: 1000001;} \n";
			echo "div#debug { border:1px solid #214482; padding: 5px; margin: 0; background: #AEC4EB; display:none; width:100%; z-index: 1000001;} \n";
			echo "div#debugmessages { border:1px dashed #824421; padding: 5px; margin: 0; background: #EBC4AE; display:none; z-index: 1000001;} \n";
			echo "div#obswin { float: left; position: absolute; top: 0; left: 0; z-index: 1000000; width: 100%;  } \n";
			echo "--></style>";
			echo "\n\n<div id=\"obswin\">";
			echo "<div id=\"obslink\" class=\"obs\">";
			echo "<a href=\"javascript:toggleLayer('obslink');\">[o]</a>&nbsp;&nbsp;&nbsp;";
			if ( $observer->isEmpty('Default.debug.observer') ) 
			{
				echo "<strong>observer:</strong> <a href=\"javascript:toggleLayer('observer');\">show/hide</a>";
			}
			if ( !$observer->isEmpty('Default.debug')) 
			{
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<span class=\"deb\"><strong>debug:</strong> <a href=\"javascript:toggleLayer('debug');\">show/hide</a></span>";
			}
			if ( !$observer->isEmpty('Default.debug_messages')) 
			{
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<span class=\"debm\"><strong>messages:</strong> <a href=\"javascript:toggleLayer('debugmessages');\">show/hide</a></span>";
			}
			
			echo "</div>";
			if ( $observer->isEmpty('Default.debug.observer') ) 
			{
				echo "<div id=\"observer\" class=\"obs\">";
				gaia_pre($observer);
				echo "</div>";
			}
			if ( !$observer->isEmpty('Default.debug')) {
				echo "<div id=\"debug\" class=\"deb\">";
				gaia_pre($observer->get('Default.debug'));
				echo "</div>";
			}
			if ( !$observer->isEmpty('Default.debug_messages')) {
				echo "<div id=\"debugmessages\" class=\"deb\">";
				foreach ($observer->get('Default.debug_messages') as $k => $m) echo "<strong>".htmlspecialchars($k)."</strong><br/>".$m."<hr/>";
				echo "</div>";
			}
			//echo "<div>Observer Frame is <strong>".$enablednote."</strong></div>";
			echo "\n\n</div><!-- END Frame: Default.Observer -->\n\n\n\n";
		}		
		// done!
    }
}
?>
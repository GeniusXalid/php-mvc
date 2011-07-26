<?php
function FUNCLIB_buffer_browser_output()
{
	if(defined('OB_STARTED') || defined('OB_DISABLE') ) return;
	$sapi = php_sapi_name();
	if( strpos($sapi,'cli') !== FALSE ) return FALSE;
	if( strpos($sapi,'cgi') !== FALSE ) return FALSE;
	$contents = @ob_get_contents();
	@ob_end_clean();
	ob_start('output_to_browser');
	echo $contents;
	define('OB_STARTED', microtime(TRUE));
	define('HEADERS_SENT_BEFORE_OB', headers_sent());
}
?>
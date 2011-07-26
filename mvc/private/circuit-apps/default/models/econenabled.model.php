<?php

class Default_EconEnabled_CircuitModel
{
	function execute(&$observer)
	{
		if(SC::isEmpty('board_config.econ_disabled')) return TRUE;
		$observer->set('error.code', GENERAL_MESSAGE);
       	$observer->set('error.title', 'Econ Disabled');
	     $observer->set('error.message', 'The economy of gaia is currently disabled.');
          $observer->set('error.line', __LINE__);
          $observer->set('error.file', __FILE__);
          $observer->set('error.debug', backtrace() );
          return FALSE;
	}
}

?>
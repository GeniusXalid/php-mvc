<?php
// +---------------------------------------------------------------------------+
// | This file is part of the CIRCUIT MVC Framework.                           |
// |                                                                           |
// | Copyright (c) Gaia Online 2005                                            |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

require_once(DIR_FLUXCAP . 'fluxcapacitor.php');

/**
 * Make sure server is not over-worked!
 *
 * @author 72squared <john@gaiaonline.com>
 * @return bool    TRUE if the server load is fine, else FALSE.
 */
class Default_CheckServerLoadAvg_CircuitModel {
   /**
    * Execute the model
    * @param Container    The Observer object.
    * @return bool        TRUE if successful, else FALSE.
    * @access public
    */
    function execute( & $observer ) {
    	$flux =& FluxCapacitor::create('agent.checkserverloadavg');
		$rs =& $flux->execute();
		if ($rs->isSuccess()) { return TRUE; }
		$observer->set('error.code', GENERAL_ERROR);
		$observer->set('error.title', 'Server Overload');
		$observer->set('error.message', 'Server is busy due to heavy traffic.<BR/>Please try again in 5 minutes');
		$observer->set('error.line', __LINE__);
		$observer->set('error.file', __FILE__);
		$observer->set('error.debug', backtrace());
		return FALSE;
    	}
 	}
 
?>

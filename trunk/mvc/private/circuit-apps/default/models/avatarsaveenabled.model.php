<?php
// +---------------------------------------------------------------------------+
// | This file is part of the CIRCUIT MVC Framework.                           |
// |                                                                           |
// | Copyright (c) Gaia Online 2005                                            |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

include_once(DIR_FLUXCAP . 'fluxcapacitor.php');

/**
 * Make sure profile is not disabled.
 *
 * @author 72squared <john@gaiaonline.com>
 * @return bool    TRUE if the profile section is enabled, else FALSE.
 */
class Default_AvatarSaveEnabled_CircuitModel
{
   /**
    * Execute the model
    * @param Container    The Observer object.
    * @return bool        TRUE if successful, else FALSE.
    * @access public
    */
    function execute( & $observer )
    {
    	$flux = FluxCapacitor::create('agent.checkboardconfigvar');
		$flux->checkVarNames('avatar_save_disable');
		$rs = $flux->execute();
		$vars = $rs->getVariables();
        if( intval($vars['avatar_save_disable']) == 0 ) return TRUE;
        $observer->set('error.code', GENERAL_MESSAGE);
        $observer->set('error.title', 'Save Disabled');
        $observer->set('error.message', 'Avatar saving is currently disabled.');
        $observer->set('error.line', __LINE__);
        $observer->set('error.file', __FILE__);
        $observer->set('error.debug', backtrace() );
        return FALSE;
    }
 }
 
?>
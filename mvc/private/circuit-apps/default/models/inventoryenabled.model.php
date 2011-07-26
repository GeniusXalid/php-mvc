<?php
// +---------------------------------------------------------------------------+
// | This file is part of the CIRCUIT MVC Framework.                           |
// |                                                                           |
// | Copyright (c) Gaia Online 2005                                            |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * Make sure profile is not disabled.
 *
 * @author 72squared <john@gaiaonline.com>
 * @return bool    TRUE if the profile section is enabled, else FALSE.
 */
class Default_InventoryEnabled_CircuitModel
{
   /**
    * Execute the model
    * @param Container    The Observer object.
    * @return bool        TRUE if successful, else FALSE.
    * @access public
    */
    function execute( & $observer )
    {
        if( SC::isEmpty('board_config.inventory_disable') ) return TRUE;
        $observer->set('error.code', GENERAL_MESSAGE);
        $observer->set('error.title', 'Profile Disabled');
        $observer->set('error.message', 'The profile section of the site is currently disabled.');
        $observer->set('error.line', __LINE__);
        $observer->set('error.file', __FILE__);
        $observer->set('error.debug', backtrace() );
        return FALSE;
    }
 }
 
?>
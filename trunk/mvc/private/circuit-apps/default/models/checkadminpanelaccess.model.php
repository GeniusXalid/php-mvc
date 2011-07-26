<?
// +---------------------------------------------------------------------------+
// | This file is part of the CIRCUIT MVC Framework.                           |
// | Author 72squared  (john@gaiaonline.com)                                   |
// |                                                                           |
// | Copyright (c) Gaia Online 2005                                            |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * log user access of an admin pannel
 * @author     72squared <john@gaiaonline.com>
 * @package    Circuit
 */
class Default_CheckAdminPanelAccess_CircuitModel
{
   /**
    * Execute
    */
    function execute(&$observer)
    {
        if( SC::isEmpty("board_config.admin_panel_enable") && !defined('ALLOW_WWW') ) 
        {
            $message = "This page is not available under the current configuration, or ";
            $message .= "you are not authorized to view this page.";
            $observer->set('error.code', GENERAL_MESSAGE);
            $observer->set('error.message', $message);
            $observer->set('error.line', __LINE__);
            $observer->set('error.file', __FILE__);
            return FALSE;
        }

        return TRUE;
        
    }
}
?>
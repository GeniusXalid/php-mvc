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
 * make sure the forum is enabled
 * @author     72squared <john@gaiaonline.com>
 * @package    Circuit
 */
class Default_CheckForumEnabled_CircuitModel
{
   /**
    * Execute
    */
    function execute(&$observer)
    {
        if( SC::isEmpty("board_config.forum_disabled")) return TRUE; 
       
        $message = "The Site Forum is currently disabled";
        $observer->set('error.code', GENERAL_MESSAGE);
        $observer->set('error.message', $message);
        $observer->set('error.title', 'No Access');
        $observer->set('error.line', __LINE__);
        $observer->set('error.file', __FILE__);
        return FALSE;

        
    }
}
?>
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
class Default_AdminAccessLog_CircuitModel
{
   /**
    * Execute
    */
    function execute(&$observer)
    {
        
        // MOD RJH
        // Modification Date: 11-18-2004
        // Add Tracking for all actions into a single consolidated Admin Log Table
        // using Sushi to store data
        // TRACKING
        // ID (pk), USER ID(ind), IP(ind), datetime, request page, POST/GET
        if( preg_match("/^10./",$_SERVER['REMOTE_ADDR']) )  return TRUE;
       
        $GAIALOG = serialize(array($_GET,$_POST));
        $dao_logging =& DaoFactory::create('admincpanellog.insert');
        $dao_logging->setUserId(SC::get('userdata.user_id'));
        $dao_logging->setUsername(SC::get('userdata.username'));
        $dao_logging->setUserIp($_SERVER['REMOTE_ADDR']);
        $dao_logging->setDatetime(SC::get('board_config.time_now'));
        $dao_logging->setRequestFilename($_SERVER['SCRIPT_NAME']);
        $dao_logging->setRequestData($GAIALOG);
        $rs =& $dao_logging->execute();
        if(!$rs->isSuccess()) 
        {
            $observer->set('error.message', "Unable to connect to the database, please try again later.");
            $observer->set('error.title', 'Database Error');
            $observer->set('error.code', GENERAL_ERROR);
            $observer->set('error.line', __LINE__);
            $observer->set('error.file', __FILE__);
            return FALSE;
        }
        
        return TRUE;
        
    }
}
?>
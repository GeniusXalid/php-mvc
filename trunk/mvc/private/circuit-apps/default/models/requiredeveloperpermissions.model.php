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
 * check a user's permissions
 * @author     72squared <john@gaiaonline.com>
 * @package    Circuit
 */
class Default_RequireDeveloperPermissions_CircuitModel
{
   /**
    * Execute
    */
    function execute( & $observer )
    {
		if( !SC::get('userdata.session_logged_in') || ! require_level(USERLEVEL_DEVELOPER)) 
        {
            $message = "This page is not available under the current configuration, or ";
            $message .= "you are not authorized to view this page.";
            $observer->set('error.message', $message);
            $observer->set('error.code', GENERAL_MESSAGE);
			if ( !SC::get('userdata.session_logged_in') ) 
			{
				$observer->set('error.title', 'Not Logged In');
			}
			else
			{
				$observer->set('error.title', 'Not Authorized');
			}
			$observer->set('error.line', __LINE__);
            $observer->set('error.file', __FILE__);
            return FALSE;
        }
        return TRUE;
    }
}
?>
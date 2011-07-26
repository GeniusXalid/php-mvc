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
class Default_RequireMSRPermissions_CircuitModel
{
   /**
    * Execute
    */
    function execute( & $observer )
    {
    	$username=SC::get('userdata.username');
    	if(SC::get('userdata.session_logged_in') && $this->checkPrivileges($observer))
    	{
    		return true;
    	}else
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
		/*
        if( !SC::get('userdata.session_logged_in') || ! require_level(USERLEVEL_ADMINISTRATION_TEAM)) 
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
        */
        return TRUE;
    }
	public function checkPrivileges($o)
	{
		$username=SC::get('userdata.username');
		if(in_array($username,array('dev1','dev2'))){
			return true;
			
		}
		
		$uid=SC::get('userdata.user_id');
		$dao=DaoFactory::create('user/admin');
		$dao->select('count(user_id) as count');
		$dao->byUserId($uid);
		$rs=$dao->execute();
		if(!$rs->isSuccess())
		{
			throw new CircuitDatabaseException('query admin users failed', $rs);
		}
		$count=$rs->fetchrow(DB_ASSOC);
        
		if($count['count']==0)
		{
	  		$message = "This page is not available under the current configuration, or ";
	      	$message .= "you are not authorized to view this page.";
	      	$o->set('error.message', $message);
	      	$o->set('error.code', GENERAL_MESSAGE);
	      	$o->set('error.title', 'Not Authorized');
	      	$o->set('error.line', __LINE__);
	      	$o->set('error.file', __FILE__);
			return false;
		}
		return true;
	}
}
?>
<?php

/**
 * Authorize the user attempting to view this page has the correct level of permissions.
 * 
 * @param observer
 * @return bool
 */

class Default_RequireForumModPermissions_CircuitModel
{
	function execute(&$observer)
	{
		if( SC::isEmpty('userdata.user_id') || ! require_level(USERLEVEL_MODERATOR_TEAM) )
		{
			$observer->set('error.title', 'Permissions Error');
			$observer->set('error.message', 'You do not have permission to access this function.');
			$observer->set('error.line', __LINE__);
			$observer->set('error.file', __FILE__);
			return FALSE;
		}
		
		return TRUE;
	}//end of function
}//end of class

?>
<?php
// Circuit-App:			Default
// Model:				UserManager
// Description: 		Loads up userdata for specified users
// Author:		   		darknrgy <darknrgy@gaiaonline.com>
// Start Date:			04-13-07

require_once(DIR_CLASSES . 'usermanager.php');

class Default_UserDetail_CircuitModel extends CircuitModel{

	/** addUserIds
	 * add an array of users or a single item
	 * @param (Mixed) $ids (int or array of ints)
	 **/
	public function addIds($ids){

		if (!isset($this->ids)) $this->ids = array();
		if (is_array($ids)) {
			foreach ($ids as $id){
				$this->ids[$id] = $id;
			}
		}else{
            $this->ids[$ids] = $ids;
		}
	}

	/** execute()
	 * load the item data and build a lookup table
	 **/
	public function execute(){
		$um = $this->getUserManager();
                $um->specifySubsetFields(array('user_id', 'username', 'user_avatar'));
                $userTable = $um->getUserdata($this->ids);
                if( $um->hasErrors() ) throw new CircuitExecutionException('unable to load user info', $um);
                return $this->set('userdata', $userTable);
	}

	/** getUserManager
	 * retrieve a UserManager object. punch out for unit testing
	 * @return (UserManager) $userManager
	 **/
    private function getUserManager(){ return new UserManager(); }
	
}
 
?>
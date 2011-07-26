<?
// Circuit-App			Default  
// Model				InventoryHasItem  
// Description: 		Verify that a user has a particular item
// Author:		   		darknrgy darknrgy@gaiaonline.com 
// Start Date:			03-07-2007 

class Default_InventoryHasItem_CircuitModel extends CircuitModel{

    /** setUserId
	 * specify which user's inventory you want
	 * @params (int) $userId
	 **/
    public function setUserId($userId){ $this->userId = (int) $userId; }


	/** setMessenger
	 * optionally set a messenger so that a nice human message can be set
	 * @params $messenger
	 **/
    public function setMessenger($messenger){
        $this->messenger = $messenger;
	}


    /** hasItem
	 * run a check to see if this user has an item. never call from a view
	 * @params $itemId, $itemParam
	 * @return (bool) $hasItem or throw an exception
	 **/
    public function hasItem($itemId, $itemParam, $quantity=null){
    
        $itemId = (int) $itemId;
        if (!ctype_digit($itemParam)) throw new CircuitException("Invalid serial number");
				
		$ir = new InventoryReader($this->userId);
		$ir->hasItem($itemId);
		$rs = $ir->execute();
		
		if(!$rs->isSuccess()) {
			throw new CircuitExecutionException('Could not retrieve inventory, maybe trying again will help?');
		}
		
		//do they have the item?
		if( !$rs->hasItem($itemId)) {
			$this->messenger->addMessage("The item you specified is no longer available. Please make sure the item is in your inventory and not equipped on your avatar. ");
			return FALSE;
		}
		
		$user_quantity = $rs->getQuantityByItemId($itemId);
		$this->set('user_quantity',$user_quantity);
			
		//do they have the quantity required?
		$user_quantity = $rs->getQuantityByItemId($itemId);
		$this->set('user_quantity',$user_quantity);
		if($quantity > $user_quantity) {
			$this->messenger->addMessage("The item you specified is no longer avaialable or is not available in the <i>quantity</i> you specified.  ");
			return FALSE;
		}
		
		return TRUE;
		
	}	

	/** loadAccounts
	 * instantiate and load up accounts. do it only once per object
	 * @return InventoryLoader $loader
	 **/
    private function loadAccounts(){

        // return if already set
		if (isset($this->loader)) return $this->loader;
		
		// instantiate
		$this->loader = $this->getInventoryLoader($this->userId);
        
		// specify accounts
		$this->loader->specifyInventoryType(array('Inventory', 'GameInventory'));
		
		// load step
        try { $this->loader->load(); } 
		catch (Exception $e){ throw new CircuitExecutionException($e->getMessage(), $e->getDebug()); }

        return $this->loader;

	}

	/** getInventoryLoader
	 * load the libraries and return an InventoryLoader object
	 * punch this out for unit testing
	 * @return InventoryLoader $invLoader
	 **/
    private function getInventoryLoader($userId){
		
        require_once(DIR_CLASSES . "inventory/inventoryloader.php");
        return new InventoryLoader($userId);
	}

}

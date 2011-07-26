<?
// Circuit-App			Default  
// Model				Inventory  
// Description: 		Load a user's inventory for display
// Author:		   		darknrgy darknrgy@gaiaonline.com 
//						modded: march 2008 Laine for item normalization
// Start Date:			03-07-2007 

class Default_Inventory_CircuitModel extends CircuitModel{

    /** setUserId
	 * specify which user's inventory you want
	 * @params (int) $userId
	 **/
    public function setUserId($userId){ $this->userId = $userId; }

    /** setType
	 * game items/normal items
	 * @param (string) $accountType 
	 * - in deprecated mode, possible types are 'Inventory', 'GameInventory', 'UnequippedInventory', 'EquippedInventory'
	 */
	public function setType($accountType){ $this->type = $accountType; }

    /**
	
	#######THIS SHOULD BE DEPRECATED IN NEW NORMALIZED DATA STRUCTURE
	#######Tab is a visual concept, not fit for specifiying inventory types
	 * set how you want to filter the inventory - typically used to show a particular tab
	 * @param $filterMethod
	 * - for a list of all of the possible filters, visit the class definition for ItemSetFilter
	 
	 **/
	public function setTab($tab){ $this->tab = $tab; $this->set('tab',$tab); }

	/** setPage
	 * set the page number of the inventory
	 * @params (int) $page, (int) $resultsPerPage
	 **/
    public function setPage($page=1, $resultsPerPage=100){ $this->page = $page; $this->resultsPerPage = $resultsPerPage;}

	/** set the same values without actually executing.
	*/
	public function externalExecute($page, $resultsPerPage, $totalPages){ 
		//$this->set('tab',$this->$tab);
		$this->set('page', $page);
		$this->set('totalPages', $totalPages);
		$this->set('resultsPerPage', $resultsPerPage);
		return true;
	}
	
	/** execute
	 * run the loader, filter, and return a list of item ids. set the page of inventory into local model data
	 * @return (array) $itemIds or throw an exception	 
	 **/
    public function execute()
	{		
		if( $this->isLegacy()) {
			return $this->legacy_execute();
		}
		
		return $this->getInventory();
	}
	
	private function getInventory()
	{	
	        $this->page = $this->page ? $this->page : 1;
		$ir = new InventoryReader($this->userId);
		$ir->setPage( $this->page );
		$ir->setPerpage( $this->resultsPerPage );
		
		// set filter for inventory reader
		switch( $this->type )
		{
			case 'zomg':
				$ir->addFilter( new MainInventoryFilter() );
				$ir->addFilter( new ZomgFilter() );             
				break;
				
			case 'game':
				$ir->addFilter( new GameItemsFilter() );
				$ir->addFilter( new NotLootFilter() );              
				break;
			
			case 'equip':
				$ir->addFilter( new UnequippedFilter() );
                $ir->addFilter( new EquippablesFilter() );                
				break;
			
			case 'housing':
				$ir->addFilter( new HousingItemsFilter() );
                $ir->addFilter( new UnequippedFilter() );
				break; 
			
			case 'special':
				$ir->addFilter( new SpecialsFilter() );                
                $ir->addFilter( new UnequippedFilter() );
				break;
			
			default:
				$ir->addFilter( new MainInventoryFilter() );
                $ir->addFilter( new UnequippedFilter() );
				break;
		}		
		
		$ir->retrieveProperties();
		$rs = $ir->execute();
		//error handling
		if( !$rs->isSuccess())	{		
			throw new CircuitExecutionException($rs->whyYouBreak(), $rs->getDebug()); 
		}
		
		//format data
        $items = $rs->getItems();
		$item_ids = $rs->getItemIds();
		$items_total = $rs->getTotalItems();
		$serials = $rs->getSerials();

		if ( $this->type == 'zomg'&& count($items) < $this->resultsPerPage )
		{
			$ir = new InventoryReader($this->userId);
			$ir->addFilter( new LootFilter() );
			$ir->retrieveProperties();
			$rs = $ir->execute();
			if( !$rs->isSuccess())	{				
				throw new CircuitExecutionException($rs->whyYouBreak(), $rs->getDebug()); 
			}
			
			$items = array_merge($items,$rs->getItems());
			$item_ids = array_merge($item_ids,$rs->getItemIds());
			$items_total += $rs->getTotalItems();
			$serials = array_merge($serials,$rs->getSerials());
		}

		// save stuff for later.
		$this->set('inventory', $items);
		$this->set('serials', $serials);		
        $this->set('page', $this->page);		
		$this->set('totalPages', ceil($items_total / $this->resultsPerPage));		
		$this->set('resultsPerPage', $this->resultsPerPage);
		
		//return
		return $item_ids;
	}
	

	
	/*
	*
	*
	*
	*		new shit.
	*
	====================================================================================
	*
	*		old shit.
	*
	*
	*
	*
	*/
	
	
	/*
		using old data structures
	*/
	private function legacy_execute()
	{
		// validate input data
        $this->legacy_sanitize();

		// create inventory loader object
        $invLoader = $this->getInventoryLoader($this->userId);

		// specify accounts
        $main = ($this->type == 'UnequippedInventory' || $this->type == 'EquippedInventory')?'Inventory':$this->type;
        $invLoader->specifyInventoryType($main);
        
		// load step
        try { $invLoader->load(); } 
		catch (Exception $e){ throw new CircuitExecutionException($e->getMessage(), $e->getDebug()); }
			  
        // get the inventory (ItemSetIterator)
        $unfiltered = $invLoader->readAccount($this->type);
        
		// put the data into a filter
        $filter = $this->getItemSetFilter();

		if( $filter===false) {
			throw new CircuitExecutionException("Unable to load your inventory at this time. Please try again. ");
		}
		
        // filter if neccessary
        if (isset($this->tab)) {
            $filter->addFilter($this->tab);
		}

        // run the filter
        try { $filteredInv = $filter->execute($unfiltered, isset($this->page)?$this->page:false, isset($this->resultsPerPage)? $this->resultsPerPage : false); }
		catch (Exception $e){ throw new CircuitExecutionException($e->getMessage(), $e->getDebug()); }
        
        if ($filteredInv === false){
            throw new CircuitExecutionException("Unable to load your inventory at this time. Please try again. ");
        
        }
		
        for ($filteredInv->rewind(); $filteredInv->valid(); $filteredInv->next()) {
            $item = $filteredInv->currentItem();
            $itemTable[$item->id()] = $item->id();
		}

		$totalPages = $filter->getTotalPages();
        
		$this->set('inventoryIterator', $filteredInv);
        $this->set('tab', (($this->type == 'GameInventory')? 'game' : ($this->tab?$this->tab:'normal')));
		$this->set('page', $this->page);
		$this->set('totalPages', $totalPages);
		$this->set('resultsPerPage', $this->resultsPerPage);

        return $itemTable;
	}

	private function isLegacy(){ return SC::get('board_config.itemnorm_legacy')?true:false; }
	
    /** 
	 * make sure the input stuff is valid
	 * throw an exception if there is a problem with sanitization
	 **/
	private function legacy_sanitize(){

        // user id
		if (!isset($this->userId)) 
			throw new CircuitValidationException("User ID is not valid in " . __CLASS__ . ":" . __METHOD__ );
		$this->userId = (int) $this->userId;
        if ($this->userId <= 0) 
			throw new CircuitValidationException("User ID is not valid in " . __CLASS__ . ":" . __METHOD__ );
        
		// inventory type
		if (!in_array($this->type, array('Inventory', 'GameInventory', 'EquippedInventory', 'UnequippedInventory'))) 
			throw new CircuitValidationException("Invalid inventory type in " . __CLASS__ . ":" . __METHOD__ );
		
		// filter
        if (isset($this->filter)){
            if (!in_array($this->filter, array('items', 'equip', 'special', 'game'))) 
				throw new CircuitValidationException("Invalid inventory filter in " . __CLASS__ . ":" . __METHOD__ );
		}
		
		// pagination
		if (!isset($this->page)) $this->page = 1;
        $this->page = (int) $this->page;
        if ($this->page <= 0) 
			throw new CircuitValidationException("Invalid page in " . __CLASS__ . ":" . __METHOD__ );
        if (isset($this->resultsPerPage)){
			$this->resultsPerPage = (int) $this->resultsPerPage;
            if ($this->resultsPerPage <= 0) 
				throw new CircuitValidationException("Invalid resultsPerPage in " . __CLASS__ . ":" . __METHOD__ );
        }
	}
	
	########## LEGACY, CAN BE DELETED LATER
	/** 
	 * load the libraries and return an InventoryLoader object
	 * punch this out for unit testing
	 * @return InventoryLoader $invLoader
	 **/
    private function getInventoryLoader($userId){
		
        require_once(DIR_CLASSES . "inventory/inventoryloader.php");
        return new InventoryLoader($userId);
	}

	############ LEGACY, CAN BE DELETED LATER
	/** 
	 * load the libraries and return an ItemSetFilter object
     * @return (ItemSetIterator) $itemSetIterator
	 **/
    private function getItemSetFilter(){
        require_once(DIR_CLASSES . "inventory/itemsetfilter.php");
        return new ItemSetFilter();
	}
}

<?
// Circuit-App			Default  
// Model			    ItemDetail  
// Description: 		Look up basic item data based on a list of ids. 
// Author:		   	    darknrgy@gaiaonline.com, laine@gaiaonline.com
// Start Date:			03-07-2007 

// get item definitions from gaia_items, gaia_gameitems
// rewritten as an adapter to a stand alone class: ItemDefinitionReader

class Default_ItemDetail_CircuitModel extends CircuitModel{

	function __construct($c, $n){
        parent::__construct($c, $n);
        if (!$this->get('idr')) {$this->set('idr', new ItemDefinitionReader());}        
    }

	/** addIds
	 * add an array of items
	 * @param (Mixed) $ids (int or array of ints)
	 **/
	public function addIds($ids) {return $this->get('idr')->addIds($ids);}
	
	
	/** execute()
	 * load the item data and build a lookup table
	 * result: sets model variable with "items.itemid.iteminformation"
	 **/
	public function execute($useCache = TRUE){
        if (!$this->get('idr')->execute()) throw new CircuitExecutionException("Unable to load item definitions: " . $this->get('idr')->getError(), $idr);
        foreach ($this->get('idr')->getItems() as $item_id => $definition){
            $this->set("items.$item_id", $definition);
        }
        return $this->get('items');
    }
	
    /* checks and see if an item is tradable or not 
    * @param (int) item id of item we want to check
    * @return (bool) true if item is tradable, false if not tradable
    */
    public function isTradable( $itemid ){
        $is_tradable = $this->get('idr')->isTradable($itemid);
        if (!$is_tradable && isset($this->messenger)){
            $this->messenger->addMessage("The item ".$this->get("items.$itemid.name")." cannot be traded or sold to other users.");
        }
        return $is_tradable;        
    }
	
	/*
	* returns true if item is equipable by an avatar, false if not
	* @param (int) itemid of item we want to check
	*        (string) gender of the avatar we are comparing against
	* @return (bool) true if item is equipable by avatar, false if not
	*/
	public function isEquipable( $itemid , $gender ){return $this->get('idr')->isEquipable($itemid, $gender);}
	
	/*
	* @return (bool) returns true if given gender (of an avatar) can wear the item id
	*/
	public function sameGender( $itemid, $gender = NULL ){ return $this->sameGender($itemid, $gender);}	
    

    public function setMessenger( $messenger){ $this->messenger = $messenger; }


    
    // PropertyReader stuff has been moved to it's own model: Default.PropertyReader
    // please use this new model instead of the methods in here because this is GOING AWAY
    // props don't really belong here ;)
    
    /*
	* @return (bool) gets the itemdetail __properties__  if they're there.
	*/
	public function loadItemProperties( $serials, $owner )
	{
		// make sure we have something to look up.
		if ( !is_array($serials) || count($serials)==0 )
		{
			$this->set('properties',array() );
			return false;
		}
		
		$properties = !$this->isempty('properties') ? $this->get('properties') : array();
		
		// get the properties.
		include_once(DIR_CLASSES . '/itemnorm/propertyreader.php');
		$pr = new PropertyReader( );
		$new_properties = $pr->getProperties( $serials, $owner );
		if( !is_array($new_properties) ) {
			throw new CircuitExecutionException('Could not retrieve the properties of the current serials.');
		}
		foreach ($new_properties as $serial=>$prop)
		{
			$properties[$serial] = $prop;	
		}
		
		// save for later
		$this->set('properties',$properties);
		return TRUE;
	}
	
	
	/*
	* @return (bool) gets the itemdetail __properties__  if they're there.
	*/
	public function loadItemPropertiesMultipleOwners( $serials_by_owner )
	{
		// make sure we have something to look up.
		if ( !is_array($serials_by_owner) || count($serials_by_owner)==0 )
		{
			$this->set('properties',array() );
			return false;
		}
		
		// get the properties.
		include_once(DIR_CLASSES . '/itemnorm/propertyreader.php');
		
		$properties = !$this->isempty('properties') ? $this->get('properties') : array();
		foreach ($serials_by_owner as $owner=>$serials) 
		{
			$pr = new PropertyReader( );
			$new_properties = $pr->getProperties( $serials, $owner );
        	if( !is_array($new_properties) ) {
				throw new CircuitExecutionException('Could not retrieve the properties of the current serials.');
			}
			foreach ($new_properties as $serial=>$prop)
			{
				$properties[$serial] = $prop;	
			}
		}
		
		// save for later
		$this->set('properties',$properties);
		return TRUE;
	}

}

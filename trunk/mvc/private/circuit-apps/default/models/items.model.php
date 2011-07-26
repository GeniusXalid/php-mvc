<?php

require_once DIR_CLASSES . 'itemnorm/propertyreader.php';
require_once DIR_CLASSES . 'itemnorm/frozenchecker.php';

/**
* This model replaces the deprecated swap_item() 
*/

class Default_Items_CircuitModel extends CircuitModel {

    protected $error = FALSE;
    protected $debug = FALSE;
    protected $granted_items = NULL;
    
    /* swapItem
    * delete an item from a user's inventory and replace it with the given item(s)
    * @params (int) $from_serial - the serial that we want to delete
    * @params (int) $to_item_id the item we want to grant (assumed to be a single instance of this item, 
    *           OR (array) $to_item_id an array of items that we want to grant, can include the quantities as well
    * @params (int) $user_id - optional, will default to the current logged in user
    * @return (bool) TRUE upon success else FALSE and the error can be retrieved through getError()
    */

    public function swapItem($from_serial, $to_item_id, $user_id = NULL) {
        // default the user_id to the current logged in user if nothing was passed in 
        $user_id = empty($user_id) ? SC::get('userdata.user_id') : intval($user_id);
        
        // validate that the serial we want to delete belongs to the user
        $ir = new InventoryReader($user_id);
        $ir->bySerial($from_serial);
        $rs = $ir->execute();
        if (!$rs->isSuccess()) {
            return $this->throwError('Unable to load your inventory at this time. Please try again later. Error: '. $rs->getError(), $rs);
        }
        $data = $rs->getItems();
        
        // data is empty so that means the user doesn't own this serial
        if (empty($data)) {
            return $this->throwError('The item was not found in your inventory.');
        }
        
        // validate that the item we want to swap to exists
        // to_item_id can be either an INT (item_id that we want to grant) or
        // an array of item_ids that we want to grant and how many of each we want to grant
        // get the ids of the items we want to grant
        $item_ids = array();
        if (is_array($to_item_id)) {
            foreach ($to_item_id as $item) {
                $item_ids[] = $item['item_id'];
            }
        }
        else {
            $item_ids[] = $to_item_id;
        }
        // check to see if the items we want to grant exist
        $idr = new ItemDefinitionReader();
        $idr->addIds($item_ids);
        if (!$idr->execute('__meta__')) {
            return $this->throwError('Unable to load item detail, please try again. ' . $idr->getError(), $idr);
        }
        $found_ids = $idr->getItemIds();
        // if item_ids contains ids that arent in $found_ids then an item doesn't exist
        $difference = array_diff($item_ids, $found_ids);
        if (!empty($difference)) {
            return $this->throwError('Item(s) not found', $difference);
        }
        
        // at this point we have a valid serial that belongs to the user_id and valid items that we want to grant
        $txn = DaoFactory::create('transactionmanager');
    
        // clear frozen status (if any) as we should allow users to open frozen letters
        $prop = PropertyReader::instance()->getProperties($from_serial, $user_id);
        $from_item_frozen_property = NULL;
        if (isset($prop['frozen']) && FrozenChecker::isFrozenByProperty($prop)){
            $from_item_frozen_property = $prop['frozen'];
            // would be nice if we can attach $txn to $iw here, but it would create a dirty read
            // problem. we could potentially fail later after clearing the frozen status. we will live
            // with the unlikely case for now.
            $iw = new InventoryWriter(IW_APPCODE_FUNC_SWAP_ITEM);
            $iw->deleteProperty($from_serial, $user_id, INVENTORY_LOCATION_MAIN, 'frozen');
            $iwr = $iw->execute();
            if (!$iwr->isSuccess()){
                $txn->rollback();
                return $this->throwError($iwr->getError());
            }
        }
        
        //delete item we are swapping out
        $iw = new InventoryWriter(IW_APPCODE_FUNC_SWAP_ITEM, $txn);
        $iw->deleteSerializedItem($user_id, $from_serial);
        //grant item(s) we are swapping in
        if (is_array($to_item_id)) {
            foreach ($to_item_id as $item) {
                $quantity = isset($item['quantity']) ? $item['quantity'] : 1;
                $iw->grantNewItems($user_id, $item['item_id'], $quantity);
            }
        }
        else {
            $iw->grantNewItems($user_id, $to_item_id, 1);
        }
        $iwr = $iw->execute(FALSE);
        if (!$iwr->isSuccess()){
            $txn->rollback();
            return $this->throwError($iwr->getError());
        }
    
        // get the serials of the granted items
        $this->granted_items = $iwr->getGeneratedSerials();
        
        if ($from_item_frozen_property) {
            // transfer the frozen property value to the swapped item
            // with packages it's not possible that a frozen item will grant multiple items.
            // all these items should be frozen
            $iw = new InventoryWriter(IW_APPCODE_FUNC_SWAP_ITEM, $txn);
            foreach ($this->granted_items as $new_serial) {
                $iw->setProperty($new_serial, $user_id, INVENTORY_LOCATION_MAIN, 'frozen', $from_item_frozen_property);
            }
            $iw->execute(FALSE);
            if (!$iwr->isSuccess()){
                $txn->rollback();
                return $this->throwError($iwr->getError());
            }
        }
        $txn->commit();
        
        // set the new serials associated with the item_ids
        return TRUE;
    }

    public function getHTMLId($item, $serial) {
      return "{$serial}.{$item}." . md5($item . $serial);
    }

    public function checkHTMLId($item, $serial, $value) {
      return md5($item . $serial) == $value;
    }
    
    public function getError() { return $this->error; }
    public function getDebug() { return $this->debug; }
    public function getGrantedItems() { return $this->granted_items; }
    
    protected function throwError($error, $debug=FALSE) {
        $this->error = $error;
        $this->debug = $debug;
        return FALSE;
    }
}

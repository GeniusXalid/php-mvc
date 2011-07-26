<?php
/**
 * Default: Item Nonce Model
 * Use nonces to validate multiple arbitrary keys in request submission
 * @author Dan Quinlivan
 * @date 2007-10-08
 */
 
if (! class_exists('Nonce')) { include_once DIR_CLASSES . 'nonce/nonce.php'; }
 
class Default_ItemNonce_CircuitModel extends CircuitModel {
    
    /* add an item
    * @params   (string) $index - specify index in the final array so it can be comsumed in the view without helpers
                (mixed) $params - array values that will be used to generate the nonce ($userid, $itemid) OR a single value
    * @return (string) $nonce
    * nonce is also stored in the local container, keyed by $index
    */
    public function addItem($index, $params){
        if (!($key = $this->createKey($params))) return false;
        $nonce = $this->generateNonce($key);
        $this->set("items.$index", $nonce);
        return $nonce;
    }
    
    /* validate item
    * @params   (string) $nonce - nonce we receieved from a request to be compared
    *           (array) $params - values that will be used to generate the nonce eg ($userid, $itemid)
    * @return (bool) $isValid
    */
    public function validateItem($nonce, $params){
        if (!($key = $this->createKey($params))) return false;
        return $this->validateNonce($key, $nonce);        
    }
    
    /* PRIVATE PRIVATE PRIVATE */
    
    /* generate nonce from a key
    * punch me out for unit test
    * @params (array) $key
    * @return (string) $nonce
    */
    protected function generateNonce($key){
        return Nonce::generateString($key);
    }
    
    /* create a key
    * @params (array) $params - values that will be used to generate the nonce eg ($userid, $itemid)
    * @return (string) $key
    */
    protected function createKey($params){
        if ($params == "" || $params == 0) return false;
        if (!is_array($params)) $params = array($params);
        if (!sort($params, SORT_STRING)) return false;
        $key = implode("-", $params);
        return $key;
    }
    
    /** validate a nonce
    * @params (string) $key, (string) $nonce
    * @return (bool) $isValid
    **/
    protected function validateNonce($key, $nonce){
        return Nonce::validateString($nonce, $key);
    }
}
    

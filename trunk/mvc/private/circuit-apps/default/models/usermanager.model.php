<?php
/**
 * Handles basic user functions
 * This model is mostly a wrapper for the UserManager class since models
 * are the only way to transfer data from a circuit-app action to a view.
 * If an app-specific data container is ever created, this file can be
 * deprecated since actions will be able to call the UserManager directly
 * and store the results for the view without needing the intermediate layer.
 *
 * All methods should be named the same as their UserManager counterparts and
 * results should be stored in a model container key of the same name as the
 * method.
 * e.g., $this->set('lookupUsernames', $this->usermanager->lookupUsernames($ids)); 
 *
 * @author Karen Ziv <kziv@gaiaonline.com>
 **/
require_once DIR_CLASSES . 'usermanager.php';

class Default_UserManager_CircuitModel extends CircuitModel {

    protected $usermanager;

    /**
     * Class constructor
     * Creates and stores a new instance of the UserManager
     **/
    public function __construct($c, $n) {
        parent::__construct($c, $n);
        $this->usermanager = new UserManager();
    }

    /**
     * LoadIDs
     **/
    public function loadIDs($ids) {

    }

    /**
     * specifySubsetFields
     **/
    public function specifySubsetFields($fields) {
        return $this->usermanager->specifySubsetFields($fields);
    }

    /**
     *
     **/
    public function getUserStatus( $getids=NULL, $force_query=false ) {
        return $this->set('getUserStatus', $this->usermanager->getUserStatus($getids, $force_query));
    }

    /**
     *
     **/
    public function getUserData( $getids=NULL, $force_query=false ) {
        return $this->set('getUserData', $this->usermanager->getUserData($getids, $force_query));
    }

    /**
     *
     **/
    public function getFullUserData( $getids=NULL, $force_query=FALSE) {
        return $this->set('getFullUserData', $this->usermanager->getFullUserData($getids, $force_query));
    }

    /**
     *
     **/
    public function getUserLocation( $getids=NULL ) {
        return $this->set('userLocation', $this->usermanager->getUserLocation($getids));
    }

    /**
     * 
     **/
    public function lookupUsernames($getids=NULL) {
        return $this->set('lookupUsernames', $this->usermanager->lookupUsernames($getids));
    }

    /**
     *
     **/
    public function lookupUserid( $getname=NULL ) {
        return $this->set('lookupuserid', $this->usermanager->lookupUserID($getname));
    }

    /**
     *
     **/
    public function hasErrors() {
        $errors = $this->usermanager->hasErrors();
        $this->set('hasErrors', $errors);
        return $errors;
    }
    
# EOC
}
?>

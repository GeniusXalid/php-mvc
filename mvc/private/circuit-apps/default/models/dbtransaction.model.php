<?
// Circuit-App			Default 
// Model				DBTransaction 
// Description: 		Start and stop a db transaction. Make sure you have a VIEW_ERROR defined to catch the CircuitDatabaseException 
// Author:		   		darknrgy darknrgy@gaiaonline.com 
// Start Date:			09-18-06 

class Default_DBTransaction_CircuitModel extends CircuitModel{

	/** start
	 * start a db connection
	 * @return DaoFactory Transaction
	 **/
	function start(){ 
		$this->set('transactionmanager', $tran = $this->daoCreate('transactionmanager'));
        if ($this->get('transactionmanager') == false) {
			throw new CircuitDatabaseException("Unable to start a Database Transaction. Please try again.", $this->get('transactionmanager'));
		}
		return $tran;
	}

	/** commit
	 * commit a transaction and throw an exception if fail
	 **/
	function commit(){ 
		
		if (!$this->get('transactionmanager')->commit()){
			throw new CircuitDatabaseException("Unable to complete Database Transaction. Please try again.", $this->get('transactionmanager'));
		}
	}

    /** daoCreate
	 * Create a dao object. Implemented only so it can be punched out for unit testing
	 * @params String $daoName
	 * @return Dao
     **/
	function daoCreate($daoName) {return DaoFactory::create($daoName);}

}
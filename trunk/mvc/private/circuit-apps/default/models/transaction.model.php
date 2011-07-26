<?php
class Default_Transaction_CircuitModel extends CircuitModel {

    ###
    # Starts a DAO transaction
    # This function opens a DAO transaction
    # @return (object) DAO transaction object reference
    ###
    public function start() {
        return DaoFactory::create('transactionmanager');
    }

    ###
    # Commits a DAO transaction
    # @return (bool) Success (TRUE) or failure (FALSE) of commit
    ###
    public function commit($tran) {
        return $tran->commit();
    }
    
# EOC
}
?>

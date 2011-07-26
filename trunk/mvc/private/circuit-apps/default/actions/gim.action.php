<?php
class Default_Gim_CircuitAction extends CircuitAction {

	function execute( CircuitController $c )
    {
	    $userid = $c->getRequest()->get('userid');
		$c->getModel('Default.Gim')->load($userid);
		return VIEW_SUCCESS;
    }

}
?>

<?php
class Default_Location_CircuitAction extends CircuitAction {

   function execute( CircuitController $c )
    {
	    $userid = $c->getRequest()->get('userid');
		$c->getModel('Default.Location')->load($userid);
		return VIEW_SUCCESS;
    }


# EOC
}
?>

<?php
/**
 * Find gim name of user
 * @author     Kean Tan <ktan@gaiaonline.com>
 */
 class Default_Gim_CircuitView extends CircuitView {
	
	public function execute(CircuitController $c) {

        $userid = $c->getRequest()->get('userid');
		$location = $this->import('Default.Gim')->get($userid);
		
		echo $location;

        exit;
    }

 }
 ?>

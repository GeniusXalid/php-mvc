<?php
/**
 * Find location of user and redirect
 * @author     Kean Tan <ktan@gaiaonline.com>
 */
 class Default_Location_CircuitView extends CircuitView {
	
	public function execute(CircuitController $c) {

        $userid = $c->getRequest()->get('userid');
		$location = $this->import('Default.Location')->get($userid);

		// Force no cache for location
		header( 'Cache-Control: no-store, no-cache, must-revalidate' );
		header( 'Cache-Control: post-check=0, pre-check=0', false );
		header( 'Pragma: no-cache' ); 
		header( 'location: ' . $location);
        // bye bye!
        exit;
    }

 }
 ?>

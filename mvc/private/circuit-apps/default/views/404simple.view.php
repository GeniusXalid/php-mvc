<?php
/**
 * Displays a simple 404 page
 * Use this view when you need a short 404 page, such as in AJAX or API calls.
 * @author John <jloehrer@gaiaonline.com>
 * @author Karen <kziv@gaiaonline.com>
 * @see Default.404.View
 **/
class Default_404Simple_CircuitView extends CircuitView {

    public function execute(CircuitController $c) {
        
        $msg = '404 Not Found';

        // Send page headers
        header($_SERVER['SERVER_PROTOCOL']. ' ' . $msg);
        header("Status: " . $msg);

        die('<h2>' . $msg . '</h2>');        
    }
    
}

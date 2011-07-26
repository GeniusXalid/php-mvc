<?php
/**
 * Displays a global 404 page
 * Shows a full webpage with an informative page not found message
 * @author John <jloehrer@gaiaonline.com>
 * @author Karen <kziv@gaiaonline.com>
 * @see Default.404Simple.View
 **/
class Default_404_CircuitView extends CircuitGridView {

    public function execute(CircuitController $c) {

        //session_pagestart(PAGE_4O4);
        
        $msg = '404 Not Found';

        // Send page headers
        header($_SERVER['SERVER_PROTOCOL']. ' ' . $msg);
        header("Status: " . $msg);

        include(DIR_PUBLIC_HTML . '404.html'); exit;
    }
    
}

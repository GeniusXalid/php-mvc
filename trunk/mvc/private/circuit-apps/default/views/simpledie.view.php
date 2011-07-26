<?php

/**
 * Generate a simple die message with little or no html formatting.
 * This generates an error page using data from the request container or the
 * observer (for backwards compatibility) if the request data does not exist.
 * @author John <jloehrer@gaiaonline.com>
 * @author Jenn <jtsai@gaiaonline.com>
 **/

class Default_SimpleDie_CircuitView extends CircuitView {

    public function execute(CircuitController $c) {
	
    	$r = $c->getRequest();
    	$observer = $c->getObserver();
        
        // Get the message data. Try the request container first,
        // only using the observer for backwards compatibility
        if ($r->isEmpty('error.message')) {
            $message = $observer->get('error.message');
            $title = $observer->get('error.title');
            $line = $observer->get('error.line');
            $file = $observer->get('error.file');
            $debug = $observer->get('error.debug');
        }
        else {
            $message = $r->get('error.message');
            $title = $r->get('error.title');
            $line = $r->get('error.line');
            $file = $r->get('error.file');
            $debug = $r->get('error.debug');
        }
        
        if (strlen($title) < 1) $title = 'ERROR';
        if (strlen($message) < 1) $message = 'An error occured';
        
        $debug_str = '';
        if (!SC::isEmpty('board_config.enable_debug')) {
            $location_format = "\nFILE: %s\nLINE: %s\n";
            $debug_str = (strlen( $line ) > 0 && strlen($file) > 0 ) ? sprintf($location_format, $file, $line) : '';
            
            if (!empty($debug) && !is_scalar($debug)) {
                ob_start();
                var_dump($debug);
                $debug = ob_get_contents();
                ob_end_clean();
            }
            $debug_str .= "\n\nDEBUG\n$debug\n";
        }
        $format = "<pre>%s\n%s\n\n%s\n</pre>\n\n";
        $output = sprintf( $format, $title, $message, $debug_str);
        DBFactory::closeAll();
        die( $output );
        exit;
    }
}

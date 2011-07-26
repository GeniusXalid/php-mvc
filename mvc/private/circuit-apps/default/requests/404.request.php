<?php
/**
 * Shows a 404 page
 **/
class Default_404_CircuitRequest extends CircuitRequest {
    
    public function selectView() {
        return 'Default.404';
    }
}

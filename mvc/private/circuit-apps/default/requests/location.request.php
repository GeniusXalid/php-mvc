<?php
# +---------------------------------------------------------------------------+
# | This file is part of the CIRCUIT MVC Framework.                           |
# | Author Kean Tan (ktan@gaiaonline.com                                      |
# |                                                                           |
# | Copyright (c) Gaia Online 2008                                            |
# +---------------------------------------------------------------------------+

/**
 * This page handles location and redirect to location
 */
class Default_Location_CircuitRequest extends CircuitRequest {

    public function load() {
		$this->loadParam('userid');
    }

	public function selectAction() {
        return "Default.Location";
    }

    public function selectView() {
        return 'Default.Location';
    }
}
?>

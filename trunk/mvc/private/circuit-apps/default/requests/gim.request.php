<?php
# +---------------------------------------------------------------------------+
# | This file is part of the CIRCUIT MVC Framework.                           |
# | Author Kean Tan (ktan@gaiaonline.com                                      |
# |                                                                           |
# | Copyright (c) Gaia Online 2008                                            |
# +---------------------------------------------------------------------------+

/**
 * This page handles gim requests
 */
class Default_Gim_CircuitRequest extends CircuitRequest {

    public function load() {
		$this->loadParam('userid');
    }

	public function selectAction() {
        return "Default.Gim";
    }

    public function selectView() {
        return 'Default.Gim';
    }
}
?>

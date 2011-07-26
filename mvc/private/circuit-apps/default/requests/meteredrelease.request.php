<?php
# +---------------------------------------------------------------------------+
# | This file is part of the CIRCUIT MVC Framework.                           |
# | Author foobarbazquux (kziv@gaiaonline.com                                 |
# |                                                                           |
# | Copyright (c) Gaia Online 2005                                            |
# |                                                                           |
# | For the full copyright and license information, please view the LICENSE   |
# | file that was distributed with this source code.                          |
# +---------------------------------------------------------------------------+

//include_once DIR_CLASSES . 'jsmin-1.1.0.php';

/**
 * This page handles JS minification
 */
class Default_MeteredRelease_CircuitRequest extends CircuitRequest {

    public function load() {}
    
    public function selectAction() {}
    
    public function selectView($result) {
        return 'Default.MeteredRelease';
    }
}
?>
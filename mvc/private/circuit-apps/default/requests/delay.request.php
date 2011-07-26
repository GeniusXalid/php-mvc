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

/**
 * This page handles redirect requests
 */
class Default_Delay_CircuitRequest extends CircuitRequest {

    public function load() {
        $this->loadParam('sleep');
    }

    public function selectView() {
        sleep(intval($this->get('sleep')));
        
        $header = '(function() { return ';
        $footer = ' })()';
        
        $data = array('sleep' => 'success');

        echo $header . json_encode($data) . $footer;
        exit;
    }
}
?>

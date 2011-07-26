<?php
// +---------------------------------------------------------------------------+
// | This file is part of the CIRCUIT MVC Framework.                           |
// | Author 72squared  (john@gaiaonline.com)                                   |
// |                                                                           |
// | Copyright (c) Gaia Online 2005                                            |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * To use this file, simply run the following symlink command:
 *
 * ln -s ~/code/private/circuit-apps/clearinghouse/public/index.php ~/code/public_html/order/index.php
 */

// find web root directory
$path = substr(__FILE__, 0, strpos( __FILE__, 'private/' ) +8);

// include script setup.
require_once( $path . 'common.php' );

 // include the circuit framework
require_once( DIR_CLASSES . 'circuit.inc.php' );

// intialize the controller
$controller = new CircuitController();

// set the path
$controller->setAppDIR( DIR_CIRCUIT_APPS );

// if URL metered for this person send them away
if (!metered_release($_SERVER['REQUEST_URI'])) {
    $controller->dispatch('Default.MeteredRelease');
    exit();
}

// execute the request.
$controller->dispatch('Default.Router');

// all done! exit.
exit();

?>
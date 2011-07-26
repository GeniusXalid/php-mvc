<?php
class Default_Disabled_CircuitAction extends CircuitAction {

    function execute() {
	throw new CircuitDisabledException('This feature is currently disabled. Please try again later!');
    }

# EOC
}
?>

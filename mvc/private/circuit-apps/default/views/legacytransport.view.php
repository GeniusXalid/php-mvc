<?php

class Default_LegacyTransport_CircuitView extends CircuitGridView {
    public function execute($c) {
        $this->render($this->get('template'));
    }
}
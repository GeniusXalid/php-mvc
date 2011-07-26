<?php
$data = $this->get('data');

$header = '(function() { return ';
$footer = ' })()';

echo $header . json_encode($data) . $footer;
?>
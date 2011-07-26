<?php
$zones   = $this->get('zones');
$configs = $this->get('zone_configs');
?>

				<? foreach ($zones['1a'] as $zone) : ?>
                    <? $this->render($zone['name']); ?>
                <? endforeach; ?>
                <? if (isset($configs['1a']['direction']) && $configs['1a']['direction'] == 'horizontal') : ?> 
                    
                <? endif; ?>

<?php
$zones   = $this->get('zones');
$configs = $this->get('zone_configs');
?>

    <div id="gaia_content" class="grid_980 yui-t4">
      <div id="bd">
        <div id="yui-main">
          <!-- START ZONE: 1A -->
          <div class="yui-b">
            <div class="yui-gf">
              <div class="yui-u first" role="left" style="background:none;width:116px;">     
     	<? foreach ($zones['1a'] as $zone) : ?>
					<? $this->render($zone['name']); ?>
				<? endforeach; ?>      
              </div>
              <div class="yui-u center" role="center" >
              <!-- center row one 焦点图-->
              <div class="yui-gd">
              	<div class="yui-u first" style="width:250px;">
                		<? foreach ($zones['2a'] as $zone) : ?>
					<? $this->render($zone['name']); ?>
				<? endforeach; ?>
                </div>
                <div class="yui-u" style="width:356px;">
                		<? foreach ($zones['5a'] as $zone) : ?>
					<? $this->render($zone['name']); ?>
				<? endforeach; ?>
                </div>
              </div>
              <!-- end center row one 焦点图-->
              <!--我的礼物-->
              <div id="my-gift-list" class="my-gaia-info my-gift-list">
 			<? foreach ($zones['6a'] as $zone) : ?>
					<? $this->render($zone['name']); ?>
				<? endforeach; ?>
 
 
              </div>
              <!--我的礼物 结束-->
              <!--留言板-->
              <div id="my-message-list" class="my-gaia-info my-message-list">
              		<? foreach ($zones['7a'] as $zone) : ?>
					<? $this->render($zone['name']); ?>
				<? endforeach; ?>
              
              
              </div>
              <!--留言板 结束-->
               <!-- 我的订阅 -->
              <div id="my-dingyue-list" class="my-gaia-info my-dingyue-list">
                   		<? foreach ($zones['8a'] as $zone) : ?>
					<? $this->render($zone['name']); ?>
				<? endforeach; ?>
              </div>
              <!--我的订阅 结束-->
              
              </div>
            </div>
          </div>
          <!-- END ZONE: 1A -->
        </div>
        <div class="yui-b">
          <!--最近来访-->
          <div id="my-visited-list" class="my-gaia-info my-visited-list">
            	<? foreach ($zones['2b'] as $zone) : ?>
					<? $this->render($zone['name']); ?>
				<? endforeach; ?>
          </div>
          <!--最近来访 结束-->
          <!--我的好友-->
          <div id="my-friends-list" class="my-gaia-info my-friends-list">
     	<? foreach ($zones['3b'] as $zone) : ?>
					<? $this->render($zone['name']); ?>
				<? endforeach; ?>
          </div>
          <!--我的好友 结束-->
        </div>
      </div>
      <!-- end bd -->
      <div class="clear"></div>
    </div>
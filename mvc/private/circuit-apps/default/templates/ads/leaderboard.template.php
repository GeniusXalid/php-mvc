<?php
include_once DIR_CLASSES . 'user.class.php';
// add in any parameters that are missing...
$default_ad_params = array('ad_network'=>'doubleclick', 'size'=>'leaderboard', 'campaign'=>NULL, 'ad_type'=>'rich', 'ad_site'=>'gaia.home', 'ad_zone'=>'home', 'ad_age'=>39, 'ad_gender'=>'m', 'ad_bc_time'=>SC::get('board_config.time_now'));
foreach($default_ad_params as $p_name => $p_value) { if (!$this->get($p_name)) { $this->set($p_name, $p_value); } }
?>

<!-- START Leaderboard Ad Block -->

	<? if (User::isDonator()) : ?>
	    <div class="leaderboard">
	        <span style="font-size: 10px" class="accessAid">ADVERTISEMENT</span>
	        <script type="text/javascript">
	        var ad_inject = '<?= $this->generateURL('Advertise.Main', array('size' => 'leaderboard')) ?>';
	        </script>
	        <iframe id="ad_inject" src="" scrolling="no" frameborder="0"></iframe>
	    </div>
	<? elseif (SC::get('ads.blue_lithium.show')): ?>
	    <div class="leaderboard undersized">
	        <span style="font-size: 10px" class="accessAid">ADVERTISEMENT</span>
	        <script type="text/javascript">
	        var ad_inject = 'http://media.adrevolver.com/adrevolver/banner?place=12709&cpy=<?= mt_rand(1, 9999) ?>';
	        </script>
	        <iframe id="ad_inject" src="" scrolling="no" frameborder="0"></iframe>
	    </div>
	<? else : ?>
		<? if ($this->get('ad_network') == 'doubleclick') : ?>
			    <div class="leaderboard">
			        <span style="font-size: 10px" class="accessAid">ADVERTISEMENT</span>
			        <script type="text/javascript">
			        var ad_inject = 'http://<?= MAIN_SERVER ?>/advertise/doubleclick.php?size=leaderboard&campaign=<?= $this->get('ad_campaign') ?>&t=<?= $this->get('ad_type') ?>&s=<?= $this->get('ad_site') ?>&z=<?= $this->get('ad_zone') ?>&a=<?= $this->get('ad_age') ?>&g=<?= $this->get('ad_gender') ?>&o=<?= $this->get('ad_bc_time') ?>';
			        </script>
			        <iframe id="ad_inject" src="" scrolling="no" frameborder="0"></iframe>
			    </div>
		<? else : ?>
		    <div class="leaderboard">
		        <span style="font-size: 10px" class="accessAid">ADVERTISEMENT</span>
		        <script type="text/javascript">
		        var ad_inject = 'http://<?= MAIN_SERVER ?>/advertise/<?= $this->get('ad_network') ?>.php?size=leaderboard&campaign=<?= $this->get('ad_campaign') ?>';
		        </script>
		        <iframe id="ad_inject" src="" scrolling="no" frameborder="0"></iframe>
		    </div>
		<? endif; ?>
	<? endif; ?>

<!-- END Leaderboard Ad Block -->

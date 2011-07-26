<?php
include_once DIR_CLASSES . 'user.class.php';
include_once DIR_CLASSES . 'locator.class.php';

if (!$this->get('ad_network')) {
    $this->set('ad_network', 'doubleclick');
}

try {
	// this observer is brought to you by the letter "O"...
	$o = $this->controller->getObserver();
	// if we even have a request and an id...
	
	$l = new Locator($o);
	
	if ($o->exists('request') && $o->get('request')->exists('id')) {
		$forum_id = intval($this->controller->getObserver()->get('request')->get('id'));
		unset($o);
	}
	// if we don't, then set up to display nothing...
	else {
		$forum_id = 0;
	}
	// see if we need to show something here...
	if ( SC::exists('board_config.ad_display_forums') && strlen(SC::get('board_config.ad_display_forums')) > 0 ) {
		$params = explode(";", SC::get('board_config.ad_display_forums'));
		foreach($params as $id => $param) {
			if (empty($param)) { continue; } // throw away empty rows...
			$section = substr($param, 0, strpos($param, "(")); // get the main section name...
			if ( $l->location == $section ) { // if we matched sections, get the sub-section directives, otherwise skip it...
				$sub = array();
				$matches = ereg('\([^\(\)]*\)', $param, $sub);
				$ad_params = explode(",", str_replace(array('(',')'), NULL, $sub[0]));
			}
		}
		// process section directives...
		foreach($ad_params as $param) {
			if ( empty($param) ) { continue; } // skip past empty directives; nothing should display for those!
			if (strpos($param,'*') !== FALSE) { $ad_display_forums[intval(substr($param, 1))] = 'NETWORK'; }
			else { $ad_display_forums[intval($param)] = 'INTERNAL'; }
		}
		// handle empty section directives; use for when we want a whole section to be empty...
		if (isset($ad_display_forums) && is_array($ad_display_forums)) { $ad_forums = array_keys($ad_display_forums); }
		else { 
			$ad_display_forums = array(); 
			$ad_forums = array(); 
			}
	}
	else { 
		$ad_display_forums = array(); 
		$ad_forums = array();
		}
}
catch (Exception $e) {
	// nothing...just keep going if this doesn't work..
}

?>

<!-- START Penthouse Ad Block -->
<? if ( in_array($forum_id, $ad_forums) || isset($ad_display_forums[0]) ) : ?>
	<? // set the correct display mode so that the default, if present, doesn't override per-section settings...
	$mode = 'INTERNAL'; // always prefer our own ads...
	if ( in_array($forum_id, $ad_forums) ) { $mode = $ad_display_forums[$forum_id]; }
	else { $mode = $ad_display_forums[0]; }
	?>
	<div class="penthouse">
	<? if ( $mode == 'INTERNAL' ) : ?>
		<? $this->render('Forum.InternalAd'); ?>
	<? else : ?>
		<span style="font-size: 10px" class="accessAid">ADVERTISEMENT</span>
    	<script type="text/javascript">
		    <? if (SC::get('ads.blue_lithium.show')) : ?>
		        var ad_inject2 = 'http://media.adrevolver.com/adrevolver/banner?place=12706&cpy=<?=mt_rand(1, 9999)?>';
		    <? else : ?>
				var t = <?=time()?>;
		        var ad_inject2 = 'http://<?= MAIN_SERVER ?>/advertise/google.php?size=penthouse&campaign=<?= $this->get('ad_campaign') ?>';
		    <? endif; ?>
	    </script>
	    <iframe id="ad_inject2" src="" scrolling="no" frameborder="0"></iframe>
	<? endif; ?>
	</div>
<? endif; ?>
<!-- END Penthouse Ad Block -->

<!-- START Skyscraper Ad Block -->
<div class="skyscraper">
    <span style="font-size: 10px" class="accessAid">Advertisement</span>
    <script type="text/javascript">
  
	    <? if (User::isDonator()) : ?>
	        var ad_inject = '<?= $this->generateURL('Advertise.Main', array('size' => 'skyscraper')) ?>';
	    <? elseif (SC::get('ads.blue_lithium.show')) : ?>
	        var ad_inject = 'http://media.adrevolver.com/adrevolver/banner?place=12706&cpy=<?=mt_rand(1, 9999)?>';
	    <? else : ?>
			<? if ($this->get('ad_network') == 'doubleclick') : ?>
				var ad_inject = 'http://<?= MAIN_SERVER ?>/advertise/doubleclick.php?size=skyscraper&campaign=<?= $this->get('ad_campaign') ?>&t=<?= $this->get('ad_type') ?>&s=<?= $this->get('ad_site') ?>&z=<?= $this->get('ad_zone') ?>&a=<?= $this->get('ad_age') ?>&g=<?= $this->get('ad_gender') ?>&o=<?= $this->get('ad_bc_time') ?>';
			<? else : ?>  
		        var ad_inject = 'http://<?= MAIN_SERVER ?>/advertise/<?= $this->get('ad_network') ?>.php?size=skyscraper&campaign=<?= $this->get('ad_campaign') ?>';
			<? endif; ?>
	    <? endif; ?>

    </script>
    <iframe id="ad_inject" src="" scrolling="no" frameborder="0"></iframe>
</div>
<!-- END Skyscraper Ad Block -->

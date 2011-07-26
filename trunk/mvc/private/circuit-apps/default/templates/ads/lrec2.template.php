 <?php
include_once DIR_CLASSES . 'user.class.php';

// &keyword=<?= $this->get('ad_keyword')

?>

<!-- START LREC Ad Block -->
<div id="grid_ad2" class="lrec">
    <span class="accessAid">Advertisement</span>
    <script type="text/javascript">

		<? if (User::isDonator()) : ?>
	    	var ad_inject2 = '<?= $this->generateURL('Advertise.Main', array('size' => 'lrec')) ?>';
		<? else : ?>
			<? if ($this->get('ad_network') == 'doubleclick') : ?>
				var ad_inject2 = 'http://<?= MAIN_SERVER ?>/advertise/doubleclick.php?size=lrec&campaign=<?= $this->get('ad_campaign') ?>&t=<?= $this->get('ad_type') ?>&s=<?= $this->get('ad_site') ?>&z=<?= $this->get('ad_zone') ?>&a=<?= $this->get('ad_age') ?>&g=<?= $this->get('ad_gender') ?>&o=<?= $this->get('ad_bc_time') ?>';
			<? else : ?>
		        var ad_inject2 = 'http://<?= MAIN_SERVER ?>/advertise/<?= $this->get('ad_network') ?>.php?size=lrec&campaign=<?= $this->get('ad_campaign') ?>';
	        <? endif; ?>		
		<? endif; ?>
		
    </script>
    <iframe width="320" height="250" id="ad_inject2" src="" scrolling="no" frameborder="0"></iframe>
</div>
<!-- END LREC Ad Block -->
 
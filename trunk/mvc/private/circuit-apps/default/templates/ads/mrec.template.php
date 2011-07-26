<?php
include_once DIR_CLASSES . 'user.class.php';
if (!$this->get('ad_network')) {
    $this->set('ad_network', 'doubleclick');
}
?>

<!-- START MREC Ad Block -->
<? if ($this->get('ad_site') == 'gaia.home' && ! User::isDonator()) : ?>
	<div id="grid_ad" class="mrec">
		<p style="font-size: 10px; margin:0;" class="accessAid">ADVERTISEMENT</p>
		<script language=Javascript1.1 src="http://ad.doubleclick.net/N5243/adj/gaia.home/home;ag=<?= $this->get('ad_age') ?>;gd=<?= $this->get('ad_gender') ?>;dn=0;tile=1;sz=300x250;ord=<?= $this->get('ad_bc_time') ?>"></script>
		<noscript>
            <a href='http://ad.doubleclick.net/N5243/jump/gaia.home/home;ag=<?= $this->get('ad_age') ?>;gd=<?= $this->get('ad_gender') ?>;dn=0;tile=1;sz=300x250;ord=<?= $this->get('ad_bc_time') ?>'>
				<img src='http://ad.doubleclick.net/N5243/ad/gaia.home/home;ag=<?= $this->get('ad_age') ?>;gd=<?= $this->get('ad_gender') ?>;dn=0;tile=1;sz=300x250;ord=<?= $this->get('ad_bc_time') ?>' width='300' height='250' border='0' alt='Click Here!'>
			</a>
		</noscript>
	</div>
<? else : ?>
	<div id="grid_ad" class="mrec">
	    <p style="font-size: 10px; margin: 0;" class="accessAid">ADVERTISEMENT</p>
	    <script type="text/javascript">
			<? if (User::isDonator()) : ?>
		    	var ad_inject = '<?= $this->generateURL('Advertise.Main', array('size' => 'lrec')) ?>';
			<? else : ?>
				<? if ($this->get('ad_network') == 'doubleclick') : ?>
					var ad_inject = 'http://<?= MAIN_SERVER ?>/advertise/doubleclick.php?size=lrec&campaign=<?= $this->get('ad_campaign') ?>&t=<?= $this->get('ad_type') ?>&s=<?= $this->get('ad_site') ?>&z=<?= $this->get('ad_zone') ?>&a=<?= $this->get('ad_age') ?>&g=<?= $this->get('ad_gender') ?>&o=<?= $this->get('ad_bc_time') ?>';
				<? else : ?>
			        var ad_inject = 'http://<?= MAIN_SERVER ?>/advertise/<?= $this->get('ad_network') ?>.php?size=lrec&campaign=<?= $this->get('ad_campaign') ?>';
		        <? endif; ?>		
			<? endif; ?>
			
	    </script>
	    <iframe id="ad_inject" width="320" height="250" id="ad_inject" src="" scrolling="no" frameborder="0"></iframe>
	</div>
<!-- END MREC Ad Block -->
<? endif; ?>

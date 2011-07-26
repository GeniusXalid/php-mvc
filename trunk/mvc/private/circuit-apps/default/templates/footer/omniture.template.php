<?php
/* for dev testing */
if (SC::isEmpty('board_config.omniture_enable')) {
    return;
}

$pageName = SC::get('omniture.pageName');
$channel  = SC::get('omniture.channel');

if (SC::get('userdata.session_logged_in')) {

    $gender       = SC::get('userdata.user_gender');
    $user_id      = sprintf("%013d", SC::get('userdata.user_id'));
    $orig_user_id = SC::get('userdata.user_id');
    $reg_date     = SC::get('userdata.user_regdate');

    // Calculate age
    $date = realdate('m d Y', SC::get('userdata.user_birthday'));
    list($month, $day, $year) = explode(' ', $date);
    $now = getdate(SC::get('board_config.time_now'));
    $age = abs($now['year'] - $year);
    /* birthday hasn't passed; age - 1 */
    if ($month < $now['mon']) {
        $age--;
    }
    elseif ($month == $now['mon']) {
        /* not on/past the actual day yet; age - 1 */
        if ($day < $now['mday']) {
            $age--;
        }
    }

    // Calculate donation string
    if (SC::isEmpty('userdata.user_donate_time')) {
        $donated = 'did not donate';        
    }
    else {
        $donated = ((SC::get('board_config.time_now') - SC::get('userdata.user_donate_time')) <= 2678400)
            ? 'donated'
            : 'did not donate';
    }
    
}
else {

    $age = $gender = $reg_date = $user_id = $donated = 'not registered';
    $orig_user_id = -1;
    
}

$gold_granted = FALSE;

/* check for gold grant */
if (($gold_amount = SC::get('goldinfo')) != NULL) {
    $gold_granted = TRUE;
}
elseif (($gold_amount = session_get('goldinfo')) != NULL) {
    session_remove('goldinfo');
    $gold_granted = TRUE;
}

$events = $products = '';
$evars = $evar1 = $evar7 = '';

if ($gold_granted) {
    $gold_amount = preg_replace('/^.+?\b(\d+) gold.+$/', '$1', $gold_amount['message']);
    
    $events = "event5";
    $products="virtual;gold grant;;;event5=$gold_amount";
}

$omniture =& SC::get('omniture');

// Registration events
if ($omniture && array_key_exists('event', $omniture)) {
    if (!empty($events)) {
        $events .= ',';
    }
    $events .= $omniture['event'];
}



$shops = ($omniture && array_key_exists('shops', $omniture)) ? $omniture['shops'] : null;
if ($shops) {
    $pageName .= " - purchase";
    $evar1 = "s.eVar1=\"{$shops['name']}\";";
    
    $store_item = $shops['item'];
    $store_quantity = $shops['quantity'];
}

if ($shops && array_key_exists('goldPurchase', $shops)) {
    if (! empty($events)) {
        $events .= ',';
        $products .= ',';
    }
    
    $gold_amount = $shops['goldPurchase'];
    $events .= 'event2';
    $products .= "store purchase;{$store_item};{$store_quantity};;event2=$gold_amount";
}

if ($shops && array_key_exists('creditPurchase', $shops)) {
    if (! empty($events)) {
        $events .= ',';
        $products .= ',';
    }
    
    $credit_amount = $shops['creditPurchase'];
    $events .= 'event3';
    $products .= "store purchase;{$store_item};{$store_quantity};;event3=$credit_amount";
}

/**
 * this is so that we can get a unique count (by user id) of how many users visit a certain page
 * for example: how many user bid in the marketplace (not how many bids)
 **/
$pageCount = $omniture && array_key_exists('pageCount', $omniture) ? $omniture['pageCount'] : null;
if ($pageCount && $pageCount == 'user_id') {
    if (! empty($events)) {
        $events .= ',';
    }
    
    $events .= sprintf("event6:{$orig_user_id}%4d%02d%02d", $now['year'], $now['mon'], $now['mday']);
    $evar7 = "s.eVar7=\"{$pageName}\";";
}

if ($pageCount && $pageCount == 'pageView') {
    $pv_events = SC::get('omniture.pv_events');
    foreach(array_keys($pv_events) as $event_id) {
        if (! empty($events)) {
            $events .= ',';
        }
        
        $events .= $event_id;
    }
    
    $evar7 = 's.eVar7="' . $pageName . '";';
    
    if (array_key_exists('pageCount_name', $omniture)) {
        $evar1_value = $omniture['pageCount_name'];
        $evar1 = 's.eVar1="' . $evar1_value . '";';
    }
}

if (! empty($events)) {
    $events = 's.events="' . $events . '";';
    
    $evars = 's.eVar3="' . $user_id . '";s.eVar4="' . $age . '";s.eVar5="' . $gender . '";s.eVar6="' . $params['reg_date'] . '";';
    $evars .= $evar1 . $evar7;
}

if (! empty($products)) {
    $products = 's.products="' . $products . '";';
}

$campaign = '';
$campaign_id = $omniture && array_key_exists('campaign', $omniture) ? $omniture['campaign'] : null;

if ($campaign_id != null) {
    $campaign = 's.campaign="' . $campaign_id . '";';
}

?>

/* and the tracking javascript */
<!-- SiteCatalyst code version: H.7.
     Copyright 1997-2006 Omniture, Inc. More info available at http://www.omniture.com
-->
<script language="JavaScript"><!--
s.pageName = "<?= $pageName ?>";s.channel="<?= $channel ?>";
s.prop1    = "<?= $user_id ?>";
s.prop2    = "<?= $age ?>";
s.prop3    = "<?= $gender ?>";
s.prop4    = "<?= $reg_date ?>";
s.prop5    = "<?= $donated ?>";

<?= $evars . $campaign . $events . $products ?>

/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code = s.t();
if (s_code) document.write(s_code);
//-->
</script>
<script type="text/javscript"><!--
if (navigator.appVersion.indexOf('MSIE') >= 0)
    document.write(unescape('%3C')+'\!-'+'-');
//--></script>
<!--/DO NOT REMOVE/-->
<!-- End SiteCatalyst code version: H.7. -->

<? if ($omniture && array_key_exists('mtv_hills', $omniture)) : $mtv_prop1 = array_key_exists('mtv_prop1', $omniture) ? $omniture['mtv_prop1'] : 'Html'; ?>
    <script type="text/javascript">
    com.mtvi.reporting.Account={
        name:'viagaiaworlds',
        dynamicAccountSelection:'true',
        dynamicAccountList:'viagaiaworlds=mtv-d,mtv-q'
    };
    
    try{
        var pageName=location.pathname;
        var dispatcher=new com.mtvi.reporting.Dispatcher();
        dispatcher.setDefaultData();
        dispatcher.setAttribute('pageName', '<?= $pageName ?>');
        dispatcher.setAttribute('prop1','<?= $mtv_prop1 ?>');
        dispatcher.setAttribute('prop2', '<?= $pageName ?>');
        dispatcher.setAttribute('hier1', pageName);
        dispatcher.send();
    }
    catch(e) {
        // Do nothing
    }
    </script>
<? endif; ?>

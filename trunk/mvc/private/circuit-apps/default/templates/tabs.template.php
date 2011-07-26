<?
$tabs = $this->get('tabs');
if (!$tabs['id']) {
    $tabs['id'] = 'default_tabs_0';
}

?>

<div<?if(!empty($tabs['id'])):?> id="<?= $tabs['id'] ?>"<? endif; ?> class="gaia_tab_menu_structure gaia_navigation_tabs<?if(!empty($tabs['class'])):?><?= ' '.$tabs['class'] ?><? endif; ?>">

<? $tab_count = 1; $tab_class = ''; ?>
<? foreach($tabs['tabs'] as $tab) : ?>
<?
if ($tab_count == count($tabs['tabs'])) {
    $tab_class = ' last_tab';
}
else {
    $tab_count++;
}
?>
<div <? if (!empty($tab['id'])): ?>id="<?= $tab['id'] ?>"<? endif; ?> class="tab<? if ($tabs['selected'] == $tab['id']):?> current_tab<?endif;?><?=$tab_class?><? if (!empty($tab['class'])): ?> <?= ' '.$tab['class'] ?><? endif; ?><? if (!empty($tab['subnav'])): ?> tab_withsubnav<? endif; ?>"><a class="link<? if (!empty($tab['anchor_class'])): ?> <?= ' '.$tab['anchor_class'] ?><? endif; ?>" href="<?= $tab['url'] ?>"<? if (!empty($tab['anchor_title'])): ?> title="<?=$tab['anchor_title']?>"<? endif; ?>><?= $tab['text'] ?></a>

<? if (!empty($tab['subnav'])): ?>
    <div <? if (!empty($tab['subnav']['id'])): ?>id="<?= $tab['subnav']['id'] ?>"<? endif; ?> class="yuimenu<? if (!empty($tab['subnav']['class'])): ?> <?= ' '.$tab['subnav']['class'] ?><? endif; ?>">
        <div class="bd">
            <ul>
                <? $count = 0; $length = count($tab['subnav']['tabs'])-1;?>
                <? foreach($tab['subnav']['tabs'] as $subtab) : ?>
                    <? $class = 'yuimenuitem' . (!$count ? ' first' : (($count == $length) ? ' last' : ''));
                        ++$count;
                        if (!empty($subtab['class'])) {
                            $class .= (' ' . $subtab['class']);
                        }
                    ?>
                    <li class="<?= $class ?>"><a href="<?= $subtab['url'] ?>" class="yuimenuitemlabel<? if (!empty($subtab['anchor_class'])): ?> <?= ' '.$subtab['anchor_class'] ?><? endif; ?>"<? if (!empty($subtab['anchor_title'])): ?> title="<?=$subtab['anchor_title']?>"<? endif; ?>><?= $subtab['text'] ?></a></li>
                <? endforeach; ?>
			</ul>
		</div>
	</div>
<? endif; ?>
</div>
<? endforeach; ?>
<div class="tab_end">&nbsp;</div>
<? if (!empty($tabs['orphans'])): ?>
	<ul class="gaia_tab_orphans">
    <?
    // need to reverse the order since the li's are floated right
    $orphan_len = count($tabs['orphans']);
    $orphans = array_reverse($tabs['orphans']); ?>
	<? foreach($orphans as $index => $orphan) : ?>
		<li <? if (!empty($orphan['id'])): ?> id="<?=$orphan['id']?>"<? endif; ?> class="yuimenuitem tab"><a class="yuimenuitemlabel<? if (!empty($orphan['class'])): ?><?= ' ' .$orphan['class']?><? endif; ?>" href="<?=$orphan['url']?>"><?=$orphan['text']?></a><?
           if (!empty($orphan['subnav'])): ?>
          <div <? if (!empty($orphan['subnav']['id'])): ?>id="<?= $orphan['subnav']['id'] ?>"<? endif; ?> class="yuimenu<? if (!empty($orphan['subnav']['class'])): ?> <?= ' '.$orphan['subnav']['class'] ?><? endif; ?>">
            <div class="bd">
              <ul>
              <? $count = 0; $length = count($orphan['subnav']['tabs'])-1;?>
                <? foreach($orphan['subnav']['tabs'] as $subtab) : ?>
                    <? $class = 'yuimenuitem' . (!$count ? ' first' : (($count == $length) ? ' last' : ''));
                        ++$count;
                        if (!empty($subtab['class'])) {
                            $class .= (' ' . $subtab['class']);
                        }
                    ?>
                    <li class="<?= $class ?>"><a href="<?= $subtab['url'] ?>" class="yuimenuitemlabel<? if (!empty($subtab['anchor_class'])): ?> <?= ' '.$subtab['anchor_class'] ?><? endif; ?>"<? if (!empty($subtab['anchor_title'])): ?> title="<?=$subtab['anchor_title']?>"<? endif; ?>><?= $subtab['text'] ?></a></li>
                <? endforeach; ?>
              </ul>
            </div>
          </div>  
        <? endif; ?>
        </li>
        <? if ($index != $orphan_len - 1): ?>
        <li class="seperator">&#124;</li>
        <? endif; ?>
        <p class="clear"></p>
	<? endforeach; ?>
	</ul>
<? endif; ?>
<? 
/**
 * This span is necessary to correct a bug wrt IE hiding a 
 * relatively-positioned parent that has floated children. 
 * http://www.satzansatz.de/cssd/rpfloat.html
 * God bless IE. 
 */
?>
<span>&nbsp;</span>
<div class="clear"></div>
</div>

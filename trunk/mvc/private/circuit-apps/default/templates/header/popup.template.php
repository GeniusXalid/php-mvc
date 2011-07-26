<?php
$layout = $this->getLayoutConfig();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?= $layout->get('page_title') ?> :: Gaia Online</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="Content-Language" content="en-us" />

<script type="text/javascript">
// return a config setting. Useful for getting PHP constants
// into a javascript application
function GAIA_config(item) {
    switch (item.toLowerCase()) {
        case 'main_server': return '<?= MAIN_SERVER ?>';
        case 'graphics_server': return '<?= GRAPHICS_SERVER ?>';
        case 'jscompiler_server': return '<?= JSCOMPILER_SERVER ?>';
        case 'no_image': return 'http://<?= GRAPHICS_SERVER ?>/images/s.gif';
        case 'avatar_server': return '<?= AVATAR_SERVER ?>';
        case 'town_name': return '<?= LYT_TOWN_NAME ?>';
        case 'session_page': return '<?= SESSION_PAGE_ID ?>';
        case 'cache_value': return '<?= LYT_MASTER_CACHEBUST ?>';
        default: return null;
    }
}
</script>

<!-- yahoo libraries -->
<link href="http://<?= GRAPHICS_SERVER ?>/src/yui/container/assets/container.css" rel="stylesheet" type="text/css" media="screen" />
<link href="http://<?= GRAPHICS_SERVER ?>/src/css/core.css" rel="stylesheet" type="text/css" media="screen" />
<!--[if IE 6]>
<link href="http://<?= GRAPHICS_SERVER ?>/src/css/core_ie6.css" rel="stylesheet" type="text/css" media="screen" />
<![endif]-->
<!--[if IE 7]>
<link href="http://<?= GRAPHICS_SERVER ?>/src/css/core_ie7.css" rel="stylesheet" type="text/css" media="screen" />
<![endif]-->

<script type="text/javascript" src="http://<?= JSCOMPILER_SERVER ?>/src/_/<?= $layout->get('master_cachebuster') ?>/pkg-gaia_core.js"></script>
<? if ($layout->get('enable_debug')) : ?>
    <!-- Yahoo logger libraries -->
    <link href="http://<?= GRAPHICS_SERVER ?>/src/yui/logger/assets/logger.css?<?= $layout->get('yui_version') ?>" rel="stylesheet" type="text/css" media="screen"/>
    <script type="text/javascript" src="http://<?= GRAPHICS_SERVER ?>/src/yui/logger/logger-min.js?<?= $layout->get('yui_version') ?>"></script>
<? endif; ?>

<!-- BEGIN application stylesheets -->
<? if (!$layout->isEmpty('css')) : ?>
    <? foreach ($layout->get('css') as $css) : ?>
        <link rel="stylesheet" href="http://<?= GRAPHICS_SERVER . $css['path'] ?>?<?= $layout->get('app_cachebuster') ?>" type="text/css" media="<?= $css['media'] ?>" />    
    <? endforeach; ?>
<? endif; ?>
<!-- END application stylesheets -->

<!-- BEGIN application scripts -->
<? if (!$layout->isEmpty('scripts')) : ?>
    <? foreach ($layout->get('scripts') as $script) : ?>
        <script src="http://<?= GRAPHICS_SERVER . $script ?>?<?= $layout->get('app_cachebuster') ?>" type="text/javascript" />    
    <? endforeach; ?>
<? endif; ?>
<!-- END application stylesheets -->

</head>
<body class="popup">

<div id="gaia_header">
    <h1>Gaia Online</h1>
</div>
<div id="gaia_content">
    <div id="page_header">
        <h2><?= $layout->get('page_title') ?></h2>
    </div>
    <div class="bd">

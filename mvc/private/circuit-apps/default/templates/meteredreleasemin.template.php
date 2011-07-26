<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?=$this->get('title'); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="en-us" />

<!-- yahoo libraries -->
<link href="http://<?= GRAPHICS_SERVER ?>/src/yui/grids/grids-min.css" rel="stylesheet" type="text/css" media="screen" />
<!-- end yahoo libraries -->

<link href="http://<?= GRAPHICS_SERVER ?>/src/css/core.css" rel="stylesheet" type="text/css" media="screen" />
<!--[if IE 6]>
<link href="http://<?= GRAPHICS_SERVER ?>/src/css/core_ie6.css" rel="stylesheet" type="text/css" media="screen" />
<![endif]-->
<!--[if IE 7]>
<link href="http://<?= GRAPHICS_SERVER ?>/src/css/core_ie7.css" rel="stylesheet" type="text/css" media="screen" />
<![endif]-->
<style>
h1 {
    width: 100%;
    height: 57px;
    background: #5f5264 url(http://<?= GRAPHICS_SERVER ?>/images/gaia_global/gaia_header/br_gaia_logo_header.png) left top no-repeat;
    border-bottom: 1px solid #000;
}
#gaia_content #bd { 
    width: 100%;
}
#gaia_content #bd #yui-main .yui-gc .yui-u {
    padding: 0 0.3em 0 0.3em;
}
</style>
</head>
<body>
<h1><span class="accessAid">Gaia Online</span></h1>
<div class="content">
<div id="gaia_content">
    <div id="bd">
        <div class="grid_rc_container_top">
            <div class="rc_top_left"></div>
            <div class="rc_top_right"></div>
        </div>
        <div id="yui-main">
            <div class="yui-gc">
                <div class="yui-u first last">
                    <? $this->render('Default.MeteredRelease'); ?>
                </div>
            </div>
        </div>
        <div class="grid_rc_container_bottom">
            <div class="rc_bottom_left"></div>
            <div class="rc_bottom_right"></div>
        </div>
    </div>
</div>
</div>
</body>
</html>
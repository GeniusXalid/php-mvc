<?php
$layout = $this->getLayoutConfig();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?= $layout->get('page_title') ?> | 盖亚星空</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="Content-Language" content="en-us" />
<? if (!$layout->isEmpty('meta')) : ?>
    <? foreach ($layout->get('meta') as $meta) : ?>
        <meta http-equiv="<?= $meta['http_equiv'] ?>" content="<?= $meta['content'] ?>" />
    <? endforeach; ?>
<? endif; ?>

<script type="text/javascript">
// Returns a config setting. Useful for getting PHP constants into javascript
function GAIA_config(item) {
    switch (item.toLowerCase()) {
        case 'main_server'       : return '<?= MAIN_SERVER ?>';
        case 'graphics_server'   : return '<?= GRAPHICS_SERVER ?>';
        case 'jscompiler_server' : return '<?= JSCOMPILER_SERVER ?>';
        case 'no_image'          : return 'http://<?= GRAPHICS_SERVER ?>/images/s.gif';
        case 'avatar_server'     : return '<?= AVATAR_SERVER ?>';
        case 'town_name'         : return '<?= LYT_TOWN_NAME ?>';
        case 'session_page'      : return '<?= SESSION_PAGE_ID ?>';
        case 'cache_value'       : return '<?= LYT_MASTER_CACHEBUST ?>';
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

<!-- BEGIN application scripts -->
<? if (!$layout->isEmpty('scripts')) : ?>
    <? foreach ($layout->get('scripts') as $script) : ?>
        <? if (strpos('http://', $script) === FALSE) : ?>
            <script src="http://<?= GRAPHICS_SERVER . $script ?>?<?= $layout->get('app_cachebuster') ?>" type="text/javascript"></script>
        <? else : ?>
            <script src="<?= $script ?>" type="text/javascript"></script>
        <? endif; ?>
    <? endforeach; ?>
<? endif; ?>
<!-- END application scripts -->

<!-- BEGIN application stylesheets -->
<? if (!$layout->isEmpty('css')) : ?>
    <? foreach ($layout->get('css') as $css) : ?>
        <link rel="stylesheet" href="http://<?= GRAPHICS_SERVER . $css['path'] ?>?<?= $layout->get('app_cachebuster') ?>" type="text/css" media="<?= $css['media'] ?>" />    
    <? endforeach; ?>
<? endif; ?>
<!-- END application stylesheets -->

<!-- BEGIN IE6 stylesheets -->
<!--[if IE 6]>
<? if (!$layout->isEmpty('css_ie6')) : ?>
    <? foreach ($layout->get('css_ie6') as $css) : ?>
        <link rel="stylesheet" href="http://<?= GRAPHICS_SERVER . $css['path'] ?>?<?= $layout->get('app_cachebuster') ?>" type="text/css" media="<?= $css['media'] ?>" />
    <? endforeach; ?>
<? endif; ?>
<![endif]-->
<!-- END IE6 stylesheets -->

<!-- BEGIN IE7 stylesheets -->
<!--[if IE 7]>
<? if (!$layout->isEmpty('css_ie7')) : ?>
    <? foreach ($layout->get('css_ie7') as $css) : ?>
        <link rel="stylesheet" href="http://<?= GRAPHICS_SERVER . $css['path'] ?>?<?= $layout->get('app_cachebuster') ?>" type="text/css" media="<?= $css['media'] ?>" />
    <? endforeach; ?>
<? endif; ?>
<![endif]-->
<!-- END IE7 stylesheets -->
<style type="text/css">
body,h1,h2,h3,h4,h5,h6,hr,p,blockquote,dl,dt,dd,ul,ol,li,pre,form,fieldset,legend,button,input,textarea,th,td{margin:0;padding:0}
body,button,input,select,textarea{font:12px/1.3 Tahoma,Helvetica,Arial,"\5b8b\4f53",sans-serif}
h1{font-size:18px}
h2{font-size:16px}
h3{font-size:14px}
h4,h5,h6{font-size:100%}
ul,ol{list-style:none}
img,fieldset{border:none}
button,input,select,textarea{font-size:100%}

/* 临时 */
#header {text-align:left;position:relative;z-index:2;height:auto;}
#header .header-body{margin:0 auto;width:980px;height:158px;background:#000 url(/images/landingimages/bg_banner_mygaia_before_login.jpg) no-repeat center top;}
#header .logo{float:left;padding:10px 0 0 30px;}

/* 未登录 */
#header .login{float:right;color:#fff;}
#header .login .login-form{position:relative;float:left;padding-top:20px;width:180px;}
#header .login .login-form label{display:block;}
#header .login .login-form .input{margin:2px 0 5px;padding:2px 0 0 3px;width:173px;height:17px;font-weight:bold;background:url(/images/landingimages/index-map.png) no-repeat -68px -84px;}
#header .login .login-form .checkbox{padding-right:2px;vertical-align:middle;}
#header .login .login-form .submit{display:block;position:absolute;right:0px;bottom:5px;color:#fff;border:none;width:79px;height:26px;background:url(/images/landingimages/index-map.png) no-repeat -68px 0;cursor:pointer;padding-top:0px;*padding-top:2px;_padding-top:2px;}
#header .login .login-form .dl{height:26px;line-height:26px;}
#header .login .login-form .pw{padding:3px 0;}
#header .login .login-form a,.login .login-form a:visited{text-decoration:underline;color:#fff;}
#header .login .register{float:left;display:block;padding:3px 3px 0 0;}

/* 登录后 */

#header .welcome{float:right;padding-right:30px;color:#fff;text-align:left;height:158px;}
#header .welcome .user{float:left;display:block;background:url(/images/landingimages/user-bg.png) no-repeat center bottom;height:158px;}
#header .welcome .user img{max-height:150px;}
/*  
#header .welcome{float:right;padding-right:30px;color:#fff;}
#header .welcome .user{float:left;display:block;background:url(/images/landingimages/user-bg.png) no-repeat center bottom;height:160px;}
#header .welcome .user img{max-height:160px;}
*/
#header .welcome .home{position:relative;float:left;padding-top:8px;width:223px;line-height:1;}
#header .welcome .hi{padding:22px 0 0 15px;height:37px;background:url(/images/landingimages/hi.png) no-repeat;}
#header .welcome .hi a{color:#fff;text-decoration:underline;}
#header .welcome .hi span{padding-right:10px;color:#ffde00;}
#header .welcome .exit{position:absolute;top:68px;right:15px;display:block;color:#d2d2d2;text-decoration:underline;padding-top:1px;}
#header .welcome .homepage{position:absolute;height:30px;width:30px;top:20px;right:12px;display:block;color:#d2d2d2;z-index:2;}
#header .welcome .homepage .undis{display:none;}
#header .welcome .a2{display:block;width:188px;height:8px;background:url(/images/landingimages/12.jpg) no-repeat;}
#header .welcome .bt1{display:block;width:188px;height:8px;background:url(/images/landingimages/index-map.png) no-repeat 0 -307px;}
#header .welcome .bt{display:block;width:188px;height:7px;background:url(/images/landingimages/box.png) no-repeat -6000px 0;}
#header .welcome .msg-body{position:absolute;top:63px;}
#header .welcome .msg{padding:10px 0 0 10px;width:184px;background:url(/images/landingimages/index-map.png) no-repeat -68px -106px;min-height:34px;height:auto !important;height:34px;}
#header .welcome .msg li{padding-left:18px;line-height:17px;background:url(/images/landingimages/index-map.png) no-repeat 0 -398px;width:130px;-o-text-overflow:ellipsis;text-overflow:ellipsis;white-space:nowrap;overflow:hidden;}
#header .welcome .msg li a{text-decoration:none;color:#fff;}

/* menu */
#header #nav .main_panel_container{width:300px;padding:13px 0 10px 20px;display:none;position:absolute;z-index:100;border:1px solid #0A3681;background:#81BADE;top:27px;left:0; opacity:0.9;-moz-opacity:0.9;filter:alpha(opacity:90);}
#header .charge-form,
#header .charge-form a{line-height:30px;}
#header #nav{height:30px;overflow:hidden;}
#header #nav .main_panel_container .top-line{margin:0 12px 5px -10px;border-top:1px solid #d1c2ff;border-bottom:1px solid #000;}
#header #nav .main_panel_container li{float:left;width:93px;padding:0 0 5px 37px;}
#header #nav .main_panel_container li span.ico{display:block;padding:0;position:absolute;width:31px;height:31px;left:0;top:0;overflow:hidden;background:transparent url(/images/landingimages/icoall_main_menu.png);background-repeat:no-repeat;}
#header #mainMenu #myprofile span.ico{}
#header #mainMenu #journal span.ico{background-position:-31px 0;}
#header #mainMenu #avatar span.ico{background-position:-62px 0;}
#header #mainMenu #info span.ico{background-position:-93px 0;}
#header #mainMenu #inventory span.ico{background-position:-124px 0;}
#header #mainMenu #message span.ico{background-position:-155px 0;}
#header #mainMenu #friend span.ico{background-position:-186px 0;}
#header #nav li:hover .main_panel_container,
#header #nav li.panel-open .main_panel_container{display:block;}
#header #nav li.standard:hover a.header:hover,
#header #nav li.panel-open a.header{height:30px;background:#82B5C0;margin:-2px 0 0;border-bottom:none;}
#header .header .button-left{display:block;width:12px;height:29px;float:left;padding:0;background:none;}
#header .header .button-right{display:block;float:left;padding:0 12px 0 0;background:none;}
#header #nav li:hover .header .button-left,
#header .panel-open .header .button-left{display:block;width:12px;height:29px;float:left;padding:0;background:url(../images/menu322x29.jpg) left top no-repeat;}
#header #nav li:hover .header .button-right,
#header .panel-open .header .button-right{display:block;float:left;padding:0 12px 0 0;background:url(../images/menu322x29.jpg) right top no-repeat;}

#header .menu{height:30px;width:980px;position:relative;margin:0 auto;background:url(/images/landingimages/index-map.png) repeat-x 0 -323px;zoom:1;} 
#header .menu em,.menu strong,.menu span{background:url(/images/landingimages/index-map.png) no-repeat;display:block;float:left;}
#header .menu .nav{float:left;padding-left:40px;}
#header .menu .nav li{float:left;display:block;position:relative;height:30px;padding:0 8px;}
#header .menu .nav li.standard{padding-right:2px;background:url(/images/landingimages/index-map.png) no-repeat right 0;}
#header .menu .nav li.panel-open{z-index:2;}

#header .menu .nav .selected{background:url(/images/landingimages/index-map8.png) no-repeat;}

#header .menu .nav .first a{padding:7px 0px 7px 26px;_padding:0 0px 0 26px;background:url(/images/landingimages/index-map.png);background-position:10px -359px;background-position:10px -360px\9;*background-position:10px -361px;_background-position:10px -359px;font-weight:bold;}
#header .menu .nav a{text-decoration:none;cursor:pointer;color:#fff;line-height:30px;}
#header .menu .nav a:hover{text-decoration:underline;}
/*selected*/
#header .menu .nav .selected a{font:bold 12px/30px '';color:#000;}



#header .menu .charge-form{position:absolute;left:625px;top:0px;color:#f3d051;}
#header .menu span{padding:0 10px 0 17px;background-position:0 -357px;background-position:0 -359px\9;*background-position:0 -359px;_background-position:0 -357px;}
#header .menu span a{color:#f3d051;}
#header .menu em{font-style : normal;padding:0 40px 0 17px;font-weight:bold;background-position:0 -514px;}
#header .menu strong{padding-left:17px;font-weight:bold;background-position:0 -544px;}

/* focus */
#header .focus-body{position:relative;height:325px;}
#header .focus{width:650px;padding-left:15px;}
#header .news{position:absolute;right:30px;top:0px;padding:68px 0 0 34px;width:266px;height:149px;background:url(/images/landingimages/news.png)}
#content{clear:both;_margin-top:-1px;}
.logo{width:84px;height:105px;position:relative;}
.logo a{position:absolute;width:84px;height:105px;background:url(/images/landingimages/logo.png) no-repeat;right:0;bottom:0;text-indent:-5000px;overflow:hidden;_filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/images/landingimages/logo.png');_background-image:none;}
.logo span{display:none;}

/* footer */

#footer{margin:0 auto;width:980px;text-align:left;}
#footer{line-height:20px;text-align:center;}
.copyright{padding:10px 0;}
.advice{color:#ddd;}
.about{color:#fff;}
.about a{color:#fff;text-decoration:none;}
.about a:hover{text-decoration:underline;}

</style>
</head>
</head>

<body class="bare time-day">
<!--
<script src="http://<?= GRAPHICS_SERVER; ?>/src/js/login/md5-min.js?1259644162_193939-0" type="text/javascript"/>
    	<script src="http://<?= GRAPHICS_SERVER; ?>/src/js/login/loginform.js?1259644162_193939-0" type="text/javascript"/>
    		<img height="1" width="1" alt="" src="/internal/mkt_t.php?mid=354&amp;tm=1259644162"/>
-->


<div class="gaia-headers" id="gaia_headers">
  		
    <div id="header">
    	<div class="header-body">
    		<h1 class="logo"><a href="http://<?= MAIN_SERVER; ?>"><img title="盖亚星空" alt="盖亚星空" src="/images/landingimages/logo.png"/></a></h1>

            	    
		
		          </div>
	<div class="menu">    
			<ul class="nav" id="nav"> 

				<li class="first selected" id="nav_index"><a href="/" class="png-24">主页</a></li> 
				<li id="nav_mygaia"><a href="/mygaia/">我的盖亚</a></li> 
				<li id="nav_legend"><a href="/legend/">盖亚传说</a></li> 
				<li id="nav_forum"><a href="/forum/">论坛</a></li> 
				
				<li id="nav_arena"><a href="/arena/">秀场</a></li> 
				<li id="nav_shop"><a href="/gaia/shopping.php">购物商城</a></li> 
				<li id="nav_help"><a href="/info/index.php?mode=rules">帮助</a></li> 
			</ul> 
			
     			


  </div>

</div></div></div>


<!-- main content column -->
<div id="gaia_content">

            

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!-- saved from url=(0023)http://www.udpwork.com/ -->
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>联办IT博客聚合 - 发现IT技术最优秀的内容, 寻找IT技术的价值</TITLE>
<META http-equiv=Content-Type content="text/html; charset=UTF-8">
<META content=端等技术前沿的中文博客 name=description>
<META content=IT,IT牛人,IT行业,IT牛人博客,名人博客,名博 name=keywords>
<link rel="stylesheet" type="text/css" media="all"  href="<?php bloginfo( 'stylesheet_url' ); ?>" />

<script type="text/javascript" src="<?php echo home_url( '/' );?>wp-content/themes/seecblogmvc/js/jquery-1.5.1.min.js"></script>



</HEAD>
<BODY>
<SCRIPT type=text/javascript>
<!--
function toggle_element(id){
    var e = document.getElementById(id);
    if(e.style.display == 'none'){
        e.style.display = '';
    }else{
        e.style.display = 'none';
    }
}
//-->
</SCRIPT>

<div id="header">
<div id="header_inner">
<div id="site_info">
<h1><a href="">联办IT博客聚合</a></h1>
<div style="COLOR: #ddd">发现IT技术最优秀的内容, 寻找IT技术的价值</div></div>
<ul id="header_links">
  <li><a href="/">首页</a> </li>
  <?php 
    global $userdata;
    if(empty($userdata)){
        echo ' <li><a href="/regist">注册</a> </li><li><a href="/wp-login.php">登录</a> </li>'; 
    }else{
        echo '<li><a href="http://'.$userdata->source_domain.'/wp-admin/index.php" target="_blank">'.$userdata->user_login.'</a></li><li><a href="/wp-login.php?loggedout=true">退出</a></li>';
    }
  
?>

  <li><a href="">博竹列表</a> </li>
  <li><a href="">RSS订阅</a> </li>
  <li><a href="">关于</a> </li>
  
  </ul></div></div>
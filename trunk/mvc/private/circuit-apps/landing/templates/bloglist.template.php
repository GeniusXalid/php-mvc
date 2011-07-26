<?php  
   $r = $this->getRequest();
   $new_data=$r->get("newblog");
?>
<div id="main_wrapper">
<div id="banner" class="big_box">
<div class="top"></div>
<div class="inner">找到你所找, 得到你所想 - <a
    href="">注意那个评论气泡</a>
<div style="CLEAR: both"></div>
</div>
<!-- /.inner -->
<div class="bottom"></div>
</div>
<!-- /.big_box -->
<div id="main" class="big_box">
<div class="top"></div>
<div class="inner">
<div id="content">
<div style="FONT-WEIGHT: bold; FONT-SIZE: 15px; TEXT-ALIGN: center"><a
    href="">最新</a> | <a
    href="">最热门</a> | <a
    href="">最高评价</a></div>

<?php foreach($new_data as $k=>$v){?>
<div class="entry">
<div class="entry_inner">
<div class="comment_bubble"><a href="<?php echo $v[url];?>#respond"><?php if($v[comment_count]!=0){echo $v[comment_count];}else{ echo "^..^";} ?></a></div>
<h2 class="title"><a href="<?php echo $v[url]; ?>"> <!--<span class="thumb_up">+0</span>--> &nbsp;<?php echo $v[post_title]; ?></a></h2>
    
<div>Tag: 
<?php foreach($v[tags] as $vv){?>
	<a href=""><?php echo $vv[name];?></a>(<?php echo $vv[count];?>) &nbsp;
<?php }?>
</div>
<div style="MARGIN: 4px 0px"><a
    href="<?php echo $v[url]; ?>"  target="_blank"> <?php echo $v[display_name]; ?></a> 发于 <?php echo $v[post_date]; ?>
| 点击: <?php echo $v[views];?> | <a onclick="toggle_element('excerpt-<?php echo $v[post_author].$v[id];?>')">展开摘要</a></div>
<div style="DISPLAY: none" id="excerpt-<?php echo $v[post_author].$v[id];?>" class="excerpt">
 <?php echo $v[post_excerpt]; ?><BR/>
 原文链接: <a target="_blank" href="<?php echo $v[url]; ?>"><?php echo $v[url]; ?></a>
</div>
</div>
</div>
    
    
<?php }?>

<!--
<div class="PagerView"> <span>|&lt;</span><span>&lt;&lt;</span><span
    class="page_num on">1</span><a href="http://www.udpwork.com/p/2"><span
    class="page_num">2</span></a><a href="http://www.udpwork.com/p/3"><span
    class="page_num">3</span></a><a href="http://www.udpwork.com/p/4"><span
    class="page_num">4</span></a><a href="http://www.udpwork.com/p/5"><span
    class="page_num">5</span></a><a href="http://www.udpwork.com/p/6"><span
    class="page_num">6</span></a><a href="http://www.udpwork.com/p/7"><span
    class="page_num">7</span></a><a href="http://www.udpwork.com/p/2"><span>&gt;&gt;</span></a><a
    href="http://www.udpwork.com/p/363"><span>&gt;|</span></a> 一共363页,
3624条记录</div> -->
</div>

<?php  
   $r = $this->getRequest();
   $group_l=$r->get("group_l");
?>
<!-- /#content -->
<div id="sidebar_div">
<div id="sidebar">
<div style="MARGIN: 8px">
<img src="/wp-content/themes/seecblogmvc/images/udpwork.com.gif">
</div>

<?php foreach($group_l as $k=>$v){?>

<h2><?php echo $v[title];?></h2>
<ul>
<?php foreach($v[0] as $vv){?>
 <li><a href="<?php echo $vv["url"]; ?>"><?php echo $vv["post_title"];  ?></a></li>
<?php }?>
</ul>
<a href=""><b>More...</b></a>
<?php }?>

</div>
<!-- /#sidebar --></div>
<!-- /#sidebar_div -->
<div style="CLEAR: both"></div>
</div>
<!-- /.inner -->
<div class="bottom"></div>
</div>
<!-- /.big_box --></div>

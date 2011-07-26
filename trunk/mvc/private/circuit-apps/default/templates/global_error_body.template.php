<?php
  $c = $this->getrequest();
  $ERROR_MESSAGE = $c->get('ERROR_MESSAGE');
?>
<style>
#erroroutput {
	position:relative; display: block;
	padding: 10px; padding-right: 20px;
	padding-left: 80px; margin: 10px; 
	font-size: 12px; color: #000; width:525px;
}
	.msgbad { border: 2px solid #CC0000; 
		background: url('/images/layout/friendlist/messagebg_error.png') left top no-repeat; 
	}
	.msgbad b { color: #C00; } 
	

	#erroroutput #errorclose {
		position: absolute;
		top:2px; right:2px; 
		/* border: 1px solid #0F0; */
	}
	
	* html #errorclose {
		margin-right: 135px;
	}

</style>
<script type="text/javascript">
function closemsg()
{
	var div = document.getElementById('erroroutput');
	div.style.display ='none';
}
</script>
<div id="erroroutput" class="msgbad">
<?=$ERROR_MESSAGE; ?>

<div id="errorclose"><a href="javascript:closemsg();"><img src="http://{GRAPHICS_SERVER}/images/layout/friendlist/button_close.png" width=15 height=12 border=0 /></a></div>
</div>
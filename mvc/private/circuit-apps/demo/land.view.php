<?php

class Demo_Land_CircuitView extends CircuitGridView
{
	function execute(CircuitController $c)
	{
		
      LM::setPageTitle('盖亚星空首页');
	  LM::addCSS_IE('/src/css/screen_ie6.css',6);
	  LM::addScript("/src/js/newlanding/ie6png.js");
	  LM::renderHeader();
	  $this->addZoneContent('Landing.Up');
      LM::renderFooter();
	}
	
}

?>
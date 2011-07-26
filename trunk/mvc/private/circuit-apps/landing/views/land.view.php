<?php
class Landing_Land_CircuitView extends CircuitGridView
{
	function execute(CircuitController $c){
		$r = $c->getRequest();
		$newblog = $r->get('newblog');
		$this->set('newblog', $newblog);
		$group_l = $r->get('group_l');
		$this->set('group_l', $group_l);

		// LM::setPageTitle('盖亚星空首页');
		//LM::addCSS_IE('/src/css/screen_ie6.css',6);
		//LM::addScript("/src/js/newlanding/ie6png.js");
		LM::renderHeader();
		$this->addZoneContent('Landing.bloglist');
		$this->addZoneContent('Landing.niuren');
		LM::renderFooter();
	}



}

?>
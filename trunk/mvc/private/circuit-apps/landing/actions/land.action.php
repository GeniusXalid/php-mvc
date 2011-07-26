<?php
 class Landing_Land_CircuitAction extends CircuitAction
 {
   public function execute(CircuitController $c){
   	       $r = $c->getRequest();
   	       $allblogs = $c->getModel('Landing.Land');
           $newblog=$allblogs->getnewBlog();
          $r->set('newblog', $newblog); 
           
          //获取群组最新5片博文
          $groups=$allblogs->getGroupList();
          $r->set('group_l', $groups);  
          
   }
 }

?>
<?php

/**
 * Standard fatal error page
 * This generates an error page using data from the request container or the
 * observer (for backwards compatibility) if the request data does not exist.
 * If a redirect url is passed in, the page will redirect to the given URL after
 * a certain number of seconds. Also, a "click here to go there" link will be
 * automatically generated so each app doesn't have to create its own.
 * @author John <jloehrer@gaiaonline.com>
 * @author Karen <kziv@gaiaonline.com>
 **/
class Default_MessageDie_CircuitView extends CircuitView {

    public function execute(CircuitController $c) {
    	$r = $c->getRequest();
    	$observer   = $c->getObserver();
    	$forward_view=$observer->get('forward.view');    	    	
    	if(isset($forward_view) && trim($forward_view)!=''){
    		$this->forward($forward_view);	// forwarded to views for seconday login 5.7 CSR 2
    	}
        // Get the message data. Try the request container first,
        // only using the observer for backwards compatibility
        if ($r->isEmpty('redirect.message')) {
            //$observer   = $c->getObserver();
            $err_url    = $observer->get('redirect.path');
            $redir_wait = $observer->get('redirect.delay'); 
            $err_code   = $observer->get('error.code');
            $err_msg    = $observer->get('error.message');
            $err_title  = $observer->get('error.title');
            $err_line   = $observer->get('error.line');
            $err_file   = $observer->get('error.file');
            $err_debug  = $observer->get('error.debug');
        }
        else {
            $err_url    = $r->get('redirect.url');
            $redir_wait = $r->get('redirect.delay');  
            $err_code   = $r->get('redirect.code');
            $err_msg    = $r->get('redirect.message');
            $err_title  = $r->get('error.title');
            $err_line   = $r->get('error.line');
            $err_file   = $r->get('error.file');
            $err_debug  = $r->get('error.debug');
        }

        // If a redirect URL is passed in, create a meta redirect
        if (!empty($err_url)) {
        	if ( ! urlIsLocal($err_url) ) {
                $err_url = 'http://' . MAIN_SERVER . '/404-not-found';
                $observer->set('redirect_path', $err_url);
                $observer->set('redirect_url', $err_url);
                $this->forward('Default.404');
            }
            if ($redir_wait === NULL) {
                $redir_wait = 3;
            }
            
            LM::setMeta('<meta http-equiv="refresh" content="' . $redir_wait . ';url=' . $err_url . '"/>');
        }	
        // Create a link to go ahead manually instead of waiting for the redirect
        if (!empty($err_url)) {
            $err_msg .= '<p>如果' . $redir_wait . '秒内没有跳转,请<a href="' . $err_url . '">点击这里</a>.</p>';
        }  else {
        	if($_SERVER['HTTP_REFERER']==''){
        		$err_msg .= "<a onclick='history.back(-1)' style='cursor:pointer'>点击返回</a>";
        	}
        }     
        message_die($err_code, $err_msg, $err_title, $err_line, $err_file, $err_debug);
        exit;
    }
}

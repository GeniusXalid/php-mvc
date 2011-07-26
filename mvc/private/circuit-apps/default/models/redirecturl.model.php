<?php
// +---------------------------------------------------------------------------+
// | This file is part of the CIRCUIT MVC Framework.                           |
// |                                                                           |
// | Copyright (c) Gaia Online 2005                                            |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * obtains and cleans up redirecting url from the url
 * also prevents any hack attempts at inputting a url
 */
class Default_RedirectUrl_CircuitModel
{
   /**
    * Execute
    */
    function execute(&$observer)
    {
        $url = $this->extractRedirect();
		//var_dump($url);exit;
        $observer->set('redirect.path', $url);
        return TRUE;
    }
    
    
    function extractRedirect()
    {
        if( isset( $_POST['redirect'] ) ) return $_POST['redirect'];
        
        $redirect = isset( $_GET['redirect'] ) ? $_GET['redirect'] : '';
        
        $redirect = trim( $redirect );
        
        if( strlen( $redirect) < 1 ) return '';

		if (strpos( $redirect, '#') || strpos( $redirect, '&') ) return $redirect;

        if( strpos( $redirect, '?') === FALSE ) return urldecode($redirect);
    
        $params = array();
        $excluded = array('login', 'logout', 'sid', 'redirect', 'login_success');
        foreach( $_GET as $k=>$v)
        {
            $k = strtolower( $k );
            if( in_array( $k, $excluded ) || in_array( $v, $excluded ) ) continue;
            $params[$k] = $v;
        }
        
        return generateUrl( urldecode($redirect), $params );
    }
}//end of class
?>
<?php
// +---------------------------------------------------------------------------+
// | This file is part of the CIRCUIT MVC Framework.                           |
// |                                                                           |
// | Copyright (c) Gaia Online 2006                                            |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

// Load the request
// @package    Circuit

class Default_Router_CircuitRequest extends CircuitRequest
{

    protected $route;

    function __construct( CircuitController $c, $n )
    {
        parent::__construct($c, $n);
        
        $config = $c->getConfig();
        
        // the URL path should be the implicit path in the request URI.  We remove
        // the following for universal compatibility:
        // (note: all ending slashes are trimmed)
        // /foo/bar/                remove leading slash
        // /index.php/foo/bar       remove leading slash, then remove /index.php/
        // /index.php?_=            remove leading slash, index.php, and the special controller _=
        // if there is ?_=, use that first
        
        if (isset($_REQUEST['_'])) {
            $url_path = $_REQUEST['_'];
        }
        else if (isset($_SERVER['PATH_INFO'])) {
            $url_path = $_SERVER['PATH_INFO'];
        }
        else {
            $pos = strpos($_SERVER['REQUEST_URI'], '?');
            $url_path =( $pos === FALSE ) ? 
                $_SERVER['REQUEST_URI'] : substr($_SERVER['REQUEST_URI'], 0, $pos);
        }
        
        $script_name = $_SERVER['SCRIPT_NAME'];
        
        // make a list of the characters we want to trim off the ends of our urls.
        $trim_chars = "/\n\r\0\t\x0B ";
        
        $url_path = str_replace(array($script_name.'/', $script_name.'?_='), '', $url_path);
        $url_path = trim($url_path, $trim_chars);
        
        $url_args = array();
        
        // set the default circuit-app.
        $this->route = $config->findApp('/');
        
        // look for the url path in the config
        // every time we don't find it, we slice off one tier of the URL and add it to
        // the argument list.  Once there are no URL pieces left, default to index
        while (strlen($url_path) != 0 && !( $this->route = $config->findApp($url_path) ) ) {
        
            // path not found, trim by 1 subsection
            $new_arg = substr($url_path, strrpos($url_path, '/'));
            $url_path = substr($url_path, 0, strrpos($url_path, $new_arg));
        
            // put the new arg into the list
            array_unshift($url_args, trim($new_arg, $trim_chars));
        }
        
        if (strpos(trim($_SERVER['REQUEST_URI'], $trim_chars), $script_name) === 0) {
            // this is a path info or messy url build.
            $base = $script_name;
        }
        else {
            $base = '/';
        }
        
        // base is our base URL we are working from
        // it is everything from the first slash forward
        // we gaurenteed earlier base as an ending /
        // so we can do lightening fast string ops here
        $config->setBase($base);
        
        // set the args into the namespace
        $this->set('__args__', $url_args);
        
    }
        
    function forward(){
        return $this->route;
    }
     
    function selectView()
    {
        return 'Default.404';
    }
}
?>
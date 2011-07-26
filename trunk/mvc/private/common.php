<?php
/***************************************************************************
 *                                common.php
 *                            -------------------
 *
 *   $Id: common.php,v 1.74.2.5 2002/12/17 23:59:37 psotfx Exp $
 *
 ***************************************************************************/
function initializeBase()
{
    // set the default timezone

    if( function_exists('date_default_timezone_set') ) 
        @date_default_timezone_set('Asia/Shanghai');

     // define the start of our script
    define('MICROTIME', microtime(TRUE));

    // path to the html templates folder.

    // base path
    define('DIR_BASE', dirname(dirname( __FILE__ ) )  . '/');

    // path to the private source code
    define('DIR_PRIVATE', DIR_BASE . 'private/');

    // path to the 3rd Party vendors
    define('DIR_VENDORS', DIR_BASE . 'vendors/');

    // path public_html folder
    //define('DIR_PUBLIC_HTML', DIR_BASE .'wp-content/themes/seecblog/');
    define('DIR_PUBLIC_HTML', DIR_BASE );
    // define the path to the classes directory
    define('DIR_CLASSES', DIR_PRIVATE . 'classes/');

    
    // path to php includes
    define('DIR_INCLUDES', DIR_PRIVATE . 'includes/' );

    // path to script includes.
    define('DIR_SCRIPT_INCLUDES', DIR_PRIVATE . 'script_includes/');


    // path to circuit application directory root
    define('DIR_CIRCUIT_APPS', DIR_PRIVATE . 'circuit-apps/');
    
    // include general fuctions
    include_once(DIR_INCLUDES .'functions.php'); // EVENTUALLY INTEGRATE THIS FILE INTO THIS PAGE
    
    
    // get rid of stupid errors.
    if ( !defined('IN_PHPBB') )  define('IN_PHPBB', true);


    // This will NOT report uninitialized variables
    if( SC::isEmpty('board_config.report_errors') ){
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
    }else{
        error_reporting(E_ALL);
        ini_set('report_errors', 1);
        // ini_set('display_errors', 1);
    }

    //
    // Obtain and encode users IP
    $user_ip_address = get_user_ip();

    define('USER_IP',encode_ip($user_ip_address));
    SC::setGlobal('user_ip', USER_IP);
    
    // not sure if we still need this but just trying to keep consistent.
    // i converted to string replace instead of preg_match then preg_replace.
    // still not sure we need it tho.
    foreach ($_SERVER as $key=>$ex_check) {
        if (is_string($ex_check) ) $_SERVER[$key]=str_replace(array('"', "'"),'',$ex_check);
    }

    // becuase register_globals is turned off...
    // $PHP_SELF doesn't work anymore...
    // so, we have to force it to work for bw compatibility.
    // as soon as possible, remove this!
    SC::setGlobal('PHP_SELF', $_SERVER['PHP_SELF']);
    // start output buffering
    buffer_browser_output();

}



function gaia_autoload( $class = NULL)
{
    $class = strtolower($class);
    switch ($class) {
        case 'sc'                       :
        case 'sharedcontainer'          :
        case 'singletoncontainer'       :
        case 'container'                :
        case 'containerbase'            : return include DIR_CLASSES . 'container/container.php';

        case 'lm'                       :
        case 'layoutmanager'            : return include DIR_CLASSES . 'layoutmanager.php';

        case 'version'                  :
        case 'version_execption'        : return include DIR_CLASSES . 'version.php';
        default                         : return false;
    }
}

// register the autoload function
spl_autoload_register("gaia_autoload");

// perform base intialization
initializeBase();


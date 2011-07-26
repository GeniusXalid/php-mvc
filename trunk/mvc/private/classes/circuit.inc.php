<?php
// +---------------------------------------------------------------------------+
// | This file is part of the CIRCUIT MVC Framework.                           |
// | Author 72squared  (john@gaiaonline.com)                                   |
// |                                                                           |
// | Copyright (c) Gaia Online 2005                                            |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+


// the state object uses the container class as a parent.
include_once( DIR_CLASSES . 'container/container.php');

/**
 * The controller object dispatches the request and is responsible
 * for instantiating the models, views, actions and frames.
 */
class CircuitController
{

   /**
    * The directory where all the circuit applications reside.
    * @type string
    * @access protected
    */
    protected $dir;
  /**
    * The observer object
    * @type Container
    * @access private
    */
    protected $observer;

    /**
     * contains the URL mapping and config
     * settings for the application
     * @type Container
     * @access protected
     **/
    protected $config;

    /**
    * Keep track of all exception listeners here
    * @type array
    * @access protected
    */
    protected $exception_listeners = array();

    /**
     * holds the exception object for later use
     */
    protected $exception;


   /**
    * Constructor
    */
    public function __construct( $dir = NULL )
    {
        $this->config = new CircuitConfig();
        $this->setAppDir( ( $dir === NULL ) ? DIR_CIRCUIT_APPS : $dir);
        $this->observer = new Container();
    }


   /**
    * Set the path to the application directory.
    * @param string    The filesystem path to the application root dir.
    * @return void
    * @access public
    */
    public function setAppDir( $dir )
    {
        $this->dir = $dir;
        $config = NULL;
        @include $this->dir . 'config.php';
        $this->config->load($config);
    }

   /**
    * Get the path to the application directory.
    * @return string
    * @access public
    */
    public function getAppDir()
    {
        return $this->dir;
    }

    /**
     * get the config container from its protected
     * @return void
     * @access public
     **/
    public function getConfig()
    {
        return $this->config;
    }

   /**
    * Get the state object
    * @return Object
    * @access public
    */
    public function getObserver()
    {
        return $this->observer;
    }

    public function resolveTemplate($name) {
        $name = strtolower($name);
        if(! strpos($name, '.') ) return FALSE;
        list( $base, $name ) = explode('.', $name, 2);
        $name = str_replace('.', '/', $name);
        $dir = $this->getAppDir();
        $path1 = $dir . $base . '/' . $name . '.template.php';
        $path2 = $dir . $base . '/templates/' . $name . '.template.php';

        if( file_exists( $path1 ) ) return $path1;
        if( file_exists( $path2 ) ) return $path2;
        return FALSE;
    }

   /**
    * Generate a URL based on the application
    * @param string
    * @param array
    * @param boolean
    * @return string
    * @access public
    */
    public function generateURL($app = NULL, $params = array(), $amp=TRUE)
    {
        // the app name is strtolower (url compatibility)
        // so that we can be sure that we can find a match in the config routing
        $app = strtolower($app);

        // go ahead and search through the routing
        $key = $this->getConfig()->findPath($app);

        // if we didn't find a match, just do generateSelfURL
        if( $key === FALSE ) return generateSelfURL($params, $amp);

        // create the base url. this means getting the config's base, which is something
        // like the script name of the entry point. add on the app's routing url.
        $base = $this->getConfig()->getBase();

        // add an ending slash to base if we need to
        $base .= (substr($base, -1) == '/') ? '' : '/';

        // only add a trailing slash if this isn't a php file (GAIA)
        $base .= (substr($key, -4) != '.php') ? $key . '/' : $key;

        // if we don't have any dynamic params, we are done ... returns the app url
        if( ! is_array( $params ) ) return generateURL($base, array(), $amp );

        // order the params so that we get all the non-assoc. keyed elements first,
        // then everything else
        uksort($params, 'strnatcasecmp');

        // initialize an array for parameters
        // if the parameter was a int, it becomes
        // part of the URL
        $p = array();
        foreach($params as $k=>$v)
        {
            if( is_int($k) ) {
                $base .= $v .'/';
                continue;
            }
            $p[$k] =$v;
        }

        // generate the self url
        return generateURL($base, $p, $amp);
    }


   /**
    * Perform the desired action.
    * @param string    The name of the action.
    * @return void
    * @access public
    */
    public function dispatch( $request_name = NULL )
    {
         while( true ){
            try{                                
                $request = $this->instantiate( $request_name, 'request', 'request');
                SC::set('CIRCUIT_REQUEST_NAME', $request_name);                         
            }catch( Exception $e){
                $request = $this->instantiate( CIRCUIT_APP_404, 'request');
            }

            try {
                if( method_exists( $request, 'load') ) $request->load( $this->observer );
                if( method_exists( $request, 'forward') && $request_name = $request->forward($this->observer) ) continue;
                $action_name = ( method_exists( $request, 'selectAction') ) ? $request->selectAction( $this->observer ) : $request_name;
                
            } catch( Exception $e ){
                $this->handleException($e);
                return $this->instantiate( 'Default.MessageDie', 'view')->execute( $this );
            }
            break;
        }
        $action_result = null;
        if( $action_name )
        {
            try
            {
                $action = $this->instantiate( $action_name, 'action');
                $action_result = $action->execute( $this );
            }
            catch( Exception $e )
            {
                $action_result = $this->handleException($e);
            }
        }

        $this->clearExceptionListeners();
        $selectView = 'selectView_' . str_replace('.', '_', $action_name );


        $view_name = ( method_exists( $request, $selectView ) ) ? $request->$selectView( $action_result ) : ( method_exists($request, 'selectView')  ? $request->selectView($action_result) : $request_name);

        try
        {
            $view = $this->instantiate( $view_name, 'view');
        }
        catch( Exception $e)
        {
            $view = $this->instantiate( CIRCUIT_APP_404, 'view');
        }

        $view->execute(  $this );
    }

   /**
    * Handle an exception
    * @param CircuitException
    * @return void
    */
    public function handleException( Exception $e)
    {
        $this->exception = $e;
        if( $e instanceof CircuitRedirectException )
        {
            $this->getObserver()->set('redirect.path', $e->getURL());
            $this->getObserver()->set('redirect.message', $e->getMessage());
        }
        if( method_exists($e, 'getErrorCode') ) $this->getObserver()->set('error.code', $e->getErrorCode());
        if( method_exists($e, 'getTitle') ) $this->getObserver()->set('error.title', $e->getTitle());
        $this->getObserver()->set('error.message', $e->getMessage());
        $this->getObserver()->set('error.line', $e->getLine());
        $this->getObserver()->set('error.file', $e->getFile());

        $this->getObserver()->set('error.debug', method_exists($e, 'getDebug') ? $e->getDebug() : $e->getTraceAsString());
        $outcome = method_exists($e, 'getType') ? $e->getType() : VIEW_ERROR;
        foreach( $this->exception_listeners as $listener )
        {
            $obj= $listener[0];
            $method = $listener[1];
            try {
                $r = $obj->$method($e);
                if( $r instanceof CircuitActionCode ) $outcome = $r->code;
            }
            catch( Exception $v ){}
        }
        return $outcome;
    }

   /**
    * Attach a listener callback when an exception is triggered, it will fire this.
    * @param Object
    * @param string
    * @return boolean
    * @access public
    */
    public function attachExceptionListener( $object, $method )
    {
        if( ! is_object( $object ) ) return FALSE;
        if( ! is_string( $method ) || ! method_exists( $object, $method) ) return FALSE;
        $this->exception_listeners[] = array($object, $method);
        return TRUE;
    }

   /**
    * Remove all the listeners for exceptions
    * @return void
    * @access public
    */
    public function clearExceptionListeners()
    {
        $this->exception_listeners = array();
    }

   /**
    * Create the new object
    * @param string    The name of the object
    * @param string    The type of object
    * @return CircuitObject
    * @access protected
    */
    protected function instantiate( $name, $type, $namespace = NULL )
    {
        if( strlen( $namespace ) < 1) $namespace = $name;
        $namespace = strtolower($namespace);
        $base_object =  'Circuit'. ucwords($type);
        if( strlen( $name ) < 1 )  throw new CircuitInstantiationException('no class name provided');
        $class = str_replace('.', '_', ucwords($name) ) . '_' . $base_object;

        if( class_exists( $class ) ) return new $class($this, $namespace);

        $name = strtolower($name);
        if(! strpos($name, '.') ) throw new CircuitInstantiationException('invalid classname provided');
        list( $base, $name ) = explode('.', $name, 2);
        $name = str_replace('.', '/', $name);
        $path1 = $this->dir . $base . '/' . $name . '.' . $type . '.php';
        $path2 = $this->dir . $base . '/' . $type . 's/' . $name . '.' . $type . '.php';
        $path = file_exists( $path1 ) ? $path1 : $path2;


        @include_once($path);
        if( class_exists( $class ) ) return new $class($this, $namespace);
        throw new CircuitInstantiationException($class . ' does not exist');
    }



    /**
    * Send the responsibility off to another action.
    * Return the outcome of the action.
    * @param string    Action Name.
    * @return mixed    An identifier for an action outcome.
    */
    public function forward( $action_name )
    {
        $action = $this->instantiate($action_name, 'action');
        return $action->execute( $this );
    }

  /**
    * Get a the circuit request
    * @return Container
    * @access public
    */
    public function getRequest($name = NULL)
    {
        if( $name !== NULL ) return $this->instantiate($name, 'request');
        $container = $this->getObserver()->get('request');
        if (!($container instanceof Container) ) $container = $this->getObserver()->set('request',  new Container());
        return $container;
    }

   /**
    * Get an action
    * @return CircuitAction
    * @access public
    */
    public function getAction( $name )
    {
        return $this->instantiate($name, 'action');
    }

    /**
    * Get a view
    * @return CircuitView
    * @access public
    */
    public function getView( $name )
    {
        return $this->instantiate($name, 'view');
    }


    /**
    * Get a model
    * @return CircuitModel
    * @access public
    */
    public function getModel( $name, $namespace = NULL )
    {
        return $this->instantiate($name, 'model', $namespace);
    }

    /**
     * Get a container that was built by a model
     * @return Container
     * @access public
     */
    public function getModelData($name)
    {
        $container = $this->getObserver()->get(strtolower($name));
        if (!($container instanceof Container) ) $container = new Container();
        return $container;
    }

    /**
     * free a container that was built by a model
     * @return void
     * @access public
     */
    public function freeModelData( $name ){
        return $this->getObserver()->remove(strtolower($name));
    }

   /**
    * get the error info encapsulated in a container
    * @return Container
    * @access public
    */
    public function getError()
    {
        $container = $this->getObserver()->get('error');
        if (!($container instanceof Container) )
        {
            $container = new Container();
            $data = $this->getObserver()->get('error');
            if( is_array($data ) )
            {
                foreach( $data as $k=>$v ) $container->set($k, $v);
            }
            $this->getObserver()->set('error', $container );
        }

        return $container;
    }

   /**
    * @return Exception that was thrown
    * @access public
    */
    public function getException()
    {
      return $this->exception;
    }

   /**
    * Get a mold
    * @return CircuitMold
    * @access public
    */
    public function getMold( $name, $namespace = NULL)
    {
        return $this->instantiate($name, 'mold', $namespace);
    }

    /**
    * Get a frame
    * @return CircuitFrame
    * @access public
    */
    public function getFrame( $name, $namespace = NULL)
    {
        return $this->instantiate($name, 'frame', $namespace);
    }
}


/**
 * Circuit Exception
 */
class CircuitException extends Exception
{
   /**
    * The title of the error
    * @type string
    * @access protected
    */
    protected $title = '操作出错';

   /**
    * The type of the error ( assoc with a VIEW constant )
    * @type int
    * @access protected
    */
    protected $type = VIEW_ERROR;

   /**
    * Constructor
    * @param string
    * @param constant
    * @return void
    * @access public
    */
    public function __construct($msg, $error_code = GENERAL_ERROR)
    {
        parent::__construct($msg, -1);
        $this->error_code = $error_code;
    }

   /**
    * Get the title
    * @return string
    * @access public
    *
    */
    public function getTitle()
    {
        return $this->title;
    }

   /**
    * Get the type
    * @return int
    * @access public
    *
    */
    public function getType()
    {
        return $this->type;
    }

   /**
    * Get the error code
    * @return int
    * @access public
    *
    */
    function getErrorCode()
    {
        return $this->error_code;
    }
}

/**
 * Exception indicating an error
 */
class CircuitErrorException extends CircuitException{ }


/**
 * Exception for Database errors
 */
class CircuitDatabaseException extends CircuitErrorException
{
   /**
    * The default title
    * @type string
    * @access protected
    */
    protected $title = '数据库错误';

   /**
    * Debug info
    * @type object
    * @access protected
    */
    protected $debug;

   /**
    * Class constructor
    * @param string
    * @param object
    * @access public
    * @return void
    */
    public function __construct($msg, $debug = NULL)
    {
        parent::__construct($msg);
        $this->debug = $debug;
    }

   /**
    * Get debug info
    * @return object
    * @access public
    */
    public function getDebug()
    {
        return $this->debug;
    }
}

/**
 * Indicates a no-data exception
 */
class CircuitNoDataException extends CircuitDatabaseException
{
   /**
    * The default title
    * @type string
    * @access protected
    */
    protected $title = '找不到数据';
}

/**
 * indicates an execution exception
 */
class CircuitExecutionException extends CircuitDatabaseException
{
   /**
    * The default title
    * @type string
    * @access protected
    */
    protected $title = '无法完成请求';
}

/**
 * indicates a permission problem has been found
 */
class CircuitPermissionException extends CircuitException
{
   /**
    * The default title
    * @type string
    * @access protected
    */
    protected $title = '操作被拒绝';

   /**
    * The default type
    * @type int
    * @access protected
    */
    protected $type = VIEW_AUTH;
}

/**
 * indicates an auth. exception
 */
class CircuitAuthException extends CircuitException
{
   /**
    * The default title
    * @type string
    * @access protected
    */
    protected $title = '认证出错';

   /**
    * The default type
    * @type int
    * @access protected
    */
    protected $type = VIEW_AUTH;
}

/**
 * indicates an alert exception
 */
class CircuitAlertException extends CircuitException
{
   /**
    * The default title
    * @type string
    * @access protected
    */
    protected $title = 'Alert';

   /**
    * The default type
    * @type int
    * @access protected
    */
    protected $type = VIEW_ALERT;

   /**
    * constructor
    * @param string
    * @return void
    * @access public
    */
    public function __construct( $msg )
    {
        parent::__construct($msg, GENERAL_MESSAGE);
    }
}

/**
 * indicates confirm exception
 */
class CircuitConfirmException extends CircuitException
{
   /**
    * The default title
    * @type string
    * @access protected
    */
    protected $title = '请确认';


   /**
    * The default type
    * @type int
    * @access protected
    */
    protected $type = VIEW_CONFIRM;


   /**
    * constructor
    * @param string
    * @return void
    * @access public
    */
    public function __construct( $msg )
    {
        parent::__construct($msg, GENERAL_MESSAGE);
    }
}

/**
 * indicates a validation Exception
 */
class CircuitValidationException extends CircuitException
{
   /**
    * The default title
    * @type string
    * @access protected
    */
    protected $title = '数据校验错误';

   /**
    * The default type
    * @type int
    * @access protected
    */
    protected $type = VIEW_INVALID;
}

/**
 * indicates an instantiation exception
 */
class CircuitInstantiationException extends CircuitException
{
   /**
    * The default title
    * @type string
    * @access protected
    */
    protected $title = '系统错误';
}

/**
 * indicates a request exception
 */
class CircuitRequestException extends CircuitException
{
   /**
    * The default title
    * @type string
    * @access protected
    */
    protected $title = '请求发生错误';

   /**
    * The default type
    * @type int
    * @access protected
    */
    protected $type = VIEW_INVALID;
}

/**
 * indicates an application is disabled
 */
class CircuitDisabledException extends CircuitException
{
   /**
    * The default title
    * @type string
    * @access protected
    */
    protected $title = '已禁用';

   /**
    * The default type
    * @type int
    * @access protected
    */
    protected $type = VIEW_DISABLE;
}

/**
 * Not sure if i recommend using this one ... instead, go to a view and
 * have the view do the redirect. oh well.
 */
class CircuitRedirectException extends CircuitException
{
   /**
    * The url
    * @type string
    * @access protected
    */
    protected $url = '/';

   /**
    * The default title
    * @type string
    * @access protected
    */
    protected $title = '跳转';

   /**
    * The default type
    * @type int
    * @access protected
    */
    protected $type = VIEW_REDIRECT;

   /**
    * constructor
    * @param string
    * @param string
    * @return void
    * @access public
    */
    public function __construct($url, $msg = NULL)
    {
        parent::__construct($msg);
        $this->url = $url;
    }

    /**
    * get the url to redirect to?
    * @return string
    * @access public
    */
    public function getURL()
    {
        return $this->url;
    }
}

/**
 * Circuit View
 */
class CircuitView extends Container
{
    private $controller;
    private $layout;

   /**
    * Constructor
    * @param CircuitController
    * @return void
    * @access public
    */
    public function __construct(CircuitController $c)
    {
        $this->controller = $c;
        $this->layout = new Container();
        $this->layout->set('master_cachebuster', 10);
        //$this->layout->set('yui_version', );
    }

   /**
    * @see CircuitController::getModelData
    */
    protected function import($n)
    {
        return $this->controller->getModelData($n);
    }

   /**
    * @see CircuitController::freeModelData
    */
    protected function free($n)
    {
        return $this->controller->freeModelData($n);
    }

   /**
    * @see CircuitController::getRequest
    */
    public function getRequest()
    {
        return $this->controller->getRequest();
    }

   /**
    * @see CircuitController::getError
    */
    public  function getError()
    {
        return $this->controller->getError();
    }

   /**
    * @see CircuitController::getException
    */
    public  function getException()
    {
        return $this->controller->getException();
    }

   /**
    * @see CircuitController::getConfig
    */
    public function getConfig()
    {
        return $this->controller->getConfig();
    }

   /**
    * @see CircuitController::getObserver
    */
    public function getObserver()
    {
        return $this->controller->getObserver();
    }

   /**
    * forward to another view.
    * @param string
    * return @void
    */
    public function forward($n){
        return $this->controller->getView($n)->execute( $this->controller );
    }


   /**
    * @see CircuitController:: generateURL
    */
    function generateURL( $app=NULL, $params = array(), $amp = TRUE)
    {
        return $this->controller->generateURL( $app, $params, $amp);
    }

   

    /**
     * Renders the page header
     * @param {str} Type of header to render
     * @author Karen <kziv@gaiaonline.com>
     **/
    public function renderHeader($type= 'normal') {
        $ok_headers = array('popup', 'admin', 'simple', 'bare', 'normal','reg');

        if (in_array(strtolower($type), $ok_headers)) {
            $this->render('Default.Header.' . $type);
        }
        else {
            $this->render('Default.Header.Normal');
        }
    }

    /**
     * Renders the page footer
     * @param {str} Type of header to render
     * @author Karen <kziv@gaiaonline.com>
     **/
    public function renderFooter($type = 'normal') {
        $ok_footers = array('popup', 'admin', 'simple', 'bare', 'normal','reg');
        if (in_array(strtolower($type), $ok_footers)) {
            $this->render('Default.Footer.' . $type);
        }
        else {
            $this->render('Default.Footer.Normal');
        }
    }

    /**
     * Adds a CSS script for inclusion in the header
     * @param string $path full http:// path to the script
     * @param string $media the media type, default is "screen"
     */
    public function addCSS($path, $media = "screen") {
        $layout = $this->getLayoutConfig();

        // Initialize the CSS stack if it doesn't exist
        if (!$layout->exists('css')) {
            $layout->set('css', array());
        }

        $layout->append('css', array('path'  => $path,
                                     'media' => $media
                                     ));
    }

    /**
     * Adds a CSS script with IE conditionals for inclusion in the header
     * @param string $path full http:// path to the script
     * @param int $version IE version
     * @param string $media the media type, default is "screen"
     */
    public function addCSS_IE($path, $ie_version = 7, $media = "screen") {
        $layout = $this->getLayoutConfig();

        // Initialize the CSS stack for IE 6 if it doesn't exist
        if ($ie_version == 6) {
            if (!$layout->exists('css_ie6')) {
                $layout->set('css_ie6', array());
            }

            $layout->append('css_ie6', array('path'  => $path,
                                         'media' => $media
                                         ));
        }
        else {
            if (!$layout->exists('css_ie7')) {
                $layout->set('css_ie7', array());
            }

            $layout->append('css_ie7', array('path'  => $path,
                                         'media' => $media
                                         ));
        }

    }

    /**
     * Adds a script file for inclusion in the header
     * @param {string} Path to script. Can be relative (e.g. /src/js/path/to/script.js)
     *                 or absolute for external scripts (e.g. http://externalsite.com/script.js)
     **/
    public function addScript($path) {
        $this->getLayoutConfig()->append('scripts', $path);
    }

    /**
     * Sets the page title
     * Stores the page title for display in the browser bar and the
     * page header section. ':: Gaia Online' is automatically appended
     * in the browser bar.
     * @param string $title Title of the page
     */
    public function setPageTitle($title) {
        $layout = $this->getLayoutConfig();
        $layout->set('page_title', $title);
    }

    /**
     * Sets an application level cachebuster
     * Use this to refresh the CSS on the user browser level
     * @param {int} Some number different than the one before
     */
    public function setApplicationCacheBuster($v = 0) {
        $this->layout->set('app_cachebuster', $v);
    }


    public function resolveTemplate($name){
        return $this->controller->resolveTemplate($name);
    }

    /**
    * Render a template and return it as a string
    * @param string
    * @return string
    * @access public
    */
    public function fetch( $name )
    {
        ob_start();
        $this->render( $name );
        $out = ob_get_contents();
        ob_end_clean();
        return $out;
    }

   /**
    * stub function. default behavior of execute.
    * @return void
    */
    public function execute(){
        echo get_class($this) . '-Under-Construction';
    }


    /**
    * catch any undefined methods and pass them off to a library of template
    * functions
    * @param string
    * @param array
    * @return mixed
    * @access protected
    */
//    protected static function __call( $method, $args ){
//        return FunctionLibrary()->call( $method, $args );
//    }
}

/**
 * Grid manager view
 **/
class CircuitGridView extends CircuitView {

    protected $layout = 'general.full'; // Set to ungridded by default
    protected $zones  = array();        // zone_name => path.to.zone.content.template
    protected $zone_configs = array();  // Configuration information for a specific zone...

    /**
     * This constructor method is only needed until we don't need the LM::useGrid call.
     * It's in the constructor because it needs to run before LM::renderHeader.
     **/
    public function __construct(CircuitController $c) {

        parent::__construct($c);

        // All views that use this class need this call. Once LM is removed or
        // all pages use a grid, this can be made a permanent part of the site

    }
    
    
    protected function instantiate( $name, $type )
    {        
        $name = strtolower($name);
        if(! strpos($name, '.') ) throw new CircuitInstantiationException('$name');
        list( $base, $name ) = explode('.', $name, 2);        
        $name = str_replace('.', '/', $name);
        $path1 = DIR_CIRCUIT_APPS.$base . '/' . $name . '.' . $type . '.php';
        $path2 = DIR_CIRCUIT_APPS.$base . '/' . $type . 's/' . $name . '.' . $type . '.php';   
        $path = file_exists( $path1 ) ? $path1 : $path2;
        @include_once($path);
      }


    public function addZoneContent($name) {   
    	return $this->instantiate($name, 'template');
    }

}

class CircuitAction {

    const NONE      = NULL;

    const ERROR     = -1;

    const INDEX     = 1;

    const INPUT     = 2;

    const ALERT     = 3;

    const SUCCESS   = 4;

    const FAILURE   = 5;

    const DISABLE   = 6;

    const REDIRECT  = 7;

    const CONFIRM   = 8;

    const INVALID   = 9;

    const AUTH      =10;

    const WARN     = 11;

    public function execute( CircuitController $c ){
        return CircuitAction::SUCCESS;
    }
}

class CircuitState extends SharedContainer
{
    function __construct($c, $namespace)
    {        
    	
        $container = (( $v = $c->getObserver()->get($namespace) ) && $v instanceof Container ) ? $v : new Container();
        parent::__construct($c->getObserver()->set($namespace, $container));
        
     }

    function __destruct()
    {
        unset($this->_data);
    }
}

/**
* CircuitConfig keeps track of information used in a front-end controller environment.
* Keeps track of url mappings to specific apps. also allows you to keep track of
* Your base url ( the base entry point ) this could be /index.php or something like that.
* @internal class.
*/

class CircuitConfig
{
   /**
    * A list of mappings of urls to apps.
    * @type array
    * @access private
    */
    private $map = array();

   /**
    * The entry point of the application.
    * @type string
    * @access private
    */
    private $base = '';


   /**
    * Load a set of mappings into the config
    * @param array
    * return array
    * @access public
    */
    public function load( $a )
    {
        if( ! is_array($a) ) return false;
        foreach($a as $k=>$v) $this->map[strtolower($k)] = strtolower($v);
        return $this->map;
    }


   /**
    * Set the base path to the front end controller
    * @param string
    * @return string
    * @access public
    */
    public function setBase($v)
    {
        return $this->base = strval($v);
    }

   /**
    * Get the base path to the front end controller
    * @return string
    * @access public
    */
    public function getBase()
    {
        return $this->base;
    }

   /**
    * Find the url to an application based on it's application name
    * @param string
    * @return string / boolean false
    * @access public
    */
    public function findPath($app)
    {
        return array_search(strtolower($app), $this->map);
    }

   /**
    * Find the application based on a url
    * @param string
    * @return string / boolean false
    * @access public
    */
    public function findApp($n)
    {
        return (isset($this->map[$n] ) ) ? $this->map[$n] : NULL;
    }
}

/**
* CircuitModel
*/
class CircuitModel extends CircuitState
{
    /**
    * I think this is a horrible idea, and that the request vars should
    * always be passed in, but ... oh well
    * @type Container
    * @access protected
    */
    protected $request;

   /**
    * Constructor
    * @param CircuitController
    * @param string
    * @return void
    * @access public
    */
    public function __construct(CircuitController $c, $n)
    {
        parent::__construct($c,$n);
        $this->request = $c->getRequest();
    }

   /**
    * Set the request
    * @param Container
    * @return void
    * @access public
    */
    public function setRequest(Container $v)
    {
        $this->request = $v;
    }
}


/**
* CircuitRequest
*/
class CircuitRequest extends CircuitState
{
   /**
    * get the args
    * @return array
    * @access protected
    */
    protected function getArgs() {
        $v = $this->get('__args__');
        if (is_array($v)) return $v;

        return array();
    }

   /**
    * get the params
    * @return array
    * @access protected
    */
    protected function getParams() {
        return $_REQUEST;
    }

    protected function setParamStatus($key, $value) {
    	if ($key === NULL) { return FALSE; }
    	if (! isset($this->paramPrevalidate)) { $this->paramPrevalidate = array(); } // build the array if it doesn't exist...
    	$this->paramPrevalidate[$key] = $value;
    	return TRUE;
	}

	protected function getParamStatus($key=NULL) {
		if ($key === NULL) { return $this->paramPrevalidate; }
		if (isset($this->paramPrevalidate[$key])) { return $this->paramPrevalidate[$key]; }
		return FALSE;
	}

	protected function setArgStatus($key, $value) {
    	if ($key === NULL) { return FALSE; }
    	if (! isset($this->argPrevalidate)) { $this->argPrevalidate = array(); } // build the array if it doesn't exist...
    	$this->argPrevalidate[$key] = $value;
    	return TRUE;
	}

	protected function getArgStatus($key=NULL) {
		if ($key === NULL) { return $this->argPrevalidate; }
		if (isset($this->argPrevalidate[$key])) { return $this->argPrevalidate[$key]; }
		return FALSE;
	}

    /**
     * load a param from the request if it is set
     * if the value is not set, the $default will be used
     *
     * @param filter see applyFilter
     * @return mixed
     * @author Jakobo
     **/
    protected function loadParam($key, $default=NULL, $filter = 'raw', $value_group=NULL) {
//        $params = $this->getParams();

//        if (isset($params[$key])) {
    	if (isset($_REQUEST[$key])) {
//            $precheck_val = $params[$key];
			$precheck_val = $_REQUEST[$key];

            if ( is_array($value_group) && ! in_array($precheck_val, $value_group) ) {
                $precheck_val = NULL;
            }

            // go and get the filtered value...
            $value = $this->applyFilter($precheck_val, $filter, $default);
            if ($value === NULL){
            	// filtering stripped off any available value...
            	$this->setParamStatus($key, FALSE);
                return NULL;
            } else {
            	// was it a passthrough or not? if passthrough, don't mark a field as pre-validated!
            	if ($filter == 'raw' || $filter == NULL) { $this->setParamStatus($key, FALSE); }
            	else { $this->setParamStatus($key, TRUE); }
                return $this->set($key, $value);
            }
        }

        if ($default === NULL) {
        	//$this->setParamStatus($key, FALSE);
            return NULL;
        }

        return $this->set($key, $default);

    }

    /**
     * load an argument by it's index value into a key position.
     * if the index value is not set, the $default will be used
     *
     * @param filter see applyFilter
     * @return mixed
     * @author [72]
     **/
    protected function loadArg($index, $key, $default = NULL, $filter = 'raw') {
    	
        $args = $this->getArgs();
        if (isset($args[$index])) {
            $value = $this->applyFilter($args[$index], $filter, $default);
            if ($value === NULL){
            	$this->setArgStatus($key, FALSE);
                return NULL;
            } else {
            	if ($filter == 'raw' || $filter == NULL) { $this->setArgStatus($key, FALSE); }
            	else { $this->setArgStatus($key, TRUE); }
                return $this->set($key, $value);
            }
        }

        if ($default === NULL) {
        	//$this->setArgStatus($key, FALSE);
            return NULL;
        }

        return $this->set($key, $default);

    }

    /**
     * apply basic input validation filter
     * @param filter
     *   available filters:
     *   'safe'     => remove '<', '>', '"', "'", '#', '&', '%', '{', and '('
     *   'posint'   => if not all digits, return default value
     *   'int'      => similar to postint, but negative allowed
     *   'alpha'    => if not all alphabets, return default value
     *   'alphanum' => if not all digits and alphabets, return default value
     *   'numeric'  => if not looks like a number, return default value
     *   'bool'     => evaluate $value as boolean, TRUE or FALSE is returned
     *   'regex'    => return $value if regex is matched, default value otherwise.
     *                 To use 'regex', pass in array('regex' => '/happy regex/i') for $filter
     *   'enum'    => return $value if regex is matched, default value otherwise.
     *                 To use 'enum', pass in array('enum' => array('a','b','c','d',...)) for $filter
     *   'raw'      => return $value untouched
     * @return scalar
     * @author llee
     */
    protected function applyFilter($value, $filter, $default_value) {

        if ( is_array($filter) ) {
            switch(key($filter)) {
            case 'regex':
                $pattern = $filter['regex'];
                $filter = 'regex';
                break;
            case 'enum':
                $pattern = $filter['enum'];
                $filter = 'enum';
                break;
            default:
                // nothing...
                break;
            }
        }

        switch ($filter) {
        case 'posint':
            return ctype_digit($value) ? $value : $default_value;
        case 'int':
            return (ctype_digit($value) ||
                      ($value[0] == '-' && ctype_digit(substr($value, 1)))
                      )
                 ? $value : $default_value;
        case 'alpha':
            return ctype_alpha($value) ? $value : $default_value;
        case 'alphanum':
            return ctype_alnum($value) ? $value : $default_value;
        case 'numeric':
            return is_numeric($value) ? $value : $default_value;
        case 'bool':
            return $value ? TRUE : FALSE;
        case 'raw':
            return $value;
        case 'enum':
            return in_array($value, $pattern) ? $value : $default_value;
        case 'regex':
            return preg_match($pattern, $value) ? $value : $default_value;
        case 'safe':
        default:
            $value = str_replace(array('<', '>', '"', "'",  '&', '%', '{', '('), '', $value);
            // set to default value if there is nothing left after filtering
            return $value ? $value : $default_value;
        }
    }


	//
	// note: the functions getParams and loadParam above replace this function completely.
	//       will have to remove references first, then remove from here.
	//
	public function getRequestInput($request_name, $name_to_save, $get_post_order, $default_value=NULL)
	{
		//echo 'stop using getRequestInput(), use loadArg() or loadParam()'; die;
		$this->loadParam($request_name,$default_value);
		if ($request_name != $name_to_save)
		{
			$param = $this->get($request_name);
			$this->set($name_to_save,$param);
			$this->remove($request_name);
		}
	}

}

class CircuitActionCode {
    public $code;
    public function __construct( $code ){ $this->code = $code; }
}


// define a bunch of default types to use
// for a given action

define( 'VIEW_NONE',         CircuitAction::NONE );

define( 'VIEW_ERROR',        CircuitAction::ERROR );

define( 'VIEW_INDEX',        CircuitAction::INDEX );

define( 'VIEW_INPUT',        CircuitAction::INPUT );

define( 'VIEW_ALERT',        CircuitAction::ALERT );

define( 'VIEW_SUCCESS',      CircuitAction::SUCCESS );

define( 'VIEW_FAILURE',      CircuitAction::FAILURE );

define( 'VIEW_DISABLE',      CircuitAction::DISABLE );

define( 'VIEW_REDIRECT',     CircuitAction::REDIRECT );

define( 'VIEW_CONFIRM',      CircuitAction::CONFIRM );

define( 'VIEW_INVALID',      CircuitAction::INVALID );

define( 'VIEW_AUTH',        CircuitAction::AUTH );

define( 'VIEW_WARN',        CircuitAction::WARN );


define('CIRCUIT_APP_404', 'Default.404');

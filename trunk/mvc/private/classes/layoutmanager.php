<?php
/**
* Responsible for Rendering the Gaia Page.  It goes hand in hand
* with replacing generateGaiaPageHeader() and generateGaiaPageTail()
* it also manages template and singleton container items.
* @author Jakob Heuser
*/

/**
* Singleton class for rendering the Gaia Page
*/
class LayoutManager {

    /**
     * Singleton Class: constructor calls exit();
     */
    function __construct() { error_log("LayoutManager cannot be called as an instance"); exit; }

    /**
     * Paramters for the layout manager  this is private, but part of the cache busting mayhem :D
     * Changing these causes a CSS RELOAD
     */
    public function Initialize() {
        return true;
    }

    /**
     * Renders the page, including headers and footers
     * the results of Render() are output directly to the screen
     * @param mixed $templates a list of templates to render in order
     */
    public function Render($list = NULL) {

        // null check
        if ($list === NULL) $list = array();

        // make sure we have an array of templates
        if (!is_array($list)) {
            $list = explode(",", $list);
        }
        foreach ($list as $k => $v) {
            $list[$k] = trim($v);
        }

        $data = self::data();
        self::RenderContent($list);
    }

    /**
     * Sets the page title, Gaia Online :: is automatically prepended
     * @param string $title Title of the page
     */
    public function SetPageTitle($title) {
        self::data()->set("LYT_PAGE_TITLE", $title);
    }

    /**
     * Sets an error message to populate an error message panel
     * @param string $msg Error message
     */
    public function SetErrorMessage($msg) {
        self::data()->set("ERROR_MESSAGE", $msg);
    }

    /**
     * Sets the body ID.  Depreciated, please plan on class names instead
     * @depc Jun 07 2006
     * @param $id the id to set for the body
     */
    public function SetBodyId($id = "") {
        self::data()->set("LYT_BODY_ID", $id);
    }



    /**
     * disables all queries in the header. This is used by critical message
     * die functions in order to make sure that you don't try and load
     * session information or anything like that.
     * @param bool $v queries will be disabled if set to true
     */
    public function DisableQueries($v = true) {
        self::data()->set("options.disable_queries", $v);
    }

    /**
     * Enable or Disable the Navigation
     * @param bool $v if set to false, the navigation will be disabled on render
     */
    public function DisableNavigation($v = true) {
        self::data()->set("LYT_DISABLE_NAVIGATION", !$v);
    }

    /**
     * Disables the display of gold
     * @param bool $v a value of TRUE will disable the gold
     */
    public function DisableGoldDisplay($v = true) {
        self::data()->set("options.disable_gold", $v);
    }

    /**
     * Disable the display of GPass
     * @param bool $v a value of TRUE will disable the gpass
     */
    public function DisableCreditDisplay($v = true) {
        self::data()->set("options.disable_credit", $v);
    }

	/**
	 * Disables display of the login form in the global header
	 */
	public function disableHeaderLogin() {
		self::data()->set('LOGIN_HIDE_FORM',true);
	}

    /**
     * Enable the Ticket Display with a set amount of tickets
     * Setting tickets will automatically disable gold and gift credits
     * @param int $v a number of tickets to display
     */
    public function EnableTicketDisplay($v) {
        self::DisableGoldDisplay();
        self::DisableCreditDisplay();

        $data = self::data();
        $data->set("options.enable_tickets", TRUE);
        $data->set("values.tickets", $v);
    }

    /**
     * Enable the display of advertisements for this module, you can
     * specify a specific zone to turn the banner on for
     * @param int $zone defines the zone for ads
     */
    public function EnableAdvertisements($zone = 1) {
        self::data()->set("values.advertising_zone", $v);
    }


    /**
     * Enable the display of the donation advertisement.
     * It overrides the normal ad sidebar
     * @param bool donation ad will be used if true
     */
    public function EnableDonationAdvertisements($v = true) {
        return FALSE;
    }

    /**
     * Enables the tour sidebar
     * the your sidebar offers to the user the ability to take the
     * gaia tour.  It is primarily for landing pages, and added
     * as part of the sidebar content switcher
     * @param bool tour sidebar will be used if true
     */
    public function EnableTourSidebar($v = true) {
        self::data()->set("options.enable_tour_sidebar", $v);
    }

    /**
     * Enables the admin panel.
     * Using this places the script in admin panel mode, where different
     * render calls will be made for the header and footer.
     * This lets admin panels run in their own layout.
     */
    public function EnableAdminPanel($v = TRUE) {
        self::data()->set("options.enable_admin_panel", $v);
    }

    public function EnableSimpleHeader($v = TRUE) {
        self::data()->set("options.enable_simple_header", $v);
    }

    /**
     * Set the "current page" URL.  This is helpful if you don't want the
     * login / redirect to come right back to this page.  If you don't set
     * this, then a value from $_SERVER will be used, so no harm done.
     * @param string $url the URL of the current page for the header
     */
    public function SetCurrentPageURL($url) {
        self::data()->set("values.current_url", $url);
    }

    /**
	 * Adds a template to be rendered just following the <body> tag.
	 * IMPORTANT:
	 * This is intended to be used ONLY for functionality like the YUI
	 * history manager which requires some static content to be on the
	 * page as close to the top as possible. It is NOT intended to be
	 * used to override the standard page layouts. Please have your
	 * code audited if you intend to use this.
	 * @author tlynn
	 * @param {String} path The path of the template to output
	 **/
	public function addPrePageContent($path) {
		$data = self::data();
		$data->append('prepagecontent',$path);
	}

    /**
     * Add an external script for parsing.  Many scripts make use of script_str
     * but this is the formal way for adding a script
     * @param string $path full http:// path to the script
     * @param string $type language type, default is text/javascript
     */
    public function AddScript($path, $type="text/javascript") {
        if (strpos($path, 'http://') !== FALSE) {
            return self::AddExternalScript($path, $type);
        }

        self::data()->append("script_js", array(
                                         "path" => $path,
                                         "type" => $type
                                         ));

    }

    public function AddExternalScript($path, $type="text/javascript") {
        self::data()->append("ext_script_js", array(
                                             "path" => $path,
                                             "type" => $type
                                             ));
    }

    /**
     * Add an external script for parsing.  Many scripts make use of script_str
     * but this is the formal way for adding a script
     * @param string $path full http:// path to the script
     * @param string $media the media type, default is "screen"
     */
    public function AddCSS($path, $media = "screen") {
        self::data()->append("script_css", array(
                                          "path" => $path,
                                          "media" => $media
                                          ));
    }

    //add css with IE conditionals
    //same params as AddCSS with an additional INTEGER for ie_version
    public function AddCSS_IE( $path,  $ie_version = '', $media = "screen") {
        self::data()->append("script_css_ie", array(
                                             "path" => $path,
                                             "media" => $media,
                                             "ie_version" => $ie_version
                                             ));
    }

    /**
     * Add an external RSS script for parsing.
     * @param string $path
     * @todo All. currently a stub
     */
    public function AddRSS($path) {}

    /**
     * Place raw script data into the header.  Used by legacy code
     * @param string $raw raw data to inject in the HTML Head tag
     */
    public function AddRawScripts($raw) {
        self::data()->set("LYT_SCRIPT_RAW", self::data()->get("LYT_SCRIPT_RAW") . $raw);
    }

    /**
     * Set an application level cachebuster
     * this is useful for situations where you need to bust the cache
     * pass in an int value and it will add ?XX to the includes
     */
    public function setApplicationCacheBuster($v = 0) {
        self::data()->set("values.app_cachebuster", $v);
    }

    /**
     * Set an master level cachebuster
     * this is useful for situations where you need to bust the cache
     * pass in an int value and it will add ?XX to the includes
     */
    public function setMasterCacheBuster($v = 0) {
        self::data()->set("settings.cache", $v);
    }


    /**
     * Allows users to add META data to the <head> area of a page.
     * Useful if you're generating your own META redirects.
     */
    public function setMeta($v) {
        self::data()->set("META", $v);
    }

    public function setupDailyCandy($section, $show_daily_candy = TRUE ){
        self::data()->set("DAILY_CANDY_SECTION", $section);
        self::data()->set('SHOW_DAILY_CANDY', $show_daily_candy);
    }

    /**
     * Disables frob generation for Gapi toolbar
     *
     */
    public function disableGapi(){
        self::data()->set('gapi_disable', TRUE);
    }


    public function RenderHeader() {
         include DIR_INCLUDES . 'layout/header.php';
        
    }
    
    public function RenderFooter() {
        include DIR_INCLUDES . 'layout/footer.php';
    }


    // ------------------------------------------------
    //
    // All methods below this are Internal
    //
    // ------------------------------------------------

    /**
     * Data function returns a container object, where all internal
     * data is stored.
     * @return Container
     * @access private
     */
    private function data() {
        static $data;

        if (isset($data))
            return $data;

        $data = new Container();

        $params = array(
            "cache" => (SC::get('board_config.always_cache_bust')) ? SC::get('board_config.time_now').'_'.mt_rand(1,999999) : SC::get('board_config.cache_bust'),
            'yui_version' => '2.6.0',
            );

        $data->set("settings", $params);
        // Until all content is in grids, we need this var
        // REMOVE ONCE EVERY SINGLE PAGE ON THE SITE IS IN GRIDS
        $data->set('enable_nongrid', TRUE);

        if( isset( $_GET['login_success'] ) &&  SC::get('userdata.user_id') < 1 && empty( $_COOKIE ) ){
            SC::set('board_config.sys_message', 'Gaia Online requires browser cookies. Please enable cookies in your browser and try again. Mmmm cookies.');
        }
        $data->set('ext_script_js', array());
        $data->set('script_js', array());
        $data->set('script_css', array());
        $data->set('script_css_ie', array());

        return $data;
    }


    /**
     * Renders the body regions.
     * an array of body regions is rendered in order using pparse.  This is part
     * of the rendering encapsulation process
     * @param mixed $templates an array of templates to parse
     */
    private function RenderContent($list) {
        foreach ($list as $tplname) SC::get("template")->pparse($tplname);
    }
  

    private function initializeGapiJS(){
        // CONSTANTS

        //toolbar board config enable check
        //0 = Toolbar completely disabled
        //1 = Toolbar enabled for mods/donators only
        //2 = Toolbar enabled for everyone


        //Freecause Toolbar Frob Generation
        //Only generate frob if user is not logged in AND fc_toolbar_level > 0

        if(SC::get('board_config.fc_toolbar_level') > 0){
            if( !SC::get('userdata.session_logged_in') ){
                require_once(DIR_CLASSES. '/gapi/authentication.php');
                $auth = new GapiAuthentication();
                $frob = session_get('frob');
                if(!$frob or (session_get('frob_time') + 240 < SC::get('board_config.time_now') )){
                    $frob = $auth->getFrob(FREECAUSE_API_KEY);
                    session_set('frob',$frob);
                    session_set('frob_time', SC::get('board_config.time_now'));
                }

                self::data()->set('LYT_FROB',$frob);
                if(isset($_REQUEST['toolbar_id']) && ctype_digit($_REQUEST['toolbar_id'])){
                    self::data()->set('LYT_TOOLBAR_ID', $_REQUEST['toolbar_id']);
                }
            }




        }
    }



 
   
}

class LM extends LayoutManager {
    function __construct() { error_log("LayoutManager cannot be called as an instance"); exit; }
}

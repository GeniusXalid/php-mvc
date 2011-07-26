<?PHP

/**
 * Class used to hold request data.  Useful for keeping down local variables.
 * Can also set values based on simple IF and IFF
 * Container.php
 * @author     Jakobo <rjheuser@gaiaonline.com>
 * @version    $LastChangedRevision$
 * @package    DataStorage
 */

/**
 * required file: parent class
 */
require_once(DIR_CLASSES . "container/container.php");

/**
 * @author     Jakobo <rjheuser@gaiaonline.com>
 * @version    $LastChangedRevision$
 * @package    DataStorage
 */
class RequestContainer extends Container
{
	
	/**
	 * An array of valid request methods
	 * @access private
	 * @type array
	 */
	protected $_valid_methods;

	/**
	 * An array of errors this container has encountered
	 * @access private
	 * @type array
	 */
	protected $_errors;

	/**
	 * An array of error codes for reference
	 * @access private
	 * @type array
	 */
	protected $_error_codes;

	/**
	 * RequestContainer()
	 * Default constructor for the RequestContainer object.
	 * @returns NULL
	 * @access public
	 */
	function RequestContainer()
	{
		$this->_valid_methods = array("GET","POST","COOKIE","SERVER");
		$this->_errors = array();
		$this->_error_codes = array(
			"warning" => 100,
			"critical" => 300
		);
	}
	
	/**
	 * setFromRequest(string, string, mixed[, string[, bool]])
	 * Set a value based on the contents of the request data
	 * <code>
	 * $myRequest->setFromRequest("foo", "formFoo", "thereWasNoFoo?", "POST");
	 * </code>
	 * @param string $name name of variable to set
	 * @param string $formName name to check in $_METHOD
	 * @param mixed $default [optional] default value to set if no matches found
	 * @param string $method [optional] list of methods, comma separated to check
	 * @returns mixed value that was set (if any)
	 * @access public
	 */
	function setFromRequest($name, $formName, $default="", $method="GET,POST")
	{
		$value_found = false;
		$methods = explode(",",$method);
		foreach ($methods as $currentMethod) {
			if ($this->_isValidMethod($currentMethod)) {
				$request_name = "_".strtoupper($currentMethod);
				// eval("\$temp_value = \$".addslashes($request_name)."['".addslashes($formName)."'];");
				if (isset($GLOBALS[$request_name][$formName])) {
					$value_found = true;
					$value = $GLOBALS[$request_name][$formName];
				}
				
			}
		}
		if (!$value_found) {
			$value = $default;
		}

		$this->set($name, $value);
		return $value;
	}
	
	/**
	 * setIfExists(string, string[, mixed[, mixed[, string]]])
	 * Set an internal variable if the Form Name is set, or set an alternate if
	 * not set
	 * <code>
	 * $myRequest->setIfExists("foo", "formFoo", "fooWasThere",
	 *    "noFoo4U", "POST,GET");
	 * </code>
	 * @param string $name name of variable to set
	 * @param string $formName name to check in $_METHOD
	 * @param mixed $t_value [optional] value to use if found
	 * @param mixed $f_value [optional] value to use if not found
	 * @param string $method [optional] list of methods, comma seperated to check
	 * @returns mixed value that was set based on found or not found
	 * @access public
	 */
	function setIfExists($name, $formName, $t_value=true,
	   $f_value=false, $method="POST")
	{
		$methods = explode(",",$method);
		foreach ($methods as $currentMethod) {
			if ($this->_isValidMethod($currentMethod)) {
				$request_name = "_".$method;
				if ((!empty($GLOBALS[$request_name][$formName])) || ($GLOBALS[$request_name][$formName] === 0)) {
					$value = $t_value;
				} else {
					$value = $f_value;
				}
			
				$this->set($name, $value);
			}
		}
		if (!$this->isEmpty($name)) {
			return $value;	
		} else {
			return NULL;
		}
	}
	
	/**
	 * setIfOnlyIfExists(string, string[, mixed[, string]])
	 * Set a variable If (and only) If a variable is found by the given name in
	 * the given method
	 * <code>
	 * $myRequest->setIfOnlyIfExists("foo", "formFoo", "fooInGet!", "GET");
	 * </code>
	 * @param string $name name of variable to set
	 * @param string $formName name to check in $_METHOD
	 * @param mixed $t_value [optional] value to use if found
	 * @param string $method [optional] list of methods, comma seperated to check
	 * @returns mixed value that was set (or empty variable on fail)
	 * @access public
	 */
	function setIfOnlyIfExists($name, $formName, $t_value=true, $method="POST")
	{
		$methods = explode(",",$method);
		foreach ($methods as $currentMethod) {
			if ($this->_isValidMethod($currentMethod)) {
				$request_name = "_".$method;
				if ((!empty($GLOBALS[$request_name][$formName])) || ($GLOBALS[$request_name][$formName] === 0)) {
					$value = $t_value;
					$this->set($name, $value);
				}
			}
		}

		if (!$this->isEmpty($name)) {
			return $value;	
		} else {
			return NULL;
		}
	}
	
	/**
	 * getFormMethods(bool)
	 * Return the valid methods currently in use by this class
	 * <code>
	 * $methods = $myRequest->getFormMethods();
	 * </code>
	 * @param bool $array return result as an array (not ready to reuse in class)
	 * @returns mixed methods used by class
	 * @access public
	 */
	function getFormMethods($array = false)
	{
		if ($array) {
			$return_methods = $this->$_valid_methods;
		} else {
			$return_methods = implode(",", $this->_valid_methods);
			return $return_methods;
		}
	}
	
	/**
	 * _isValidMethod(string)
	 * Returns if the method provided is a valid method
	 * <code>
	 * if ($this->_isValidMethod($method)) { ... }
	 * </code>
	 * @returns bool boolean value if method is valid
	 * @access private
	 */
	function _isValidMethod($method)
	{
		$method = strtoupper($method);
		if (in_array($method, $this->_valid_methods)) {
			return true;
		}
		return false;
	}
	
	/**
	 * _setError(int, string, string)
	 * Sets an error message.
	 * <code>
	 * $this->_setError(100, "Variable $name does not exist.", __FUNCTION__);
	 * </code>
	 * @param int $error_code the error code set
	 * @param string $error_message message to save
	 * @param string $function_name function called from
	 * @access private
	 */
	function _setError($error_code, $error_message, $function_name)
	{
		$this->_errors[$error_code][] = $function_name . " :: " . $error_message;
	}
	
}

?>
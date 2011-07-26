<?PHP
require_once( DIR_CLASSES . 'container/container.php');
/**
 * Class used to hold request data.  Useful for keeping down local variables.
 * Can also set values based on simple IF and IFF
 * Container.php
 * @author     Jakobo <rjheuser@gaiaonline.com>
 * @version    $LastChangedRevision$
 * @package    DataStorage
 */

/**
 * @author     Jakobo <rjheuser@gaiaonline.com>
 * @version    $LastChangedRevision$
 * @package    DataStorage
 */
class DataTypeContainer extends Container
{
	/**
	 * Container()
	 * Default constructor for the DataTypeContainer object.
	 * @returns NULL
	 * @access public
	 */
	function Container()
	{
		parent::Container();
	}

    function setBoolean( $n, $v )
    {
        $v = strtolower( $v );
        static $valid_input = array("1"=>true, "true"=>true, "yes"=>true, "0"=>false, "false"=>false, "no"=>false);
		if (!in_array($v, array_keys($valid_input))) return NULL;
		return $this->set( $n, $valid_input[$v] );
    }
    
    function setInt( $n, $v )
    {
        if( ! is_numeric( $v ) ) return NULL;
        return $this->set( $n, intval($v) );
    }
    
    function setFloat( $n, $v )
    {
        if( ! is_numeric( $v ) ) return NULL;
        return $this->set( $n, floatval( $v ) );
    }
    
    function setString( $n, $v )
    {
        if( !is_string( $v ) ) return NULL;
        return $this->set( $n, strval($v) );
    }
    
    function setArray( $n, $v )
    {
        if( is_string( $v ) ) $v = @unserialize( $v );
        if( ! is_array( $v ) ) return NULL;
        $this->set( $n, $v );
    }
}

?>
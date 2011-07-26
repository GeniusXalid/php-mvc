<?php
/**
 * This is a bundle of several classes. Currenlty it contains:
 *          Container, Containerbase, SingletonContainer, SC, Shared Container
 */

class ContainerBase
{

    /**
    * set a variable into the container by reference.
    * @param array     A reference to an array
    * @param string    The name of the variable to be retrieved
    * @param mixed     The variable to be assigned to the namespace.
    * @return mixed    the value passed into the set function
    * @access private
    * @static
    */
    static function & set(&$v, $name, &$value)
    {
        $b = explode('.', $name);
        $ct = count( $b );
        $end = $ct -1;
        for( $i = 0; $i < $ct; $i++)
        {
            $n = $b[$i];
            if( $i == $end ) return $v[$n] =& $value;
            if( !isset( $v[$n] ) ) 
            {
                $v[$n] = array();
            }
            elseif( $v[$n] instanceof Container ) 
            {
                return $v[$n]->setByRef( implode('.', array_slice($b, $i+1) ), $value );
            }
            elseif( ! is_array($v[$n]) ) 
            {
                $v[$n] = array();
            }
            $v =& $v[$n];
        }
        return $f = FALSE;
    }
    
    function & move( &$v, $target, $destination )
    {
        $r =& ContainerBase::set($v, $destination, ContainerBase::get($v, $target) );
        ContainerBase::remove($v, $target);
        return $r;
    }
    
   /**
    * append a variable on to the end of an array
    * @param array     A reference to an array
    * @param string    The name of the variable to be retrieved
    * @param mixed     The variable to be assigned to the namespace.
    * @return mixed    the value passed into the set function
    * @access private
    * @static
    */
    static function append( &$v, $name, $value )
    {
        $b = explode('.', $name);
        $ct = count( $b );
        $end = $ct -1;
        for( $i = 0; $i < $ct; $i++)
        {
            $n = $b[$i];
            if( !isset( $v[$n] ) && $i!=$end) 
            {
                $v[$n] = array();
                $v =& $v[$n];
                continue;
            }
            elseif( ! isset($v[$n]) ) 
            {
                $v[$n] = array();
            } 
            elseif( $v[$n] instanceof Container ) 
            {
                return $v[$n]->append( implode('.', array_slice($b, $i+1) ), $value );
            }
            elseif( is_string($v[$n]) ) 
            {
                return $v[$n] .= $value;
            }
            elseif( ! is_array($v[$n]) ) 
            {
                $v[$n] = array();
            } 
            elseif( is_array($v[$n]) && $i!=$end) 
            {
                $v =& $v[$n];
                continue;
            }
            if( $i == $end ) return $v[$n][] =& $value;
            if( empty($v[$n]) ) $v[$n][] = array();
            $max = max( array_keys( $v[$n] ) );
            if( ! is_numeric( $max ) ) $max = 0;
            $v =& $v[$n][$max];
        }
        return FALSE;
    }
    
   /**
    * append a variable on to the end of an array
    * @param array     A reference to an array
    * @param string    The name of the variable to be retrieved
    * @param mixed     The variable to be assigned to the namespace.
    * @return mixed    the value passed into the set function
    * @access private
    * @static
    */
    static function addNode( &$v, $name, $value )
    {
        $b = explode('.', $name);
        $ct = count( $b );
        $end = $ct -1;
        for( $i = 0; $i < $ct; $i++)
        {
            $n = $b[$i];
            if( !isset( $v[$n] ) ) 
            {
                $v[$n] = array();
            }
            elseif( $v[$n] instanceof Container ) 
            {
                return $v[$n]->append( implode('.', array_slice($b, $i+1) ), $value );
            }
            elseif( is_string($v[$n]) ) 
            {
                return $v[$n] .= $value;
            }
            elseif( ! is_array($v[$n]) ) 
            {
                $v[$n] = array();
            }
            if( $i == $end ) return $v[$n][] =& $value;
            if( empty($v[$n]) ) $v[$n][] = array();
            $max = max( array_keys( $v[$n] ) );
            if( ! is_numeric( $max ) ) $max = 0;
            $v =& $v[$n][$max];
        }
        return FALSE;
    }
    
    /**
     * Test if a variable exists in the container specified
     * @param array  The global container to search
     * @param string Name of variable to check
     * @returns bool true if exists
     * @access private
     * @static
     */    
     static function exists( &$v, $name )
     {
        $b = explode('.', $name);
        $end = count( $b ) - 1;
        for( $i = 0; $i <= $end; $i++)
        {
            $n = $b[$i];
            if( ! array_key_exists( $n, $v) ) return FALSE;
            if( $i == $end ) return TRUE;
            if( $v[$n] instanceof Container ) 
            {
                return $v[$n]->exists( implode('.', array_slice($b, $i+1) ) );
            }
            if( ! is_array($v[$n]) ) return FALSE;
            $v =& $v[$n];
        }
        return FALSE;
    }
    
    /**
     * Test if a variable is empty
     * @param array  The global container to search
     * @param string Name of variable to check
     * @returns bool
     * @access private
     * @static
     */    
     static function isEmpty( &$v, $name )
     {
        $value = ContainerBase::get($v, $name);
        return empty( $value );
    }

   /**
    * remove a variable from the container.
    * @param array     A reference to the container where the var is stored.
    * @param string    The name of the variable to be removed
    * @return bool    TRUE on success, else returns FALSE
    * @access public
    * @static
    */
    static function remove( &$v, $name )
    {
        $b = explode('.', $name);
        $end = count( $b ) -1;
        for( $i = 0; $i <= $end; $i++)
        {
            $n = $b[$i];
            if( !isset( $v[$n] ) ) return NULL;
            if( $i == $end ) 
            {
                $value =& $v[$n];
                unset( $v[$n] );
                return $value;
                
            }
            if( $v[$n] instanceof Container ) 
            {
                return $v[$n]->remove( implode('.', array_slice($b, $i+1) ) );
            }
            if( ! is_array($v[$n]) ) return NULL;
            $v =& $v[$n];
        }
        return NULL;
    }
    
   /**
    * get a variable from the container.
    * @param array     A reference to the container to retrieve from.
    * @param string    The name of the variable to be retrieved
    * @return mixed    The info assoc with the namespace, else NULL.
    * @access public
    * @static
    */
    static function & get( &$v, $name)
    {
        $null = null;
        $b = explode('.', $name);
        $end = count( $b ) -1;
        for( $i = 0; $i <= $end; $i++)
        {
            $n = $b[$i];
            if( !isset( $v[$n] ) ) return $null;
            if( $i == $end ) return $v[$n];
            if( $v[$n] instanceof Container ) 
            {
                return $v[$n]->get( implode('.', array_slice($b, $i+1) ) );
            }
            if( ! is_array($v[$n]) ) return $null;
            $v =& $v[$n];
        }
        return $null;
    }
    
    /**
     * getNames()
     * Return a list of all variable names set in the class
     * @returns mixed array of variable names
     * @access public
     */
    static function getNames(&$v, $name = "")
    {
        if( strlen( $name )== 0 ) return array_keys($v);
        if( ! ContainerBase::exists($v, $name) ) return array();
        $i = ContainerBase::get($v, $name);
        if ( is_array( $i ) ) return array_keys( $i );
        if( $i instanceof Container ) return $i->getNames();
        return array();
    }
    
    /**
     * size([$name])
     * Returns number of elements in container or, the number of elements in a
     * @param array  A reference to an array
     * @param string $name [optional] name to get size of
     * @returns int number of elements or false if not found
     * @access public
     */
    static function size(&$v, $name = "")
    {
        if (strlen($name) == 0) return count($v);
        if( ! ContainerBase::exists($v, $name) ) return FALSE;
        $i = ContainerBase::get($v, $name);
        if ( is_array( $i ) ) return count( $i );
        if( is_numeric( $i ) ) return intval( $i );
        if( is_string( $i ) ) return strlen( $i );
        if( $i instanceof Container ) return $i->size();
        return 0;
    }
    
    /**
     * getAllData()
     * Return all data that has been stored by this class
     * @returns mixed array of internal data
     * @access public
     */
    static function & getAllData(&$v)
    {
        return $v;
    }
}

/**
 * Class used to hold data.
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
class Container
{

    /**
     * An associative array of items in the container
     * @access private
     * @type array
     */
    protected $_data = array();
    
    function __construct( $data = NULL )
    {
        // copy the data into the container.
        if( is_array( $data ) ) 
            $this->_data = $data;
        
        // if it is a container, pull all of the data into it by copy
        if( $data instanceof Container ) 
            $this->_data = $data->getAllData();
            
    }

    /**
     * set(string, mixed)
     * set a variable inside of the container
     * @param string $name name of variable to set
     * @param mixed $value value to assign to $name
     * @returns mixed value that was set
     * @access public
     */
    function & set($name, $value)
    {
        $v =& ContainerBase::set($this->_data, $name, $value);
        return $v;
    }
    
    /**
     * setByRef(string, &mixed)
     * set a variable by reference inside of the container
     * <code>
     * $myRequest->set("name", &$value);
     * </code>
     * @author 72Squared
     * @param string $name name of variable to set
     * @param mixed &$value value to assign to $name
     * @returns mixed value that was set
     * @access public
     */
    function & setByRef($name, &$value)
    {
        $v =& ContainerBase::set($this->_data, $name, $value);
        return $v;
    }
    
    /**
     * append(string, mixed)
     * append a variable on to the end of an array inside of the container
     * @param string $name name of variable to append
     * @param mixed $value value to assign to $name
     * @returns mixed value that was set
     * @access public
     */
    function append($name, $value)
    {
        return ContainerBase::append($this->_data, $name, $value);
    }
    
    /**
     * move(string, string)
     * move a variable from one spot to another
     * @param string $target name of variable to move
     * @param string $destination where the variable should go
     * @returns mixed value that was set
     * @access public
     */
    function & move($target, $destination)
    {
        $v =& ContainerBase::move($this->_data, $target, $destination);
        return $v;
    }
    
    /**
     * addNode(string, mixed)
     * used only by the template object. do not use this method unless you know
     * wtf you are doing.
     * @param string $name name of variable to append
     * @param mixed $value value to assign to $name
     * @returns mixed value that was set
     * @access public
     */
    function addNode($name, $value)
    {
        return ContainerBase::addNode($this->_data, $name, $value);
    }
    
    /**
     * get(string)
     * Return the internal value of a class variable
     * @param string $name name of variable to get
     * @returns mixed value from internal class
     * @access public
     */
    function & get($name)
    {
        $v =& ContainerBase::get($this->_data, $name);
        return $v;
    }
    
    /**
     * remove($name)
     * Remove a variable from the container. Pops it off for return
     * @param string $name name of variable to unset
     * @returns mixed value that was unset
     * @access public
     */
    function remove($name)
    {
        return ContainerBase::remove($this->_data, $name);
    }
    
    /**
     * exists($name)
     * Test if a variable exists in the container
     * @param string $name name of variable to check
     * @returns bool true if exists
     */
    function exists($name)
    {
        return ContainerBase::exists($this->_data, $name);
    }
    
     /**
     * Test if a variable is empty
     * @param string Name of variable to check
     * @returns bool
     * @access private
     * @static
     */    
     function isEmpty( $name )
     {
        return ContainerBase::isEmpty($this->_data, $name);
     }
    
    /**
     * getNames()
     * Return a list of all variable names set in the class
     * @returns mixed array of variable names
     * @access public
     */
    function getNames($name = '')
    {
        return ContainerBase::getNames( $this->_data, $name );
    }
    
    /**
     * size([$name])
     * Returns number of elements in container or, the number of elements in a
     * variable.
     * @param string $name [optional] name to get size of
     * @returns int number of elements or false if not found
     * @access public
     */
    function size($name = "")
    {
        return ContainerBase::size( $this->_data, $name );
    }
    
    /**
     * getAllData()
     * Return all data that has been stored by this class
     * @returns mixed array of internal data
     * @access public
     */
    function & getAllData()
    {
        return $this->_data;
    }
    
}

class SharedContainer extends Container
{
    function __construct( $container )
    {
	if (! $container instanceOf Container ) { throw new Exception("OMG YOU SUXOR! The container you specified for construction is not an instance of the class Container"); }
    	$this->_data =& $container->getAllData();
    }
}

// +---------------------------------------------------------------------------+
// | This file is part of the Gaiaonline website.                              |
// | Author 72squared  (john@gaiaonline.com)                                   |
// |                                                                           |
// | Copyright (c) Gaia Online 2005                                            |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code.                          |
// +---------------------------------------------------------------------------+

/**
 * @package    Gaiaonline
 *
 * @author    72squared
 *
 * @version   $Id: globalcontainer.class.php <##> <##> 72squared $
 *
 * @required  file: container.php
 */
  
/**
 * SingletonContainer
 *
 * This class provides a protected namespace container for variables
 * to be set and retrieved. The class is implemented as a pseudo-Singleton
 * All methods can be safely called statically, so the class never needs
 * to be instantiated.
 *
 * Since many of our scripts use the local scope of a script to do much
 * of our application logic, the GLOBAL namespace is not a safe space to
 * store and retrieve variables that are intended to be persistent throughout
 * the lifetime of the script. This container solves that problem by holding
 * those variables in this container. Some common examples are:
 *      $bb_config, $template, $lang, $themes, $userdata
 *
 * 
 * @author 72squared
 * 
 * @since 4/12/2005
 */
class SingletonContainer extends ContainerBase
{
   
   /**
    * get a variable from the container.
    *
    * if the var is not stored in the container, it will be
    * returned from the global scope, by default.
    *
    * @param string    The name of the variable to be retrieved
    *
    * @param bool      Do we want to check the global array?
    *
    * @return mixed    The info assoc with the namespace, else NULL.
    *
    * @access public
    * 
    * @static
    */
    static function & get( $name, $check_globals = TRUE )
    {
       
       $value =& ContainerBase::get( SingletonContainer::getAllData(), 
                                     $name);
       
       if( $value===NULL && $check_globals )
       {
            $value =& ContainerBase::get( $GLOBALS, $name );
       }
       return $value;
    
    }
    
    /**
    * set a variable into the container.
    *
    * @param string    The name of the variable to be retrieved
    *
    * @param mixed     The variable to be assigned to the namespace.
    *
    * @return mixed    the value passed into the set function
    *
    * @access public
    * 
    * @static
    */
    static function & set( $name, $value )
    {
        return ContainerBase::set(
            SingletonContainer::getAllData(), 
            $name, 
            $value);
    }
    
    /**
    * set a variable into the container by reference.
    *
    * @param string    The name of the variable to be retrieved
    *
    * @param mixed     The variable to be assigned to the namespace.
    *
    * @return mixed    the value passed into the set function
    *
    * @access public
    * 
    * @static
    */
    static function & setByRef( $name, & $value )
    {
         return ContainerBase::set(
                SingletonContainer::getAllData(), 
                $name, 
                $value );
    }
    
    /**
    * set a variable into the container and also pass it into the global scope.
    *
    * @param string    The name of the variable to be retrieved
    *
    * @param mixed     The variable to be assigned to the namespace.
    *
    * @return mixed    the value passed into the set function
    *
    * @access public
    * 
    * @static
    */
    static function & setGlobal( $name, $value )
    {
      
        return ContainerBase::set(
            SingletonContainer::getAllData(), 
            $name, 
            ContainerBase::set(
                        $GLOBALS, 
                        $name, 
                        $value));
        
      
    }
    
   /**
    * sets a reference from the global scope to the container.
    *
    * @param string    The name of a variable on the global scope 
    *                  to be added to the container
    *
    * @return mixed    FALSE if the var cannot be set, else the variable ref.
    *
    * @access public
    * 
    * @static
    */
    static function & setFromGlobal( $name )
    {
        $v =& ContainerBase::get($GLOBALS, $name );
        if( $v===NULL )
        {
            return FALSE;
        }
        return SingletonContainer::setByRef( 
                               $name, 
                               $v );
    }
    
    /**
     * move(string)
     * move a variable from one spot to another
     * @param string $target name of where the variable is now
     * @param string $destination where the variable will be moved to
     * @returns mixed value that was set
     * @access public
     */
    function & move($target,$destination)
    {
        $v =& ContainerBase::move(SingletonContainer::getAllData(), $target, $destination);
        return $v;
    }
    
	/**
	 * append(string, mixed)
	 * append a variable on to the end of an array inside of the container
	 * @param string $name name of variable to append
	 * @param mixed $value value to assign to $name
	 * @returns mixed value that was set
	 * @access public
	 */
	static function append($name, $value)
	{
		return ContainerBase::append(SingletonContainer::getAllData(), $name, $value);
	}
	
	/**
	 * appendByRef(string, mixed)
	 * append a variable on to the end of an array inside of the container by reference
	 * @param string $name name of variable to append
	 * @param mixed $value value to assign to $name
	 * @returns mixed value that was set
	 * @access public
	 */
	static function appendByRef($name, & $value)
	{
		return ContainerBase::append(SingletonContainer::getAllData(), $name, $value);
	}

    
   /**
    * remove a variable from the container.
    *
    * @param string    The name of the variable to be removed
    *
    * @param bool      Do we want to clear from global scope?
    *
    * @return bool    TRUE on success, else returns FALSE
    *
    * @access public
    * 
    * @static
    */
    static function remove( $name, $clear_from_global = FALSE )
    {

        $result =& ContainerBase::remove(
                        SingletonContainer::getAllData(),
                        $name );
        if( ! $clear_from_global ) return $result;
        
        return ContainerBase::remove(
                        $GLOBALS,
                        $name );
                        
        
    }
    
    /**
     * Test if a variable exists in the container
     *
     * @param string $name name of variable to check
     *
     * @param bool   Do we want to look in the global scope?
     *
     * @returns bool true if exists
     *
     * @access public
     * 
     * @static
     */
    static function exists($name, $check_globals = FALSE )
    {
        $result = ContainerBase::exists(
                        SingletonContainer::getAllData(),
                        $name);
        if( $result ) return TRUE;
        if( $check_globals ) 
        {
            return ContainerBase::exists(
                            $GLOBALS,
                            $name );
        }
        return FALSE;
    }
    
    /**
     * Test if a variable is empty
     * @param string Name of variable to check
     * @returns bool
     * @access private
     * @static
     */    
     static function isEmpty( $name, $check_globals = FALSE )
     {
         $result = ContainerBase::isEmpty(
                        SingletonContainer::getAllData(),
                        $name);
        if( ! $result ) return FALSE;
        if( $check_globals ) 
        {
            return ContainerBase::isEmpty(
                            $GLOBALS,
                            $name );
        }
        return TRUE;
     }
    
    /**
     * Return a list of all variable names set in the class
     * 
     * @returns mixed array of variable names
     *
     * @access public
     *
     * @static
     */
    static function getNames( $with_globals = FALSE )
    {
        
        $names = array_keys( SingletonContainer::getAllData() );
        
        if( $with_globals )
        {
            $names = array_merge( $names, array_keys( $GLOBALS ));
        }
        
        return $names;

    }
    
    /**
     * Returns number of elements in container or, the number of elements in a
     * variable
     *
     * @param string $name [optional] name to get size of
     *
     * @returns int number of elements or false if not found
     *
     * @access public
     *
     * @static
     */
    static function size($name = "", $check_globals = FALSE )
    {
        
        if (strlen($name) == 0) 
        {
            // no size specified
            $size = sizeof(SingletonContainer::getAllData());
            if( $check_globals) $size += sizeof($GLOBALS);
            return $size;
            
        }
        
        $v =& SingletonContainer::get( $name, $check_globals );
        
        return sizeof( $v );
    }
    
   /**
    * Returns a reference to the container array.
    *
    * Although access to this array is public, do not access this
    * array or manipulate it unless you know what you are doing.
    * This is really intended as a singleton private container.
    *
    * @return array
    *
    * @access public
    *
    * @static
    */
    public static function & getAllData()
    {
        
        return self::$vars;
    }
    
  static $vars = array();
    
}

class SC extends SingletonContainer
{

}

?>
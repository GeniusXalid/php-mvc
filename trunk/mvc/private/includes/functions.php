<?php
/***************************************************************************
 *                               functions.php
 ***************************************************************************/


function load_libraryfunction( $function )
{
    $function = strtolower( $function );
    $lib_function = 'funclib_' . $function;
    if( function_exists( $lib_function ) ) return $lib_function;
    include_once( DIR_INCLUDES . 'function_library/' . $function . '.func.php');
    return $lib_function;
}

function encode_ip($dotquad_ip){ if( $f = load_libraryfunction( __FUNCTION__ ) ) return $f($dotquad_ip); }
function buffer_browser_output(){ if( $f = load_libraryfunction( __FUNCTION__ ) ) return $f();}
function metered_release($key){ if( $f = load_libraryfunction( __FUNCTION__ ) ) return $f($key);}
function get_user_ip()
{
	$result = FALSE;
	$fallback=false;
	$fallback_ip_pattern='10.50.';//change this to match whatever IP you preferred (ip office for example)
	//fill the array with candidates IP from various resources
	$ips = isset( $_SERVER['HTTP_X_FORWARDED_FOR'])  ? explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']) : array();
	if( isset( $_SERVER['REMOTE_ADDR'] ) ) $ips[]=$_SERVER['REMOTE_ADDR'];
	if( isset( $_SERVER['HTTP_CLIENT_IP'] ) ) $ips[]=$_SERVER["HTTP_CLIENT_IP"];

	foreach ($ips as $ip)//for all the ips, work on it one by one based on patterns given down here
	{
		if (!preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/",$ip)) continue;//if it doesnt	 match the pattern then skip
		elseif (!preg_match('/^10\.|^127\.|^172\.(?:1[6-9])\.|^224\.|^240\.|^192\.168\./', $ip))//thanks to edy matches all the private ip.
		{

			if (ip2long($ip) != false) //returns false if ip address is invalid
			{
				$result = $ip;
				break;
			}
		}
		elseif(strncmp($ip,$fallback_ip_pattern,strlen($fallback_ip_pattern))===0)//if it starts with the preffered ip this is the fallback
		{

			if (ip2long($ip) != false) //returns false if ip address is invalid
			{
				$fallback=$ip;
			}

		}elseif ($ip == '127.0.0.1')// this is the local ip 
		{
			$result = $ip;
		}

	}

	if ($result===false) $result=$fallback; //if fallback is not found it will be false

	return $result; //if all resources are exhausted and not found, return false.
}

/** OMFG remove me when we upgrade to php 5.2.0
*/
if (! function_exists("array_fill_keys")) {
   function array_fill_keys(array $keys, $value) {
       return array_combine($keys, array_fill(0, count($keys), $value));
   }
}

/******************************************************************
 * PHP cut string 
 * @param $string   source string
 * @param $start    start position
 * @param $sublen   cut length
 * @param $code     string encode
 * @return string
 ****************************************************************/
function utf_substr($string, $start=0, $sublen, $code='UTF-8')
{
    if($code=='UTF-8')
    {
        $pa="/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
        preg_match_all($pa, $string, $t_string);
       
        if(count($t_string[0])-$start>$sublen)
		{
			return join('',array_slice($t_string[0],$start,$sublen)) . "...";
		}

        return join('',array_slice($t_string[0],$start,$sublen));
    }
    else
    {
        $start=$start*2;
        $sublen=$sublen*2;
        $strlen=strlen($string);
        $tmpstr='';
 
        for($i=0;$i<$strlen;$i++)
        {
            if($i>=$start&&$i<($start+$sublen))
            {
                if(ord(substr($string,$i,1))>129)
                {
                    $tmpstr.=substr($string,$i,2);
                }
                else
                {
                    $tmpstr.=substr($string,$i,1);
                }
            }
            if(ord(substr($string,$i,1))>129)$i++;
        }

        if(strlen($tmpstr)<$strlen)
		{
			$tmpstr.="...";
		}

        return $tmpstr;
    }

}

/** crc32_64bit($num)
returns the same crc32 value as on a 32-bit machine
*/
function crc32_64bit($num){
    $crc = crc32($num);
    if($crc & 0x80000000){
        $crc ^= 0xffffffff;
        $crc += 1;
        $crc = -$crc;
    }
    return $crc;
}

/** abs_crc32_64bit
* - Dan 9-20-07
* crc32 returns different values on 64 bit machines than 32 bit machines
* this function will always return the 32 bit version
* note that it also does abs()
*/

function abs_crc32_64bit($str){
   $crc = abs(crc32($str));
   if( $crc & 0x80000000){
      $crc ^= 0xffffffff;
      $crc += 1;
   }
   return $crc;
}

class FunctionLibrary {
    private static $instance;
    public static function instance(){
        if( isset( self::$instance ) ) return self::$instance;
        return self::$instance = new FunctionLibrary();
    }

    public function exists( $function ){
        if( function_exists( 'funclib_' . $function ) ) return TRUE;
        @include DIR_INCLUDES . 'function_library/' . $function . '.func.php';
        return ( function_exists( 'funclib_' . $function ) ) ? TRUE : FALSE;
    }

    public function call( $function, $args ){
        if( ! $this->exists( $function ) ) throw new Exception('Invalid-Function-Call');
        return call_user_func_array(  'funclib_' . $function , $args );
    }

    public function __call( $method, $args ){
        return $this->call( $method, $args );
    }
}

function FunctionLibrary(){
    return FunctionLibrary::instance();
}
 
if(false === function_exists('lcfirst'))
{
    /**
     * Make a string's first character lowercase
     *
     * @param string $str
     * @return string the resulting string.
     */
    function lcfirst( $str ) {
        $str[0] = strtolower($str[0]);
        return (string)$str;
    }
}
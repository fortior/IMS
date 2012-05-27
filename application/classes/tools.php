<?php
/**
 * Common functions that many modules will need to reference.
 */
class Tools {

	/**
	 * get client ip address
	 * @return 
	 * IP address string
	 */
	public static function get_ip() 
	{
	    if (getenv('HTTP_CLIENT_IP')) 
	    {
        	$ip = getenv('HTTP_CLIENT_IP'); 
        }
        elseif (getenv('HTTP_X_FORWARDED_FOR')) 
        { 
        	$ip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_X_FORWARDED')) 
        { 
        	$ip = getenv('HTTP_X_FORWARDED');
        }
        elseif (getenv('HTTP_FORWARDED_FOR')) 
        {
        	$ip = getenv('HTTP_FORWARDED_FOR'); 
        }
        elseif (getenv('HTTP_FORWARDED')) 
        {
        	$ip = getenv('HTTP_FORWARDED');
        }
        else 
        { 
        	$ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
	}
	/**
	 * 
	 * @param  $data
	 * XML Data String
	 * @return SimpleXMLElement
	 */
	public static function parse_xml($data)
	{
		return simplexml_load_string($data,'SimpleXMLElement', LIBXML_NOCDATA);
	}
	/**
	 * convert an object to xml format
	 * @param  $array
	 * @param  $root
	 * @param  $cdata
	 * @param  $item
	 */
	public static function array2xml($array,$root = "root",$cdata=array(),$item = 'item')
	{
	
		$xml ="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n<".$root.">\r\n";
		if(empty($array))
		{
			return false;
		}
		$xml .= self::_array2xml($array,$cdata,$item);
		$xml .="</".$root.">";
		return $xml;
	}
	/**
	 * iterate for to_xml
	 * @param  $source
	 * @param  $cdata
	 * @param  $item
	 */
	private static function _array2xml($source,$cdata=array(),$item = 'item')
	{
		$string = "";
		foreach($source as $k=>$v)
		{
			if(is_numeric($k))
			{
				$string .="<".$item.">";
			}
			else
			{
				$string .="<".$k.">";
			}
			if(is_array($v) || is_object($v)){
				$string .= "\r\n";
				$string .= self::_array2xml($v,$cdata,$item);
			}else{
				if(in_array($k,$cdata))
					$v = "<![CDATA[".$v."]]>";
				$string .= $v;
			}
			if(is_numeric($k))
			{
				$string .="</".$item.">";
			}
			else
			{
				str_replace('@','',$v)  ;
				$string .="</".$k.">"."\r\n";
			}
	
		}
		return $string;
	
	}
	/**
	 *
	 * Object to Array
	 * @param  $object
	 * @return 
	 * ArrayObject
	 */
	public static function object2array($object)
	{
		return @json_decode(@json_encode($object),1);
	}
}

?>
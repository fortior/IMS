<?php defined('SYSPATH') or die('No direct access allowed.');

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
	/**
	 * CURL Data collector which is a simulation browser
	 * 
	 */
	public static function curl($url,$param = array(),$lifetime = 3600, $referer = NULL, $ua = NULL)
	{
		$key = $url.implode('-',$param);
		$ua == NULL && $ua = self::_gen_ua();  
		
		if(isset($_GET['flush']) || !$body = Cache::instance()->get($key, FALSE))
		{
			$request = Request::factory($url);
			$request->method(Request::GET);
			if(!empty($param))
			{
				$param+=$request->query();
				$request->query($param);
			}
			if($referer == NULL)
			{
				$_url = parse_url($url);
				$referer = $_url['scheme'] . '://' . $_url['host'];
			}
			$request->client()->options(array(
					CURLOPT_TIMEOUT => 60,
					CURLOPT_USERAGENT => $ua,					
					CURLOPT_REFERER => $referer,					
					CURLOPT_ENCODING => '' ,
			));
			$body = $request->execute()->body();
			Cache::instance()->set($key, $body,$lifetime);
	
		}
	
		return  $body;
	}
	/**
	 * Generate a random ua string
	 * @return string
	 * UA String
	 */
	private static function _gen_ua()
	{
		$ua[] = "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.79 Safari/535.11";
		$ua[] = "Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9.2.19) Gecko/20110707 Firefox/3.6.19";
		$ua[] = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.168 Safari/535.19";
		$ua[] = "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; InfoPath.3; .NET4.0C; Tablet PC 2.0)";
		$ua[] = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; InfoPath.3; .NET4.0C; Tablet PC 2.0; SE 2.X MetaSr 1.0)";
		$rand = count($ua)-1;
		return $ua[rand(0,$rand)]	;
	}
}

?>
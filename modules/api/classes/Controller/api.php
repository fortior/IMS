<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api extends Controller{
	
	/**
	 * Data array
	 * @var array
	 */
	protected $data;
	
	protected $format = "json";
	
	protected $rom;
	
	protected $customer;
	
	function before()
	{
		parent::before();
		
		$format = $this->request->query('format');
		
		if($format)
		{
			$this->format = $format;
		}
	}
	function after()
	{
		//Only use for non-customize data
		if( ! $this->data || $this->response->body())
		{
			parent::after();
		}
		else
		{
			if($this->format == "json")
			{
				$this->response->headers('content-type',  File::mime_by_ext('json'));
				$this->response->body(json_encode($this->data));
			}
			elseif($this->format == "xml")
			{
				$this->response->headers('content-type',  File::mime_by_ext('xml'));
				$this->response->body(Tools::array2xml($this->data));
			}
		}
	}
	function error_code($code = 1,$message="")
	{
		return array('ret'=>$code,"msg"=>$message);
	}
	/**
	 * Basic param check 
	 */
	protected function _valid()
	{
		$_valid['field'] = array('deviceid','mac','version');
		foreach ($_valid['field'] as $key)
		{
			//can not be null
			$value = $this->request->query($key);
			if ( ! $value)
			{	
				$this->data = self::error_code(-2,$key.' is invalid');
				return FALSE;
			}
			
			switch ($key)
			{
				case 'mac':
				if( ! preg_match("/[A-F\d]{2}:[A-F\d]{2}:[A-F\d]{2}:[A-F\d]{2}:[A-F\d]{2}:[A-F\d]{2}/", $value))
				{
					$this->data = self::error_code(-2,'invalid mac format, only support FF:FF:FF:FF:FF:FF');
					return FALSE;
				}
				break;	
				case 'version':
				$arr = explode('-',$value);
				if(count($arr) != 3)
				{
					$this->data = self::error_code(-2,'invalid version format');
					return FALSE;
				}
				$this->rom = $arr[0];
				$this->customer = $arr[1];
					
			}
			
			
			
			
		}
		return TRUE;
	
	}

}
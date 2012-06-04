<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api extends Controller{
	
	/**
	 * Data array
	 * @var array
	 */
	protected $data;
	
	protected $format = "json";
	
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
}
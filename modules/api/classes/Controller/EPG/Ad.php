<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Ad Controller for epg ad export
 * @author Shunnar
 *
 */
class Controller_EPG_Ad extends Controller_Api{
	
	function action_main()
	{
		$client = $this->request->query("client");
		
		// basic check
		if( ! $client)
		{
			$this->data = parent::error_code(1);
			return FALSE;
		}
		$data = array(
				"pid"=>'1',
				"content"=>"本产品采用创新的网络技术，丰富多彩的节目可供选择，同时还可以在线享受“蓝光”给您带来的视觉震撼！",
				"type"=>"text",
				);
		$this->data = $data;
	}
}
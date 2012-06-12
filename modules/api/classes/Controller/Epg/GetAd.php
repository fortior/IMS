<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Ad Controller for epg ad export
 * @author Shunnar
 *
 */
class Controller_Epg_GetAd extends Controller_Api{
	
	function action_main()
	{
		$client = $this->request->query("version");
		$pid = $this->request->query("pid");
		
		// basic check
		if( ! $client)
		{
			$this->data = parent::error_code(-2,'version必填,之前的client已经改为version');
			return FALSE;
		}
		if( ! $pid)
		{
			$this->data = parent::error_code(-2,'没有pid参数');
			return FALSE;
		}
		
		$data = array(
				"ret"=>0,
				"pid"=>'1',
				"content"=>"本产品采用创新的网络技术，丰富多彩的节目可供选择，同时还可以在线享受“蓝光”给您带来的视觉震撼！",
				"type"=>"text",
				);
		$this->data = $data;
	}
}
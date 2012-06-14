<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Ad Controller for epg ad export
 * @author Shunnar
 *
 */
class Controller_System_Upgrade extends Controller_Api{
	
	function action_main()
	{
		$data = array(
				"ret"=>0,
				"msg"=>"有升级更新版本",
				"ver"=>"UAS-FG-V1.0.1",
				"url"=>"http://downloadserver/upgrade/UAS-FG-V1.0.1.zip",
				"md5"=>"47bce5c74f589f4867dbd57e9ca9f808",
				"info"=>"1.新增多屏互动功能；2.优化启动时间",				
		);
		$this->data = $data;
	}
}
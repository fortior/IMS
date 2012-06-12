<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Ad Controller for epg ad export
 * @author Shunnar
 *
 */
class Controller_System_GetAppList extends Controller_Api{
	
	function action_main()
	{
		$data = array(
					"ret"=>0,
					"msg"=>"成功",
					"apks"=>array(
							0=>array(
									"name"=>"直播天下",
									"package"=>"com.fondcoo.live",
									"statu"=>"0",
									"ver"=>"1.0.1",
									"url"=>"http://www.appchina.com/com.ganji.android.1338183910434.apk"
									),
							1=>array(
									"name"=>"PPTV",
									"package"=>"com.fondcoo.vod",
									"status"=>"0",
									"ver"=>"1.0.1",
									"url"=>"http://www.appchina.com/com.ganji.android.1338183910434.apk"
									)
							),
				);
		$this->data = $data;
	}
}
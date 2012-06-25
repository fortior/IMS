<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Ad Controller for epg ad export
 * @author Shunnar
 *
 */
class Controller_System_GetAppList extends Controller_Api{
	
	function action_main()
	{
		
		if( ! $this->_valid())
		{
			return FALSE;
		}
		$apks = ORM::factory('Sync_Apks')->where(DB::expr('find_in_set("'.$this->customer.'",customers)'),'>',0)->where(DB::expr('find_in_set("'.$this->rom.'",roms)'),'>',0)->find_all();
		
		echo Debug::vars();
		if($apks->count() > 0)
		{
			$data['ret'] = 0;
			$data['msg'] = 'success';
			foreach($apks as $k=>$apk)
			{
				$url_prefix = "http://". $_SERVER['SERVER_NAME'] . "/";
				
				$data['apks'][$k]['name'] = $apk->name;
				$data['apks'][$k]['package'] = $apk->package;
				$data['apks'][$k]['statu'] = $apk->statu;
				$data['apks'][$k]['ver'] = $apk->ver;
				$data['apks'][$k]['md5'] = $apk->md5;
				$data['apks'][$k]['url'] = $url_prefix . $apk->path;
			}
		}
		else
		{
			$data['ret'] = 0;
			$data['msg'] = 'no package need to sync';
		}
// 		foreach($apks->c)
// 		$data = array(
// 					"ret"=>0,
// 					"msg"=>"",
// 					"apks"=>array(
// 							0=>array(
// 									"name"=>"直播天下",
// 									"package"=>"com.fondcoo.live",
// 									"statu"=>"0",
// 									"ver"=>"1.0.1",
// 									"url"=>"http://www.appchina.com/com.ganji.android.1338183910434.apk"
// 									),
// 							1=>array(
// 									"name"=>"PPTV",
// 									"package"=>"com.fondcoo.vod",
// 									"status"=>"0",
// 									"ver"=>"1.0.1",
// 									"url"=>"http://www.appchina.com/com.ganji.android.1338183910434.apk"
// 									)
// 							),
// 				);
		$this->data = $data;
	}
}
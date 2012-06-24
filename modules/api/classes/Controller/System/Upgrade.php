<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Ad Controller for epg ad export
 * @author Shunnar
 *
 */
class Controller_System_Upgrade extends Controller_Api{
	
	function action_main()
	{
		/**
		 * 终端设备id，由chipid/mac+板卡型号+客户编号生成
		 * @var String
		 */
		$deviceid = $this->request->query("deviceid");
		
		/**
		 * 终端mac地址
		 * @var String
		 */
		$mac = $this->request->query("mac");
		
		/**
		 * 终端软件版本号
		 * @var String
		 */
		$version = $this->request->query("version");
		
		/**
		 * responseCode返回码
		 * 0：有更新升级包
		 * 1：当前版本已是最新
		 * -1：未知错误
		 * -2：请求参数不合法
		 * -1001：非法设备
		 * -1002：设备已过期
		 * -1003：服务端处理异常
		 * @var String
		 */
		$ret = -2;
		
		$data = array();
		if( ! $this->_valid())
		{
			return FALSE;
		}
		$upgrade = ORM::factory('Upgrade_Setup')->where('from','=',$version)->find();
		if($upgrade->loaded())
		{
			$url_prefix = "http://". $_SERVER['SERVER_NAME'] . "/";
			$ret = 0;
			$msg = "有更新升级包";			
			
			//Get package details
			$package = $this->get_package_info($upgrade->package);
			
			$data['ver'] = $upgrade->to;
			$data['url'] = $url_prefix . $package->path;
			$data['md5'] = $package->md5;
			$data['info'] = $package->info;
		}
		else
		{
			$ret = 1;
			$msg = "目前已经是最新版本";
		}
		$this->data['ret'] = $ret;
		$this->data['msg'] = $msg;

		$this->data += $data;
	}
	/**
	 * 
	 * @param int $package_id
	 */
	private function get_package_info($package_id)
	{
		return ORM::factory('Upgrade_Package',$package_id);
	}
}
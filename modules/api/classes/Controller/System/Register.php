<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Ad Controller for epg ad export
 * @author Shunnar
 *
 */
class Controller_System_Register extends Controller_Api{
	
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
		 *	0：激活成功
		 *	1：已受理
		 *	-1：未知错误
		 *	-2：请求参数不合法
		 *	-1001：非法设备
		 *	-1002：设备已过期
		 *	-1003：服务端处理异常
		 * @var String
		 */
		$ret = "";
		
		$key = "";

		if( ! $this->_valid())
		{
			return FALSE;
		}

		$user_stb = ORM::factory("User_STB")->where("deviceid", "=", $deviceid)->find();
		
		
		
		if($user_stb->loaded())
		{
			
			$ret = 1; 
			$msg = "已受理";
			$key = $this->encode($user_stb);
		}
		else
		{
			$user_stb->deviceid = $deviceid;
			$user_stb->mac = $mac;
			$user_stb->version = $version;
			$user_stb->ip = Tools::get_ip();
			$user_stb->save();
			$ret = 0;
			$key = $this->encode($user_stb);
			$msg = "激活成功";
		}
		
		
		$data = array(
					"ret"=>$ret,
					"msg"=>$msg,
					"key"=>$key,					
				);
		$this->data = $data;
	}

	
	private function encode($stb)
	{
		return  Encrypt::instance()->encode($stb->deviceid.$stb->mac.$stb->version);
	}
}
<?php defined('SYSPATH') or die('No direct script access.');
/**
 *  刷新缓存
 *
 * @author     Shunnar
 */
class Controller_System_Flush extends Controller_Admin{

	public function action_main()
	{
		//get all methods in 
		$methods = get_class_methods(__CLASS__);
		
		//execute flush methods
		foreach($methods as $method)
		{
			if(strpos($method, "flush_") !== FALSE)
			{
				$this->$method();
			}
			
		}
	}
	/**
	 * get version in upgrade_ver ,parse version string,save chip id and customer id
	 */
	function flush_version_save()
	{
		$vers = ORM::factory('Upgrade_Ver')->find_all();
		
		foreach ($vers as $k=>$v)
		{
			$ver_info = explode('-', $v->name);
			$roms[] = $ver_info[0];
			$customer[] = $ver_info[1];
		}
		
		$data['roms'] = array_unique($roms);
		
		$data['customers'] = array_unique($customer);
		
		$path = Kohana::find_file('config', "setup");
		
		$php = "<?php	defined('SYSPATH') or die('No direct access allowed.'); \r\n";
		$php .= "return " . var_export($data,1) .";";
		
		file_put_contents($path[0], $php);
		
		echo "<script>$.jGrowl('版本信息更新成功');</script>";
		//echo Debug::vars();
		
// 		echo Debug::vars(Kohana::$config->load("setup") ); 
		
	}
	
}

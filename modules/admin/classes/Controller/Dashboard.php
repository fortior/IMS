<?php
class Controller_Dashboard extends Controller_Admin{
	/**
	 * Dashboard
	 */
	public function action_main()
	{
// 		$api_list = array("a")
// 		echo View::factory('APIList');
		$module = array('api','das');
		foreach($module as $module_name)
		{
			$list = Kohana::list_files('classes',array(MODPATH.$module_name."/"));
			$data[$module_name] = self::classes($list,$module_name);
		}
		
		$view = View::factory('frame');
		$title = "Dashboard";
		$content = "dashboard";
		View::bind_global('title', $title);
		View::bind_global('data', $data);
		View::bind_global('content', $content);
		$this->response->body($view);
//  		echo Debug::vars($data);
		
	}
	public static function classes(array $list = NULL,$module='')
	{
		if ($list === NULL)
		{
			$list = Kohana::list_files('classes');
		}
	
		$classes = array();
	
		// This will be used a lot!
		$ext_length = strlen(EXT);
	
		foreach ($list as $name => $path)
		{
			if (is_array($path))
			{
				$classes += self::classes($path,$module);
			}
			elseif (substr($name, -$ext_length) === EXT)
			{
				// Remove "classes/" and the extension
				$class = substr($name, 8, -$ext_length);
	
				// Convert slashes to underscores
				$class = str_replace(DIRECTORY_SEPARATOR, '/', $class);
				$class = str_replace("Controller", '/'.$module, $class);
	
				$classes[$class] = $class;
			}
		}
	
		return $classes;
	}
}
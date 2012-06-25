<?php defined('SYSPATH') or die('No direct script access.');
/**
 *  应用管控
 *
 * @author     Shunnar
 */
class Controller_CMS_SyncApks extends Controller_Admin{
	
	function before()
	{		
		$this->model = "Sync_Apks";
		$this->title = "同步APK";	
		
//		$this->info ="xxxxxxx";
//		$this->error = "aaaaaaaaaaa";
//		$this->warning = "";
//		$this->success = "";
		parent::before();				
	}
	/**
	 * 自定义显示列信息
	 * @see Controller_Admin::columns()
	 * @example
 	    $data =  parent::columns($data);
		$data['tid']['func'] = "md5";
		$data['tid']['name'] = "字段中文";
		$data['id']['desc'] = "字段的注释部分";
		return $cols;
	 */
	function list_columns($data)
	{
		$data = parent::list_columns($data);
		$data['statu']['func'] = "statu";
		unset($data['path']);
		return $data;
	}
	/**
	 * Overwrite
	 * @see Controller_Admin::action_save()
	 */
	function action_save()
	{
		if ( ! empty($_FILES) && Upload::valid($_FILES['package']) && $_FILES['package']['name'])
		{
		
			Upload::$default_directory = "assets/uploads/apks/";
		
			if(! is_dir(Upload::$default_directory))
			{
				mkdir(Upload::$default_directory,"0777",1);
			}
			 
			$package_name = $_FILES['package']['name'];
		
			$md5 = md5_file($_FILES["package"]["tmp_name"]);
		
			$ext = substr(strrchr($package_name, '.'), 1);
		
			// Upload is valid, save it
			$filename = Upload::save($_FILES['package'],$md5.'.'.$ext);
				
		
// 			$this->request->post('package_name',$package_name);
			$this->request->post('md5',$md5);
			$this->request->post('path',Upload::$default_directory.$md5.'.'.$ext);
			 
		
		}
		$this->request->post('roms',implode(",", $this->request->post('roms')));
		
		$this->request->post('customers',implode(",", $this->request->post('customers')));
		
		parent::action_save();
	}
	
	/**
	 * 改写默认表单基本信息
	 * @example
	 	parent::blank_form_columns($col,TRUE); //ID在添加时是否显示
	    $data['ext']['validate']['rules'] = '{}';
	    $data['ext']['validate']['message'] = '{}';
	    关于rule message设置可以参考http://docs.jquery.com/Plugins/Validation
	    // type 采用 Select 表单 数据来源于 type_options 方法
	    $data['type']['field'] = Form::select("type",$this->type_options(),1);
	    	
	 * @see Controller_Admin::blank_form_columns()
	 */
	protected function blank_form_columns($col,$return_id=FALSE)
	{
		$data = parent::blank_form_columns($col,$return_id);	
		$data['path']['field'] = Form::file('package');
		
		$roms = Kohana::$config->load('setup.roms');
		$customers = Kohana::$config->load('setup.customers');
		
		$data['roms']['field'] = "";
		foreach($roms as $v)
		{
			$data['roms']['field'] .= Form::checkbox("roms[]",$v,array('id'=>"check_".$v)) . "<label for='check_{$v}'>{$v}</label>";
		}

		$data['customers']['field'] = "";
		foreach($customers as $v)
		{
			$data['customers']['field'] .= Form::checkbox("customers[]",$v,array('id'=>"check_".$v)) . "<label for='check_{$v}'>{$v}</label>";
		}
		$data['statu']['field'] = Form::select('statu',$this->statu_options());
		unset($data['md5']);
		unset($data['created']);
		return $data;
	}
	
	/**
	 * 改写默认表单编辑信息 基本数据继承 blank_form_columns 与 list_columns
	 * @example
	    $data = parent::full_form_columns($col,$orm);
	 	$data['type']['field'] = Form::select("type",$this->type_options(),$orm->type); //转换成Select并赋值
	 	
	 * @see Controller_Admin::full_form_columns()
	 */
	protected function full_form_columns($col,$orm=NULL)
	{
		$data =  parent::full_form_columns($col,$orm);
		
		unset($data['md5']);
		unset($data['created']);
		$data['path']['field'] = Form::file('package');
		
		//rom & customer 
		$roms = Kohana::$config->load('setup.roms');
		$customers = Kohana::$config->load('setup.customers');
		
		$data['roms']['field'] = "";
		foreach($roms as $v)
		{
			$checked = FALSE;
			if(strpos($orm->roms, $v)!==FALSE)
			{
				$checked = TRUE;
			}
			$data['roms']['field'] .= Form::checkbox("roms[]",$v,$checked,array('id'=>"check_".$v)) . "<label for='check_{$v}'>{$v}</label>";
			
		}
		
		$data['customers']['field'] = "";
		foreach($customers as $v)
		{
			$checked = FALSE;
			if(strpos($orm->customers, $v)!==FALSE)
			{
				$checked = TRUE;
			}
			$data['customers']['field'] .= Form::checkbox("customers[]",$v,$checked,array('id'=>"check_".$v)) . "<label for='check_{$v}'>{$v}</label>";
		}
		
		$data['statu']['field'] = Form::select('statu',$this->statu_options(),$orm->statu);
		
		return $data;
	}
	private function statu_options()
	{
		return array('-1'=>'卸载','0'=>'正常');
	}
	/**
	 * 每一条数据操作按钮
	 * @example
	 * return '<a href="./flush/'.$id.'" target="_ajax">清空</a>';	
	*/
	public static function handle($id)
	{
		return parent::handle($id);		
	}
	public static function statu($str)
	{
		return $str==0?"正常":"卸载";
	}
	
	
	
}
?>
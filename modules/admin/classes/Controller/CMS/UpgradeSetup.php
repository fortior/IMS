<?php defined('SYSPATH') or die('No direct script access.');
/**
 *  升级版本管理
 *
 * @package    Kohana/Admin/Cache
 * @category   Controllers
 * @author     Shunnar
 */
class Controller_CMS_UpgradeSetup extends Controller_Admin{
	
	function before()
	{		
		$this->model = "Upgrade_Setup";
		$this->title = "升级";	
		
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
		$data['package']['func'] = "get_package_name";
		return $data;	
	}
	function action_list()
	{
		$data = parent::action_list();
		foreach($data as $k=>$v)
		{
			$_data[$k] = $v;
			
			$_data[$k]->active = $this->toggle('active',$v->id,$v->active);
		
		}
		View::bind_global("data",$_data);
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
		$data['from']['field'] = Form::select("from",$this->get_upgrade_version(),1);
		$data['to']['field'] = Form::select("to",$this->get_upgrade_version(),1);
		$data['package']['field'] = Form::select("package",$this->get_upgrade_package(),1);
		unset($data['created']);
		unset($data['active']);
		
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
		$data['from']['field'] = Form::select("from",$this->get_upgrade_version(),$orm->from);
		$data['to']['field'] = Form::select("to",$this->get_upgrade_version(),$orm->to);
		$data['package']['field'] = Form::select("package",$this->get_upgrade_package(),$orm->package);
		unset($data['created']);
		unset($data['active']);
		return $data;
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
	/**
	 * 获取升级版本信息
	 */
	private function get_upgrade_version()
	{
		$version = ORM::factory("Upgrade_Ver")->find_all()->as_array("name","name");

		return $version;
	}
	/**
	 * 获取升级版本信息
	 */
	private function get_upgrade_package()
	{
		$package = ORM::factory("Upgrade_Package")->find_all()->as_array("id","package_name");
	
		return $package;
	}
	public static function get_package_name($package_id)
	{
		$anchor = "";
		$package = ORM::factory("Upgrade_Package",$package_id);
		if($package->loaded())
		{
			$anchor = HTML::anchor("/".$package->path,$package->package_name,array('target'=>"_blank"));
		}
		return $anchor;
	}
	
	
}
?>
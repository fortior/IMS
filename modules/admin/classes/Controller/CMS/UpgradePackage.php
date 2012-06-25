<?php defined('SYSPATH') or die('No direct script access.');
/**
 *  Cache管理
 *
 * @package    Kohana/Admin/Cache
 * @category   Controllers
 * @author     Shunnar
 */
class Controller_CMS_UpgradePackage extends Controller_Admin{
	
	function before()
	{		
		$this->model = "Upgrade_Package";
		$this->title = "升级包";	
		
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
		$data =  parent::list_columns($data);	
		unset($data['path']);
		return $data;
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
		$data['package_name']['field'] = Form::file('package');
		$data['info']['field'] = Form::textarea("info");
		unset($data['md5']);	
		unset($data['path']);
// 		$data['pid']['field'] = Form::select("pid",$this->get_live_epg(),1);
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
		$data['package_name']['field'] = Form::file('package');
		unset($data['md5']);
		unset($data['path']);
// 		$data['pid']['field'] ='<div class="searchDrop">' .  Form::select("pid",$this->get_live_epg(),$orm->pid,array("data-placeholder"=>"Choose a name",'class'=>'chzn-select')) . '<input type="button" onclick="window.location.href=\'../insert_epg/'.$orm->id.'\'" value="+" class="blueBtn"> </div>' . ' ' ;
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
	 * overwrite
	 * @see Controller_Admin::action_save()
	 */
	public function action_save()
	{
		
		if ( ! empty($_FILES) && Upload::valid($_FILES['package']) && $_FILES['package']['name'])
		{
	
		    Upload::$default_directory = "assets/uploads/upgrade/";
		    
		    if(! is_dir(Upload::$default_directory))
		    {
		    	mkdir(Upload::$default_directory,"0777",1);
		    }
		   
		    $package_name = $_FILES['package']['name'];		    
		    
		    $md5 = md5_file($_FILES["package"]["tmp_name"]);
		    
		    $ext = substr(strrchr($package_name, '.'), 1);
		    
		   // Upload is valid, save it
			$filename = Upload::save($_FILES['package'],$md5.'.'.$ext);
			
		      
		    $this->request->post('package_name',$package_name);
		    $this->request->post('md5',$md5);
		    $this->request->post('path',Upload::$default_directory.$md5.'.'.$ext);
		   
		    
		}
		parent::action_save();
		
	}
	
	
}
?>
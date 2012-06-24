<?php defined('SYSPATH') or die('No direct script access.');
/**
 *  Cache管理
 *
 * @package    Kohana/Admin/Cache
 * @category   Controllers
 * @author     Shunnar
 */
class Controller_CMS_Demo extends Controller_Admin{
	
	function before()
	{		
		$this->model = "Live_Links";
		$this->title = "直播链接";	
		
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
		return parent::list_columns($data);	
	}
	
	function action_list()
	{
		$data = parent::action_list();
		foreach($data as $k=>$v)
		{
			$_data[$k] = $v;
			
			$_data[$k]->active = $this->toggle('active',$v->id,$v->active);
			$_data[$k]->available = $this->toggle('available',$v->id,$v->available);
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
		$data['pid']['field'] = Form::select("pid",$this->get_live_epg(),1);
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
		$data['pid']['field'] ='<div class="searchDrop">' .  Form::select("pid",$this->get_live_epg(),$orm->pid,array("data-placeholder"=>"Choose a name",'class'=>'chzn-select')) . '<input type="button" onclick="window.location.href=\'../insert_epg/'.$orm->id.'\'" value="+" class="blueBtn"> </div>' . ' ' ;
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
	 * 
	 * @return array
	 * Live station array option
	 */
	private function get_live_epg()
	{
		$live_epg = ORM::factory("Live_EPG")->find_all()->as_array('id','title');
		return $live_epg;
	}
	
	public function action_insert_epg()
	{
		$id = $this->request->param('id');
		echo Debug::vars($this->request->uri()); exit;
		$this->redirect("/admin/CMS/LiveLinks/edit/".$id);
		//exit('a');
	}
	
	
}
?>
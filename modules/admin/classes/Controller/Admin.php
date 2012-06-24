<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Automatic Basic Admin Controller.
 *
 * @author     Shunnar
 */
class Controller_Admin extends Controller{
	protected  $model;
	/**
	 * @var  View  page template
	 */
	public $template ;

	/**
	 * 页面显示信息类型
	 * $this->info = 'abc'
	 */
	public $info;
	public $error;
	public $warning;
	public $success;


	function before()
	{
		parent::before();
		$this->auth();
		Kohana_Log::$write_on_add = TRUE;
	}
	private function auth()
	{
		
		$user = Cookie::get('user');
		
		
		if( ! $user AND Cookie::get('needsubmit') != 1) 
		{
			$_SERVER['PHP_AUTH_USER'] = '';
			$_SERVER['PHP_AUTH_PW'] = '';
		}
		$user = Arr::get($_SERVER, "PHP_AUTH_USER");
		$pw = Arr::get($_SERVER, "PHP_AUTH_PW");
		
		if ($user != "admin" || $pw != "admin" )
		{
			Cookie::set('needsubmit',"1");
			header('WWW-Authenticate: Basic realm="realm"');
			header('HTTP/1.0 401 Unauthorized');
			exit;
		} else {
			Cookie::set('user',"admin");
			
		}
	}
	
	public function action_logout()
	{
		
		Cookie::delete('user');
		Cookie::set('needsubmit',"0");
		$this->redirect('admin');
	}
	private function check_password($user,$pw)
	{
		$data['fondcoo'] = "fondcoosz";
		if(isset($data[$user]) AND $data[$user] = $pw)
		{
			return ucfirst($user);
		}
		else
		{
			return FALSE;
		}
	}
	

	/**
	 *
	 * 模型初始化信息 在模型操作时使用
	 */
	function init()
	{

		//读取列信息  表字段注释信息
		$this->table = ORM::factory($this->model)->table_columns();

		$this->columns = array_keys($this->table);



		//获取主键名称 用于编辑删除操作
		$this->pk = ORM::factory($this->model)->primary_key();
		
		$count = ORM::factory($this->model)->count_all();
		View::bind_global("count", $count);
		
	}
	function action_add()
	{
		$this->init();

		$this->template = View::factory('frame');
		
		$this->template->content = "form";

		//读取列信息
		$columns = $this->blank_form_columns($this->columns);
		View::bind_global("columns", $columns);

		//获取主键名称 用于编辑删除操作
		View::bind_global("pk", $this->pk);
		
		$title = "新增".$this->title;
		View::bind_global("title", $title);


	}
	/**
	 *
	 * 通用表单保存
	 * @return pk
	 */
	public function action_save()
	{
		//初始化 model配置
		$this->init();

		//获取 POST数据
		$data = $this->request->post();

		//因为需要兼容Add 与 Edit操作   为 Add操作默认pk为NULL
		$data[$this->pk] = isset($data[$this->pk])?$data[$this->pk]:NULL;

		$primary_key = $data[$this->pk];
		$orm = ORM::factory($this->model,$primary_key);
		foreach($this->columns as $k=>$v)
		{
			//empty data wont inset or update
			if(isset($data[$v]))
			{
				$orm->$v = $data[$v];
			}
			
		}
		$orm->save();
		return $orm->pk();

	}
	/**
	 *
	 * 通用删除方法
	 */
	function action_del()
	{
		$primary_key = $this->request->param('id');
		$orm = ORM::factory($this->model,$primary_key);
		$orm->delete();
		$this->page_list();
		//$orm = ORM::factory($this->model,$primary_key);
	}
	/**
	 *
	 * 通用编辑方法
	 */
	 function action_edit()
	{
		//初始化 model配置
		$this->init();
		$this->template = View::factory('frame');
		
		$this->template->content = "form";
// 		$this->template = View::factory('add');
		$primary_key = $this->request->param('id');
		if(empty($primary_key))
		Admin::error("传入参数错误");
		$orm = ORM::factory($this->model,$primary_key);

      	//读取列信息
		$columns = $this->full_form_columns($this->columns,$orm);
		View::bind_global("columns",$columns);
		
		//获取主键名称 用于编辑删除操作		
		View::bind_global("pk",$this->pk);
		
		$title = "编辑".$this->title;
		View::bind_global("title", $title);

	}
	/**
	 *
	 * 通用列表方法
	 *
	 */
	function action_list()
	{
		$this->init();

		$this->template = View::factory('frame');
		
		$this->template->content = "list";
		//Datatable 控件默认排序方式
		
		$aasorting = "[0,'desc']";
		View::bind_global("aasorting",$aasorting);
		
// 		$this->template->obj =  $this;
		View::bind_global("obj",$this);
		
		//读取列信息
		$columns = $this->list_columns($this->columns);
		View::bind_global("columns",$columns);

		//获取主键名称 用于编辑删除操作
// 		$this->template->pk = $this->pk;
		View::bind_global("pk",$this->pk);
		
		//数据信息
		if(isset($this->customer_data))
		{
			$data = $this->customer_data;
		}		 
		else
		{
			$data = ORM::factory($this->model)->limit(1000)->find_all();
		}	
		View::bind_global("data",$data);
		
		$title = $this->title."列表";
		View::bind_global("title", $title);
		return $data;

	}
	function action_toggle()
	{
		$columm = $this->request->query('c');
		$id = $this->request->query('id');
		$orm = ORM::factory($this->model,$id);
		$orm->$columm = ($orm->$columm)*-1 +1;
		$orm->save();
		if($orm->saved())
		{
			$this->response->body('状态更新成功');
		}
		else
		{
			$this->response->body('状态更新失败');
		}
	}
	/**
	 * 判断是否有Template处理，如果有就输出渲染到前台
	 * @see Kohana_Controller::after()
	 */
	function after()
	{
		//保存成功后转向List页面
		if("save" == $this->request->action())
		{
			//转向List页面
			$this->page_list();
			return;
		}
		if (!empty($this->template))
		{
			
			$pre_uri = URL::site('admin/'.$this->request->directory().'/'.$this->request->controller().'/');
			View::bind_global('pre_uri', $pre_uri);
			

			$this->response->body($this->template->render());
		}
		parent::after();
	}
	/**
	 *
	 * 后台管理导航菜单处理
	 */
	function menu()
	{
// 		$data = Common_Menu::factory('menu','parent_id')->menu_html();
// 		$top_level = Common_Menu::factory('menu','parent_id')->sub(0);
// 		View::bind_global('menu', $data);
// 		View::bind_global('top_menu', $top_level);
	}
	/**
	 *
	 * 列表中的列信息  子类可以overwrite 此方法自定义显示列
	 *
	 * @param Array $data
	 */
	protected function list_columns($col)
	{

		foreach($col as $k=>$v)
		{
			//如果有注释 默认中文名为注释名
			$data[$v]['name'] = (empty($this->table[$v]['comment']))?$v:$this->table[$v]['comment'];
			$data[$v]['func'] = "strval";
			$data[$v]['desc'] = "";
		}
		return $data;
	}
	/**
	 *
	 * 编辑表单创建
	 * @param 字段数据 $col
	 * @param 表单数据模型 $orm
	 */
	protected function full_form_columns($col,$orm=NULL)
	{
		$data = $this->blank_form_columns($col,TRUE);

		foreach($col as $k=>$v)
		{
			//为编辑表单赋值
			$data[$v]['field'] = Form::input($v,$orm->$v,array('id'=>'_'.$v,'class'=>'required'));
		}

		$pk = $this->pk;
		$data[$this->pk]['field'] = Form::input($this->pk,$orm->$pk,array('id'=>'_'.$this->pk,'class'=>'required','readonly'=>'readonly'));
		$data[$this->pk]['validate']['rules'] = '{required: false}';
		return $data;
	}
	/**
	 *
	 * 表单中的字段信息  子类可以overwrite 此方法自定义
	 *
	 * @param Array $data
	 * @param Bool $return_id
	 */
	protected function blank_form_columns($col,$return_id=FALSE)
	{
		//继承list中的标题
		$list_columns = $this->list_columns($col);

		foreach($col as $k=>$v)
		{
			//当是新增记录时 默认值为空
			$data[$v]['field'] = Form::input($v,NULL,array('id'=>'_'.$v,'class'=>'half title'));
			$data[$v]['name'] = isset($list_columns[$v]['name'])?$list_columns[$v]['name']:((empty($this->table[$v]['comment']))?$v:$this->table[$v]['comment']);
			$data[$v]['desc'] = isset($list_columns[$v]['desc'])?$list_columns[$v]['desc']:"";


			//eg {	required: true,	minlength: 5,equalTo: "#password"}
			$data[$v]['validate']['rules'] = '{required: true}';
			$data[$v]['validate']['message'] = '{required:" '.$data[$v]['name'].'必填"}';


		}
		//默认添加情况下 表单中不显示pk

		if($return_id==FALSE)
		unset($data[$this->pk]);
		return $data;
	}
	/**
	 *
	 * test error
	 */
	public function action_error()
	{
		echo Debug::vars($this->request->controller());
	}
	/**
	 *
	 * 跳转到列表页面
	 */
	protected function page_list()
	{
		$this->redirect('admin/'.$this->request->directory().'/'.$this->request->controller().'/list');
	}
	static function strval($val)
	{
		return  $val;
	}
	/**
	 *
	 * 列表静态操作方法
	 * @param primary_key $id
	 */
	public static function handle($id)
	{
		$anchor = '<a href="./edit/'.$id.'">编辑</a> ';
		$anchor.= '<a onclick="return confirm(\'确定删除？ 删除后将无法恢复\')" href="./del/'.$id.'">删除</a>';
		return $anchor;
	}
	/**
	 *
	 * 列表顶部Filter表单HTML数据
	 */
	public static function filter()
	{
		return FALSE;
	}
	/**
	 *
	 * 页面Toggle开关选择
	 * @param 字段名 $col
	 * @param 更新记录ID $id
	 * @param 当前值 $bool
	 */
	protected  function toggle($col,$id,$bool)
	{
		if($bool)
		$toggle = "<a href='./toggle/?c=".$col."&id=".$id."' class='toggle' onmouseover='currentToggle(\"".$col.$id."\")'><img id='".$col.$id."' src='".Kohana::$base_url."assets/admin/images/icons/color/tick.png'/></a>";
		else
		$toggle = "<a href='./toggle/?c=".$col."&id=".$id."' class='toggle' onmouseover='currentToggle(\"".$col.$id."\")'><img id='".$col.$id."' src='".Kohana::$base_url."assets/admin/images/icons/color/cross.png'/></a>";


		return $toggle;
	}
	/**
	 *
	 * @param 图片地址 $source
	 */
	public static function show_image($source)
	{
		return HTML::image($source,array('height'=>'50'));
	}


}
?>
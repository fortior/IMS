<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Vod Api Controller
 * @author Shunnar
 *
 */
class Controller_Epg_GetVod extends Controller_Api{
	
	/**
	 * Vod Type eg. "1"=>'电影','2'=>'电视剧','3'=>"动漫",'4'=>'综艺'
	 * @var String
	 */
	private $type;
	function action_types()
	{
		$data = array("1"=>'电影','2'=>'电视剧','3'=>"动漫",'4'=>'综艺');	
		$this->data = array("ret"=>0,'count'=>count($data),'v'=>$data);		
	}
	/**
	 * export vod tags by type
	 */
	function action_tags()
	{		
		if( ! $this->_valid())
		return FALSE;
		$tags = ORM::factory('Vod_Tags')->where('type','=',$this->type)->find_all();
		$data = array();
		foreach($tags as $k=>$v)
		{
			$data[$v->dimension][] = $v->name;
		}

		$this->data = array("ret"=>0,'count'=>count($data),'v'=>$data);
	}
	/**
	 *  List
	 */
	function action_list()
	{
		if( ! $this->_valid())
		{
			return FALSE;
		}
		$tags = $this->request->query('tags');
		
		//page number
		$page = $this->request->query('page');
		
		//count per page
		$limit = $this->request->query('limit');
		
		$offset = ($page - 1) * $limit;
		
		$tags_array = explode('|', $tags);
		
		$list = ORM::factory("Vod_List");

		$list->where('type','=',$this->type);

		foreach($tags_array as $v)
		{
			$tag = explode(':',$v);
			switch ($tag[0])
			{
			    case '类型':
			    	$list->where(DB::expr('find_in_set("'.$tag[1].'",tags)'),'>',0);
			    	break;
			    case '年份':
			        $list->where('year','=',$tag[1]);
			        break;			    
			    case '地区':
			        $list->where('area','=',$tag[1]);
			    	break;
			    default:
			       $list->where(DB::expr('find_in_set("'.$tag[1].'",tags)'),'>',0);
			        break;
			}
			
		}
		$list = $list->offset($offset)->order_by('order','asc')->limit($limit);
		
 		
		$res = $list->find_all();
		
		$count = $list->count_all();
		
		$data = array();
		
		if(count($res) > 0)
		{
			foreach($res as $k=>$v)
			{
				$data[$k]['vid'] = $v->id;
				$data[$k]['title'] = $v->title;
				$data[$k]['imgurl'] = $v->imgurl;
				$data[$k]['resolution'] = $v->resolution?$v->resolution:"普清";
				$data[$k]['title'] = $v->title;
				$data[$k]['playlink'] = $this->get_playlink($v);
				
			} 
		}
		$this->data = array("ret"=>0,'count'=>$count,'v'=>$data);
		
	}
	function get_playlink($v)
	{
		return "http://meta.video.qiyi.com/" . $v->sid . ".m3u8";
	}
	/**
	 * Check
	 */
	private function _valid()
	{
		$type = $this->request->query("type");
		
		//none
		if( ! $type)
		{
			$this->data = parent::error_code(-2,'没有type参数');
			return FALSE;
		}
		
		//wrong format
		if($type > 4 OR $type < 1  )
		{
			$this->data = parent::error_code(-3,'type 格式不正确');
			return FALSE;
		}
		
		$this->type = $type;
		return TRUE;
	}

	
}
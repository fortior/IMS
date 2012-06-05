<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_EPG_Live extends Controller_Api{
	
	function action_main()
	{
		$data = array();
		$live = ORM::factory("live_epg")->where("active",'>','0')->order_by("num","asc")->find_all();
		
		foreach($live as $v)
		{
			$links = $this->get_links($v->id);
			$link = $links[0];
			array_shift($links);
			$backup = $links;
			$data[] = array("num"=>$v->num,"title"=>$v->title,'link'=>$link,'backup'=>$backup);
		}	
		$this->data = array('count'=>count($data),'v'=>$data);
		
	}
	function get_links($pid)
	{
		$data = array();
		$links = ORM::factory('live_links')->where("pid", "=", $pid)->find_all();
		if(count($links)>0)
		{
			foreach($links as $k=>$v)
			{
				$data[] = $v->link;
			}
		}			
		return $data;
	}
}
<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_EPG_Live extends Controller_Api{
	
	function action_main()
	{
		$live = ORM::factory("live_epg")->where("active",'=','0')->find_all();
		
		foreach($live as $v)
		{
			$this->data[] = array("id"=>$v->id,"title"=>$v->title,'links'=>$this->get_links($v->id));
		}	
			
		//echo $this->data; exit;
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
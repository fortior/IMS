<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_EPG_Live extends Controller_Api{
	
	function action_main()
	{
		$data = array();
		$live = ORM::factory("Live_EPG")->where("active",'>','0')->order_by("num","asc")->find_all();
		
		foreach($live as $v)
		{
			$links = $this->get_links($v->id);
			
			//except empty links
			if(empty($links))
			continue;
			
			//main link
			$link = $links[0];
			
			//links backup
			array_shift($links);
			$backup = $links;
			
			//data construct
			$data[] = array("num"=>$v->num,"title"=>$v->title,'link'=>$link,'backup'=>$backup);
		}	
		$this->data = array("ret"=>0,'count'=>count($data),'v'=>$data);
		
	}
	/**
	 * 
	 * @param  $pid
	 * EPG Live ID
	 * @return Array
	 * links array
	 */
	function get_links($pid)
	{
		$data = array();
		$links = ORM::factory('Live_Links')->where("pid", "=", $pid)->find_all();
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
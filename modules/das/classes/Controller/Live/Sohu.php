<?php defined('SYSPATH') OR die('No direct script access.');

class Controller_Live_Sohu extends Controller_Live_Core{
	
	private $type = "sohu";
	
	/**
	 * DAS For Sohu 
	 */
	public function action_main()
	{
		$data = $this->collect();
		
		if($data)
		{
			//reset available to false first
			parent::reset($this->type);
		}
		foreach($data as $k=>$v)
		{
			//update or insert to db
			$links = ORM::factory("Live_Links")->where('vid','=',$v['vid'])->where('type','=','QQ')->find();
			$links->vid = $v['vid'];
			$links->title = $v['title'];
			$links->type = $this->type;
			$links->link = "http://gslb.tv.sohu.com/live?cid={$links->vid}&type=hls";
			$links->available = 1;
			$links->save();
		}
	}
	
	/**
	 * Sohu Date collector
	 */
	private function collect()
	{
		$menu_list=array();
		$url = "http://live.tv.sohu.com/";
		$body = Tools::curl($url);


		preg_match("/data1[^<>]*=[^<>]*([^<>]*)?var/iU",$body,$match);

		$json= trim(preg_replace(array("'data1[^<>]*='","'};[\s][^<>]*var'"),array('','}'),iconv('GBK','UTF-8',$match[0])));

		$decode = json_decode($json,TRUE);
		
		foreach ($decode['data'] as $k=>$v)
		{
			$data[$k] = array('vid'=>$this->get_sohu_vid($v['tvId']),'title'=>$v['name']);
		}
		return $data;
	}
	/**
	 * sohu vid fetcher
	 */
	private function get_sohu_vid($tvid)
	{
		$microtime = floor(microtime(TRUE) * 1000) ;
		$url = "http://live.tv.sohu.com/live/player_json.jhtml?lid={$tvid}&af=1&bw=524&type=1&g=8&ipad=1&_={$microtime}";
		$json = Tools::curl($url);
		$json = iconv('GBK','UTF-8',$json);
		$json_array = json_decode($json,TRUE);
		return $json_array['data']['cid'];
	}
}

?>
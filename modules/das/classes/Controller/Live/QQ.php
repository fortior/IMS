<?php defined('SYSPATH') OR die('No direct script access.');

class Controller_Live_QQ extends Controller_Live_Core{
	
	private $type = "QQ";
	
	/**
	 * DAS For Tencent Live 
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
			$links = ORM::factory("Live_Links")->where('vid','=',$v['vid'])->where('type','=',$this->type)->find();
			$links->vid = $v['vid'];
			$links->title = $v['title'];
			$links->type = $this->type;
			$links->link = "http://zb.v.qq.com:1863/?progid=".$links->vid."&ostype=ios";
			$links->available = 1;
			$links->save();
			echo "<script>$.jGrowl('{$links->title}更新成功');</script>";
		}
	}
	
	/**
	 * QQ Date collector
	 */
	private function collect()
	{
		$menu_list=array();
		$url = "http://v.qq.com/live/index.html";
		$body = Tools::curl($url);
		
		preg_match_all("/<h3[^>]*><a[^>]*>([^<>]*)<\/a><\/h3>[^<>]*<ul[^>]*>([\s\S]*)<\/ul>?/iU",$body,$match);
		unset($match[0]);
	
		for($i=0;$i<count($match[1]);$i++)
		{
			preg_match_all("/<li><a cnlid=[\"]([\d]{1,})[\"][^>]*>([^<>]*)<\/a><\/li>/iU",$match[2][$i],$list);
			unset($list[0]);
			
			foreach($list[1] as $k=>$v)
			{
				$data[$v] = array("vid"=>$v,"title"=>$list[2][$k]);
			}
			
		}
		
		return $data;
	}
}

?>
<?php defined('SYSPATH') OR die('No direct script access.');

class Controller_Live_CNTV extends Controller_Live_Core{
	
	private $type = "CNTV";
	
	/**
	 * Http Play Links
	 * @var $link
	 */
	private $link = array();
	
	/**
	 * DAS For PPTV 
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
// 			$links->link = "http://web-play.pptv.com/web-m3u8-{$links->vid}.m3u8";
			$links->link = $this->link[$links->vid];
			$links->available = 1;
			
			//Do not insert non-m3u8 record
			$links->link && $links->save();
		}
	}
	
	/**
	 * PPTV Date collector
	 */
	private function collect()
	{
		$arr_list	= array();
		$url		= 'http://bugu.cntv.cn/live/index.shtml';
		$body		= Tools::curl($url);
		$body = iconv("GBK", "UTF-8//IGNORE", $body);
		preg_match_all('/<div class=[\"]md md_11[^>]*[\"][^>]*>([\s\S]*)<div class=[\"]clear[\"]>/iU',$body,$match);
		
		//print_r($match);exit;
		foreach($match[1] as $k=>$rs)
		{
			//print_r($rs);exit;
			preg_match("/<li class=[\"]cur[\"]><a[^>]*>([^<>]*)<\/a><\/li>/iU",$rs,$title);
			preg_match_all("/<p><a href=[\"]([^<>]*.shtml)[\"][^>]*>([^<>]*)<\/a><\/p>/iU",$rs,$list);
		
			$arr_list[$title[1]]['url']		= $list[1];
			$arr_list[$title[1]]['title'] 	= $list[2];
		}
		
		echo Debug::vars($arr_list);exit;
	}
	
}

?>
<?php defined('SYSPATH') OR die('No direct script access.');

class Controller_Live_PPTV extends Controller_Live_Core{
	
	private $type = "PPTV";
	
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
		//PPTV has 4live pages
		for($page_id = 1;$page_id <= 4;$page_id ++)
		{
			$menu_list=array();
			$url = 'http://list.pptv.com/sort_list/8---------'.$page_id.'html';
			$body = Tools::curl($url);
			
			//match anchor tag and title
			preg_match_all("/<p>[^<>]*<a[^>]*>[^>]*<img[^>]*>[^<>]*<\/a>[^<>]*<a href=[\"]([^<>]*)[\"] [^>]*>([^<>]*)<\/a>[^<>]*<\/p>/iU",$body,$match);
			unset($match[0]);

			//data handling			 
			foreach($match[1] as $k=>$v)
			{
				$vid = $this->get_pptv_vid($v);
				$data[$vid] = array('vid'=>$vid,'title'=>$match[2][$k]);
			}
		}
		//echo Debug::vars($data);
		
		return $data;
	}
	/**
	 * PPTV VID Collect
	 */
	private function get_pptv_vid($url)
	{
		$body = Tools::curl($url);
		preg_match("/webcfg\s=(.*);/i",$body,$match);
	
		if( ! isset($match[1]))
		{
			echo $url; exit;
		}
		
		$data = json_decode($match[1],TRUE);
		
		//Not support m3u8
		if(!isset($data['player']['createConfig']['playList'][0]['ipadurl']))
		{
			Log::instance()->add(Kohana_Log::ERROR,"ERROR $url ");
			$this->link[$data['id']] = FALSE;
		}
		else
		{
			$this->link[$data['id']] = $data['player']['createConfig']['playList'][0]['ipadurl'];
		}	
		
		Log::instance()->add(Kohana_Log::DEBUG,"Collected $url ");
		return $data['id'];
	
	}
}

?>
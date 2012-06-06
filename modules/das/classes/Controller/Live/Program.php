<?php
class Controller_Live_Program extends Controller_DAS{
	
	public function action_save()
	{
		
		$channels	= Kohana::$config->load('program');
		foreach($channels as $k=>$v)
		{
			$day = $this->request->query('day');
			//默认采集明天数据
			$day =$day?$day:date("N",strtotime("tomorrow"));
				
			$program = self::fetch($k,date("Y-m-d",strtotime(date("o-\\WW")."-".$day)));
				
			$data = array(
					'station'=>$k,
					'program' => $program,
					'day'=>$day,
					'date'=>date("Y-m-d",strtotime(date("o-\\WW")."-".$day)),
			);
			echo Debug::vars($k,"周".$day,$data);
			//如果数据库中存在 那么执行update 不存在就insert
			$res = MangoDB::instance()->update('program_tvmao',array('station'=>$k,'day'=>$day),$data,array('upsert'=>TRUE));
			
			//经过多次尝试之后发现只有这样才能正常多次采集
			sleep(rand(1,10));
		}
	}
	private static function fetch($station,$date = NULL)
	{
		$channels	= Kohana::$config->load('program');
		//不存在返回空
		if(!isset($channels[$station]))
		{
			return FALSE;
		}
		$day = isset($date)&&!empty($date)?date('N',strtotime($date)):date('N',time());
	
		// 		if($day == 1)
			// 		{
			// 			$day = 8;
			// 		}
		$url = "http://www.tvmao.com/program/{$channels[$station]}-W{$day}.html";
	
		$data = Tools::curl($url);
	
		$pattern	= "/<li><span class=['\"](am|pm|nt)['\"]>([^<>].*)<\/span>([^<>]*<a[^>]*>(.*?)<\/a>|[^<>]*)/i";
	
		preg_match_all($pattern,$data,$match);
	
		if(empty($match[2]))
		{
			return FALSE;
		}
	
		for($i=0;$i<count($match[2]);$i++)
		{
		$times[]	=	trim(strip_tags($match[2][$i]));
		$title[]	=	trim(strip_tags(preg_replace("'<a[^>]*>'",'',$match[3][$i])));
		}
	
		return array_combine($times,$title);
	}
}
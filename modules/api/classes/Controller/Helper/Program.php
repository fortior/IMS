<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * TV program forecast 
 * @author Shunnar
 *
 */
class Controller_Helper_Program extends Controller_Api{
	
	function action_main()
	{
		$s = $this->request->query('s');
		//strip
		$s = $this->strip($s);
		
		//Today Program
		$today = self::program($s);
		
		//Throw exception
		if(empty($today))
		{
			$this->data = parent::error_code(3);
			return ;
		}
		$intercept_today = array();
		foreach($today as $k=>$v)
		{			
			if(strtotime($v[0]) > time())
			{
				if(empty($intercept_today) && $k>0)
				{
					$intercept_today[] = $today[$k-1];
				}
				$intercept_today[] = $v;
			}
		}
		$tomorrow = self::program($s,"tomorrow");
		$intercept_tomorrow = array();
		if( ! empty($tomorrow))
		{			
			foreach($tomorrow as $k=>$v)
			{
				$intercept_tomorrow[] = $v;
				if(strtotime($v[0]) > time())
				{					
					break;
				}
			}
		}
		$program = array_merge($intercept_today,$intercept_tomorrow);
		$this->data = array('count'=>count($program),'v'=>$program);
		
	}
	/**
	 * 
	 * @param  $station
	 * @param  $date
	 */
	public static function program($station,$date = NULL)
	{
		if( ! empty($date))
		{
			$date = date('N',strtotime($date));
		}
		else
		{
			$date = date("N");
		}
		$program_tvmao = MangoDB::instance()->find_one('program_tvmao',array('station'=>$station,'day'=>$date));
		if(empty($program_tvmao))
		{
			return array();
		}
		else
		{
			$data =array();	
			foreach($program_tvmao['program'] as $k=>$v)
			{
				array_push($data, array(date("Y-m-d")." ".$k.":00",$v));
			}
			return $data;
		}
	
	}
	private function strip($str)
	{
		return  preg_replace("/(高清|\[高清\])/i", "", $str);
	}
}
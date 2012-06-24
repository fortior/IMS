<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Weather Report Controller for epg  export
 * @author Shunnar
 *
 */
class Controller_Helper_WeatherReport extends Controller_Api{	
	public function action_main()
	{
		$ip = isset($_GET['ip']) ? $_GET['ip'] : '';
		if(empty($ip)){
			$ip = Tools::get_ip();
		}
		//TODO
		$city = isset($_GET['city'])?trim($_GET['city']):Controller_Helper_Geo::getCity_ip138($ip);
		//print_r($city);die;
		$this->key = "API-WEATHER-".$city.date("Ymd");//设置cache key
		$output = Cache::instance()->get($this->key, FALSE);
		if($output == false)
		{
			$link = 'http://php.weather.sina.com.cn/search.php?c=1&city='.$city.'&dpc=1';
			$data = Tools::curl($link);
			$data = iconv('gbk','utf-8//IGNORE',$data);
			$night = date('H',time())>18&&date('H',time())<6 ? 1 : 0;//判断当前是白天还是晚上
				
			//初始化输出数组
			$output = array('WEATHERRESULT' => array('Ip'=>$ip,'Address' => $city,'weatherAll' => array()));
				
			//今天的数据
			$today = array();
			$wkday_ar=array("周日","周一","周二","周三","周四","周五","周六");
			$today['Weeks'] = $wkday_ar[date('w')];
			$today['Date'] = date('Y-m-d',time());
				
			preg_match('/<div class="mod_today clearfix">(.*)<ul class="m_right">/is',$data,$today_html);
			if(isset($today_html[0]))
			{
				preg_match_all('/<li>([^<>]*)<\/li>/is',$today_html[0],$weather_html);
				preg_match_all('/background: url\(([^\(\)]*)\)/is',$today_html[0],$imager_html);
				preg_match_all('/<span class="fs_30 tpte">([^<>]*)<\/span>/is',$today_html[0],$temperature_html);
			}
			if($night)//当天的数据可以分白天晚上显示
			{
				if(isset($weather_html[1][2]))$today['Weather'] = $weather_html[1][2];
				else $today['Weather'] = '晴';
				if(isset($imager_html[1][2]))$today['Imager'] = $imager_html[1][2];
				else $today['Imager'] = 'http://php.weather.sina.com.cn/images/yb3/180_180/qing_0.png';
			}
			else
			{
				if(isset($weather_html[1][0]))$today['Weather'] = $weather_html[1][0];
				else $today['Weather'] = '晴';
				if(isset($imager_html[1][1]))$today['Imager'] = $imager_html[1][1];
				else $today['Imager'] = 'http://php.weather.sina.com.cn/images/yb3/180_180/qing_0.png';
			}
				
			if(isset($temperature_html[1][0]))$day_temperature = $temperature_html[1][0];
			else $day_temperature = '10℃';
			if(isset($temperature_html[1][1]))$night_temperature = $temperature_html[1][1];
			else $night_temperature = '5℃';
			$today['Temperature'] = $night_temperature.'~'.$day_temperature;
				
			$output['WEATHERRESULT']['weatherAll'][0] = $today;
				
			//之后四天的数据
			preg_match_all('/<h5>白天([^白]*)<div class="mod_02">/ius',$data,$other_day_html);
			if(isset($other_day_html[0])&&is_array($other_day_html[0]))
			{
				foreach ($other_day_html[0] as $key=>$value)
				{
					if($key>1)break;//这里目前兼容只有三天的数据
					$other_day = array();
						
					$other_day['Weeks'] = $wkday_ar[(date('w')+$key+1)%7];
					$other_day['Date'] = date('Y-m-d',time()+3600*24*($key+1));
						
					preg_match_all('/<li>([^<>]*)<\/li>/is',$other_day_html[0][$key],$other_weather_html);
					preg_match_all('/background: url\(([^\(\)]*)\)/is',$other_day_html[0][$key],$other_imager_html);
					preg_match_all('/<li class="tpte">([^<>]*)<\/li>/is',$other_day_html[0][$key],$other_temperature_html);
						
					if(isset($other_weather_html[1][0]))$other_day['Weather'] = $other_weather_html[1][0];
					else $other_day['Weather'] = '暂无';
						
					if(isset($other_imager_html[1][0]))$other_day['Imager'] = preg_replace('/78_78/','180_180',$other_imager_html[1][0]);
					else $other_day['Imager'] = 'http://php.weather.sina.com.cn/images/yb3/180_180/qing_0.png';
						
					if(isset($other_temperature_html[1][0]))$other_day_temperature = $other_temperature_html[1][0];
					else $other_day_temperature = '0℃';
					if(isset($other_temperature_html[1][1]))$other_night_temperature = $other_temperature_html[1][1];
					else $other_night_temperature = '0℃';
					$other_day['Temperature'] = $other_night_temperature.'~'.$other_day_temperature;
		
					$output['WEATHERRESULT']['weatherAll'][$key+1] = $other_day;
				}
			}
			if($output)
			Cache::instance()->set($this->key, $output,3600*24);
		}
		//将数组格式化输出
		$output = json_encode($output);
		$this->response->headers('content-type',  File::mime_by_ext('json'));
		//echo '<pre>';
		echo $output;
	}
}
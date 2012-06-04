<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_Live_Core extends Controller_DAS{
	/**
	 * Reset Links to  initial state
	 * @param  $type
	 */
	protected function reset($type)
	{
		DB::update(ORM::factory('Live_Links')->table_name())
		->set(array('available' => '0'))
		->where('type', '=', $type)
		->execute();
	}
	/**
	 * Auto relate two tables
	 */
	public function action_setup()
	{
		$epg = ORM::factory('live_epg')->find_all()->as_array("title",'id');
		//echo Debug::vars($epg);exit;
		$links = ORM::factory('live_links')->find_all();
		foreach($links as $v)
		{
			//$title = str_replace("[", "", $v->title);
			foreach($epg as $k=>$id)
			{
				//strip [] and compare
				$title1 = preg_replace("/[\[,\]]/i", "", $v->title);
				$title2 = preg_replace("/[\[,\]]/i", "", $k);
				if($title1 == $title2)
				{
					$v->pid = $id;
					$v->save();
				}
			}
			
		}
		
	}
}
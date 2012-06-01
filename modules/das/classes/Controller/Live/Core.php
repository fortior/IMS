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
}
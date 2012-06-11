<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Ad Controller for epg ad export
 * @author Shunnar
 *
 */
class Controller_System_Register extends Controller_Api{
	
	function action_main()
	{
		$data = array(
					"ret"=>0,
					"msg"=>"成功",
					"key"=>"f497f0998098788091",					
				);
		$this->data = $data;
	}
}
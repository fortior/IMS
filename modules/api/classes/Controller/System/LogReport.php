<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Ad Controller for epg ad export
 * @author Shunnar
 *
 */
class Controller_System_LogReport extends Controller_Api{
	
	function action_main()
	{
		$log = $this->request->query('log');
		$data = explode("|",$log);
		$data['created'] = date("Y-m-d H:i:s");
		MangoDB::instance()->insert('stb_log',$data);
		$data = array(
				"ret"=>0,
				"msg"=>"上报成功",				
		);
		$this->data = $data;
	}
}
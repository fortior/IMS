<?php
/**
 * DAS Controller
 * @author Shunnar
 *
 */
class Controller_DAS extends Controller{
	
	function before()
	{
		parent::before();
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
	}
}
<?php
/**
 * 封装在Mongo上的存储层
 * @author Shunnar
 *
 */
class Storage extends MangoDB {
	
	
	public static function instance($name = NULL, array $config = NULL)
	{
		MangoDB::$default = ( Kohana::$environment == Kohana::PRODUCTION)?'default':'test';
		return parent::instance($name,$config);
	}
}
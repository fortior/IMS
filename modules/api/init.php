<?php defined('SYSPATH') or die('No direct script access.');

// Catch-all route for Codebench classes to run

Route::set('api', 'api(/<directory>(/<controller>(/<action>(/<param>))))',array('param'=>'.*'))
	->defaults(array(
		'controller' => '',
		'action' => 'main',
		'directory'  => '',
		));
Route::set('Api', 'Api(/<directory>(/<controller>(/<action>(/<param>))))',array('param'=>'.*'))
	->defaults(array(
		'controller' => '',
		'action' => 'main',
		'directory'  => '',
		));

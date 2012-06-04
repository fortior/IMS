<?php defined('SYSPATH') or die('No direct script access.');

// Catch-all route for Codebench classes to run

Route::set('DAS', 'das(/<directory>(/<controller>(/<action>(/<param>))))',array('param'=>'.*'))
	->defaults(array(
		'controller' => '',
		'action' => 'main',
		'directory'  => '',
		));

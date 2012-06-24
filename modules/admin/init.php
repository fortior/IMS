<?php defined('SYSPATH') or die('No direct script access.');

// Catch-all route for Codebench classes to run

Route::set('admin', 'admin(/<directory>(/<controller>(/<action>(/<id>))))',array('param'=>'.*'))
	->defaults(array(
		'controller' => 'Dashboard',
		'action' => 'main',
		'directory'  => '',
		));

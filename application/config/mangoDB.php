<?php

return array(

	/**
	 * Configuration Name
	 *
	 * You use this name when initializing a new MangoDB instance
	 *
	 * $db = MangoDB::instance('default');
	 */
	'default' => array(

		/**
		 * Connection Setup
		 * 
		 * See http://www.php.net/manual/en/mongo.construct.php for more information
		 *
		 * or just edit / uncomment the keys below to your requirements
		 */
		'connection' => array(

			/** hostnames, separate multiple hosts by commas **/
			'hostnames' => '127.0.0.1:27017',

			/** database to connect to **/
			'database'  => 'ims',

			/** authentication **/
			'username'  => 'ims',
			'password'  => 'ims',

			/** connection options (see http://www.php.net/manual/en/mongo.construct.php) **/
			//'options'   => array(
				// 'persist'    => 'persist_id',
				// 'timeout'    => 1000, 
				// 'replicaSet' => TRUE
			//)
		),

		/**
		 * Whether or not to use profiling
		 *
		 * If enabled, profiling data will be shown through Kohana's profiler library
		 */
		'profiling' => FALSE
	),
	'test' => array(

		/**
		 * Connection Setup
		 * 
		 * See http://www.php.net/manual/en/mongo.construct.php for more information
		 *
		 * or just edit / uncomment the keys below to your requirements
		 */
		'connection' => array(

			/** hostnames, separate multiple hosts by commas **/
			'hostnames' => '112.95.140.62:10000',

			/** database to connect to **/
			'database'  => 'vlctechtest',

			/** authentication **/
			'username'  => 'test',
			'password'  => 'test',

			/** connection options (see http://www.php.net/manual/en/mongo.construct.php) **/
			//'options'   => array(
				// 'persist'    => 'persist_id',
				// 'timeout'    => 1000, 
				// 'replicaSet' => TRUE
			//)
		),

		/**
		 * Whether or not to use profiling
		 *
		 * If enabled, profiling data will be shown through Kohana's profiler library
		 */
		'profiling' => TRUE
	)
);
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname'	=> 'localhost',
	'username' => 'root',
	'password' => 'root',
	'database' => 'live_stream',
	'port'	   => 8889,

	// 'username' => 'root',
	// 'password' => 'Er@DM#2022!',
	// 'database' => 'live_stream',
	// 'port'	   => 3306,


	// 'hostname' => '10.10.10.75',
	// 'username' => 'xtrivia-app',
	// 'password' => 'Xtr1v14-db',
	// 'database' => 'live_stream',
	// 'port'	   => 3306,

	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

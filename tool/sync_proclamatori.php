<?php 
require_once (__DIR__.'/../include/config.php');
require_once (__DIR__.'/../include/dumper.php');
$file= __DIR__."/../backup/tmp_proclamatori.sql";


    $result = exec("mysqldump -u{$LocalDb['user']} -p{$LocalDb['pass']} {$LocalDb['db']} proclamatori > {$file}");



/*

	$world_dumper = Shuttle_Dumper::create(array(
		'host' => $LocalDb['host'],
		'username' => $LocalDb['user'],
		'password' => $LocalDb['pass'],
		'db_name' => $LocalDb['db'],
		'include_tables' => array('proclamatori'),
	));
	
	$now=date('Ymd-Hi');
	
$world_dumper->dump( __DIR__."/../backup/tmp_proclamatori.sql");

*/
chmod($file, 0777);


$result = exec("mysql -u{$RemoteDb['user']} -p{$RemoteDb['pass']} -h{$RemoteDb['host']} {$RemoteDb['db']} < {$file}");


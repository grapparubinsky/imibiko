<?php 
require_once (__DIR__.'/../include/config.php');
require_once (__DIR__.'/../include/dumper.php');
$source = $_REQUEST['source'];
if(empty($source) && !empty($argv[2])) $source = $argv[2]; 
if($source == 'locale') {

	$world_dumper = Shuttle_Dumper::create(array(
		'host' => $LocalDb['host'],
		'username' => $LocalDb['user'],
		'password' => $LocalDb['pass'],
		'db_name' => $LocalDb['db'],
	));
	
} elseif ($source == 'remote') {
	$world_dumper = Shuttle_Dumper::create(array(
		'host' => $RemoteDb['host'],
		'username' => $RemoteDb['user'],
		'password' => $RemoteDb['pass'],
		'db_name' => $RemoteDb['db'],
	));
	
}
	$now=date('Ymd-Hi');
	
$world_dumper->dump( __DIR__."/../backup/$now-imibiko_$source.sql");
$file= __DIR__."/../backup/$now-imibiko_$source.sql";

chmod($file, 0777);

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;

}



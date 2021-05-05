<?php
	
session_start();
error_reporting(E_ALL ^E_NOTICE);

require '../../../lib/Medoo.php';
use Medoo\Medoo;

require '../../../config.php';

if(is_file('../../../config_database.php')) {
	include '../../../config_database.php';
	$db_type = 'mysql';
	
	$database = new Medoo([

		'database_type' => 'mysql',
		'database_name' => "$database_name",
		'server' => "$database_host",
		'username' => "$database_user",
		'password' => "$database_psw",
	 
		'charset' => 'utf8',
		'port' => $database_port,
	 
		'prefix' => DB_PREFIX
	]);
	
	$db_content = $database;
	$db_user = $database;
	$db_statistics = $database;	
	
	
	
} else {
	$db_type = 'sqlite';
	
	
	define("CONTENT_DB", "$fc_db_content");

	$db_content = new Medoo([
		'database_type' => 'sqlite',
		'database_file' => CONTENT_DB
	]);
	
	
}

require_once '../../../acp/core/access.php';


$data = $db_content->update("fc_pages", [
	"page_title" => $_POST['page_title'],
	"page_linkname" => $_POST['page_linkname'],
	"page_meta_description" => $_POST['page_meta_description']
	], [
	"page_id" => $_POST['page_id']
]);

$rows = $data->rowCount();



if($rows > 0) {
	echo '<span class="text-success">UPDATED PAGE ID '. $_POST['page_id'].'</span>';
} else {
	echo '<span class="text-danger">FAILED</span>';
}

?>
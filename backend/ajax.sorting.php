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
		'type' => 'mysql',
		'database' => "$database_name",
		'host' => "$database_host",
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
		'type' => 'sqlite',
		'database' => CONTENT_DB
	]);
	
	
}

require_once '../../../acp/core/access.php';
require 'functions.php';


$new_parts = $_POST['page_part'];
$new_page_sort = implode('.',$new_parts);

$data = $db_content->update("fc_pages", [
	"page_sort" => $new_page_sort
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
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


if($_POST['data_row_title'] == 'true') {
	
	$search = htmlentities($_POST['search_string']);
	$replace = htmlentities($_POST['replace_string']);
		
	$data = $db_content->replace("fc_pages", [
		"page_title" => [
			"$search" => "$replace"
		]
	]);

	$rows = $data->rowCount();
	if($rows > 0) {
		echo '<span class="text-success">UPDATED '. $rows .' Titles</span>';
	} else {
		echo '<span class="text-info">No matches ...</span>';
	}
	
}

if($_POST['data_row_desc'] == 'true') {
	
	$search = htmlentities($_POST['search_string']);
	$replace = htmlentities($_POST['replace_string']);
		
	$data = $db_content->replace("fc_pages", [
		"page_meta_description" => [
			"$search" => "$replace"
		]
	]);

	$rows = $data->rowCount();
	if($rows > 0) {
		echo '<span class="text-success">UPDATED '. $rows .' Descriptions</span>';
	} else {
		echo '<span class="text-info">No matches ...</span>';
	}

}

if($_POST['data_row_content'] == 'true') {
	
	$search = htmlentities($_POST['search_string']);
	$replace = htmlentities($_POST['replace_string']);
		
	$data = $db_content->replace("fc_pages", [
		"page_content" => [
			"$search" => "$replace"
		]
	]);

	$rows = $data->rowCount();
	if($rows > 0) {
		echo '<span class="text-success">UPDATED '. $rows .'</span>';
	} else {
		echo '<span class="text-info">No matches ...</span>';
	}
	
}



?>
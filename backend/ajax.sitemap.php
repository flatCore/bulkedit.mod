<?php
	
session_start();
error_reporting(0);

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
require_once '../../../acp/core/functions.php';
require 'functions.php';


$all_pages = be_get_ordered_pages($_SESSION['be_lang']);

$cnt_all_pages = count($all_pages);
$sm_string .= '<ul class="page-list">';

for($i=0;$i<$cnt_all_pages;$i++) {
	
	$sm_page_id = $all_pages[$i]['page_id'];
	$sm_page_sort = $all_pages[$i]['page_sort'];
	$sm_page_linkname = $all_pages[$i]['page_linkname'];
	$sm_page_title = $all_pages[$i]['page_title'];
	$sm_page_status = $all_pages[$i]['page_status'];
	$sm_page_permalink = $all_pages[$i]['page_permalink'];
	$sm_page_lang = $all_pages[$i]['page_language'];
	
	$short_title = first_words($all_pages[$i]['page_title'], 6);
	
	if($sm_page_sort == '') { continue; }
	
	$points_of_item[$i] = substr_count($sm_page_sort, '.');
	
	// new level
	$start_ul = '';
	if($points_of_item[$i] > $points_of_item[$i-1]) {
		$start_ul = '<ul>';
		$sm_string = substr(trim($sm_string), 0, -5);
	}
	
	// end this level </ul>
	$end_ul = '';
	if($points_of_item[$i] < $points_of_item[$i-1]) {
		$div_level = abs($points_of_item[$i] - $points_of_item[$i-1]);
		$end_ul = str_repeat("</ul>", $div_level);
		$end_ul .= '</li>';		
	}
	
	$start_li = '<li>';
	$end_li = '</li>';


	if($pos = strripos($page_sort,".")) {
		$string = substr($page_sort,0,$pos);
	}
		
	
	$sm_string .= "$start_ul";
	$sm_string .= "$end_ul";
	$sm_string .= $start_li;
	$sm_string .= '<label class="page-container" for="radio'.$i.'">';
	$sm_string .= '<code>'.$sm_page_sort.'</code> - <strong>'.$sm_page_linkname.'</strong> '.$short_title;
	$sm_string .= '</label>';
	$sm_string .= $end_li;
	
	
	
}

$sm_string .= '</ul>';

echo $sm_string;

?>
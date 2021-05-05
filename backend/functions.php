<?php

/**
 * show all pages from $db_content
 * filter a = all, o = ordered, u = unordered
 * lang a = all, en/de/es/ ... filter by language
 */

function be_get_pages($type,$lang) {
	
	global $db_content;
	global $languagePack;
		
	if($type == 'a') {
		$type_query = "page_sort = '' OR page_sort != '' ";
	}
	if($type == 'o') {
		$type_query = "page_sort != '' ";
	}
	if($type == 's') {
		$type_query = "page_sort = '' ";
	}
	

	if($lang == '') {
		$lang = $languagePack;
	}
	

	
	$query = "SELECT * FROM fc_pages WHERE (($type_query) AND (page_language = '$lang')) ORDER BY page_sort *1 ASC, LENGTH(page_sort), page_sort ASC";
	$get_pages = $db_content->query($query)->fetchAll();
	return $get_pages;
	
}



function be_get_ordered_pages($lang) {
	
	global $db_content;
	global $languagePack;
		
	if($lang == '') {
		$lang = $languagePack;
	}
	
	$rows = array("page_id","page_sort","page_linkname","page_title");
	
	
	$query = "SELECT * FROM fc_pages WHERE (page_sort != '' AND page_language = '$lang') ORDER BY page_sort *1 ASC, LENGTH(page_sort), page_sort ASC";

	$get_pages = $db_content->query($query)->fetchAll();
	
	return $get_pages;
	
}

function be_get_page_data($id) {
	
	global $db_content;
	
	$rows = array("page_id","page_sort");
	
	$get_page = $db_content->select("fc_pages", $rows,[
		
		"page_id" => $id
		
	]);
	
	return $get_page;
	
}



?>
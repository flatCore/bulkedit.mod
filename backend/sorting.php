<?php
//error_reporting(E_ALL ^E_NOTICE);

/* language */
$arr_lang = get_all_languages();

if(!isset($_SESSION['be_lang'])) {	
	$_SESSION['be_lang'] = $languagePack;
}

if($_GET['switchLang']) {
	$_SESSION['be_lang'] = $_GET['switchLang'];
}


$pages = be_get_ordered_pages($_SESSION['be_lang']);
$cnt_pages = count($pages);

echo '<div class="subHeader">bulkedit.mod / (re)sort pages / (Matches: '.$cnt_pages.')</div>';



echo '<div class="app-container">';
echo '<div class="max-height-container">';



echo '<div class="row">';
echo '<div class="col-lg-6">';

echo '<div id="formresult" class="card p-2 mb-3">Results ...</div>';

echo '<div class="scroll-box">';

for($i=0;$i<$cnt_pages;$i++) {
	
	$parts[$i] = explode('.',$pages[$i]['page_sort']);
	if(count($parts[$i]) < count($parts[$i-1])) {
		echo '<hr>';
	}
	
	echo '<div class="row">';
	echo '<div class="col-6">';
	echo '<form action="?tn=moduls&sub=bulkedit.mod&a=sorting" method="POST" class="auto_send pb-3">';
	
	
	$x = 0;
	foreach($parts[$i] as $part) {
		$x++;
		
		echo '<input type="text" name="page_part[]" value="' .$part.'" onchange="mySubmit(this.form)" class="form-control d-inline part-'.$x.'" style="width:70px;margin-right:5px;">';
	}
	
	echo '<input type="hidden" name="page_id" value="'.$pages[$i]['page_id'].'">';
	echo '<input type="hidden" name="csrf_token" value="'.$_SESSION['token'].'">';
	echo '</form>';
	
	echo '</div>';
	echo '<div class="col-6">';
	
	echo '<p class="small mb-0">'.$pages[$i]['page_linkname'].' <small>'.$pages[$i]['page_title'].'<br>'.$pages[$i]['page_permalink'].'</small></p>';


	
	echo '</div>';
	echo '</div>';
	
}

echo '</div>';


echo '</div>';
echo '<div class="col-lg-6">';

echo '<div class="card p-1">';



/* filter buttons for languages */
$lang_btn_group = '<div class="btn-group">';
for($i=0;$i<count($arr_lang);$i++) {
	$lang_desc = $arr_lang[$i]['lang_desc'];
	$lang_folder = $arr_lang[$i]['lang_folder'];
	
	$this_btn_status = '';
	if(strpos($_SESSION['be_lang'], "$lang_folder") !== false) {
		$this_btn_status = 'active';
	}
	
	$lang_btn_group .= '<a href="?tn=moduls&sub=bulkedit.mod&a=sorting&switchLang='.$lang_folder.'" class="btn btn-sm btn-fc '.$this_btn_status.'">'.$lang_folder.'</a>';
}
$lang_btn_group .= '</div>';

echo '<div class="list-group list-group-flush">';
echo $lang_btn_group;
echo '</div><hr>';


echo '<div class="scroll-box">';
echo '<div id="sitemap" class="card">';
echo '</div>';
echo '</div>';

echo '</div>'; // card

echo '</div>';
echo '</div>';

echo '</div>'; // max-height-container
echo '</div>'; // app-container

?>

<script>
	
	$(function(){
		$('#sitemap').load('../modules/bulkedit.mod/backend/ajax.sitemap.php');
	});
	
function mySubmit(theForm) {
	$.ajax({
  	data: $(theForm).serialize(), // get the form data
    type: $(theForm).attr('method'), // GET or POST
    url: '../modules/bulkedit.mod/backend/ajax.sorting.php',
    success: function (response) { // on success..
    	$('#formresult').html(response); // update the DIV
    	$('#sitemap').load('../modules/bulkedit.mod/backend/ajax.sitemap.php');
    }
  });
}
</script>
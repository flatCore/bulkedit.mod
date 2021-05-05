<?php

/* bulk edit page type */
if(!isset($_SESSION['be_pt']) OR $_GET['pt'] == 'a') {
	$_SESSION['be_pt'] = 'a';
}

if($_GET['pt'] == 'o') {
	$_SESSION['be_pt'] = 'o';
}

if($_GET['pt'] == 's') {
	$_SESSION['be_pt'] = 's';
}

/* language */
$arr_lang = get_all_languages();

if(!isset($_SESSION['be_lang'])) {	
	$_SESSION['be_lang'] = $languagePack;
}

if($_GET['switchLang']) {
	$_SESSION['be_lang'] = $_GET['switchLang'];
}


$get_all_pages = be_get_pages($_SESSION['be_pt'],$_SESSION['be_lang']);
$cnt_pages = count($get_all_pages);

echo '<div class="subHeader">bulkedit.mod / edit meta data / (Matches: '.$cnt_pages.')</div>';

echo '<div class="app-container">';
echo '<div class="max-height-container">';

echo '<div class="row">';
echo '<div class="col-md-9">';

echo '<div id="formresult" class="card p-2 mb-3">Results ...</div>';

echo '<div class="row mb-2">';
echo '<div class="col-md-3">Linkname</div>';
echo '<div class="col-md-4">Title</div>';
echo '<div class="col-md-5">Description</div>';
echo '</div>';

echo '<div class="scroll-box">';

foreach($get_all_pages as $page) {
	echo '<form action="?tn=moduls&sub=bulkedit.mod&a=metas" method="POST" class="auto_send">';
	echo '<div class="row mb-1">';
	
	echo '<div class="col-md-3">';
	echo '<div class="input-group">';
	echo '<span class="input-group-text" id="basic-addon1">#'.$page['page_id'].'</span>';
	echo '<input type="text" name="page_linkname" value="' .$page['page_linkname'].'" onchange="mySubmit(this.form)" class="form-control">';
	echo '</div>';
	echo '</div>';
		
	echo '<div class="col-md-4">';
	echo '<input type="text" name="page_title" value="' .$page['page_title'].'" onchange="mySubmit(this.form)" class="form-control">';
	echo '</div>';
	
	echo '<div class="col-md-5">';
	echo '<input type="text" name="page_meta_description" value="' .$page['page_meta_description'].'" onchange="mySubmit(this.form)" class="form-control">';
	echo '</div>';
	
	
	
	echo '</div>';
	
	echo '<input type="hidden" name="page_id" value="'.$page['page_id'].'">';
	echo '<input type="hidden" name="csrf_token" value="'.$_SESSION['token'].'">';
	echo '</form>';
}

echo '</div>';


echo '</div>';
echo '<div class="col-md-3">';

echo '<div class="card p-1">';

echo '<div class="list-group">';

$set_be_pt1 = '';
$set_be_pt2 = '';
$set_be_pt3 = '';

if($_SESSION['be_pt'] == 'a') {
	$set_be_pt1 = 'active';
} else if($_SESSION['be_pt'] == 'o') {
	$set_be_pt2 = 'active';
} else if($_SESSION['be_pt'] == 's') {
	$set_be_pt3 = 'active';
}

echo '<a href="?tn=moduls&sub=bulkedit.mod&a=metas&pt=a" class="list-group-item list-group-item-ghost '.$set_be_pt1.'">All</a>';
echo '<a href="?tn=moduls&sub=bulkedit.mod&a=metas&pt=o" class="list-group-item list-group-item-ghost '.$set_be_pt2.'">Ordered</a>';
echo '<a href="?tn=moduls&sub=bulkedit.mod&a=metas&pt=s" class="list-group-item list-group-item-ghost '.$set_be_pt3.'">Single Pages</a>';
echo '</div><hr>';



/* filter buttons for languages */
$lang_btn_group = '<div class="btn-group">';
for($i=0;$i<count($arr_lang);$i++) {
	$lang_desc = $arr_lang[$i]['lang_desc'];
	$lang_folder = $arr_lang[$i]['lang_folder'];
	
	$this_btn_status = '';
	if(strpos("$_SESSION[be_lang]", "$lang_folder") !== false) {
		$this_btn_status = 'active';
	}
	
	$lang_btn_group .= '<a href="?tn=moduls&sub=bulkedit.mod&a=metas&switchLang='.$lang_folder.'" class="btn btn-sm btn-fc '.$this_btn_status.'">'.$lang_folder.'</a>';
}
$lang_btn_group .= '</div>';

echo '<div class="list-group list-group-flush">';
echo $lang_btn_group;
echo '</div>';


echo '</div>'; // card

echo '</div>';
echo '</div>';

echo '</div>'; // max-height-container
echo '</div>'; // app-container

?>

<script>
	
	function mySubmit(theForm) {
    $.ajax({
        data: $(theForm).serialize(), // get the form data
        type: $(theForm).attr('method'), // GET or POST
        url: '../modules/bulkedit.mod/backend/ajax.updatemetas.php',
        success: function (response) { // on success..
            $('#formresult').html(response); // update the DIV
        }
    });
}
	
	</script>
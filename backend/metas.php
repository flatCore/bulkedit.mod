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

if(!isset($_SESSION['be_st']) OR $_GET['st'] == 'a') {
	$_SESSION['be_st'] = 'a';
}

if($_GET['st'] == 'p' || $_GET['st'] == 'd' || $_GET['st'] == 'pr' || $_GET['st'] == 'g') {
	$_SESSION['be_st'] = $_GET['st'];
}




/* language */
$arr_lang = get_all_languages();

if(!isset($_SESSION['be_lang'])) {	
	$_SESSION['be_lang'] = $languagePack;
}

if($_GET['switchLang']) {
	$_SESSION['be_lang'] = $_GET['switchLang'];
}


$get_all_pages = be_get_pages($_SESSION['be_pt'],$_SESSION['be_st'],$_SESSION['be_lang']);
$cnt_pages = count($get_all_pages);


/* thumbnails */
$images = fc_get_all_media_data('image');
$images = fc_unique_multi_array($images,'media_file');
$thumbs = array();

foreach($images as $img) {
	
	$image_name = basename($img['media_file']);
	if($prefs_pagethumbnail_prefix != '') {
			if((strpos($image_name, $prefs_pagethumbnail_prefix)) === false) {
				continue;
			}
		}
	
	$thumbs[] = $img['media_file'];
}




echo '<div class="subHeader">bulkedit.mod / edit meta data / (Matches: '.$cnt_pages.')</div>';

echo '<div class="app-container">';
echo '<div class="max-height-container">';

echo '<div class="row">';
echo '<div class="col-md-9">';

echo '<div id="formresult" class="card p-2 mb-3">Results ...</div>';

echo '<div class="scroll-box">';

foreach($get_all_pages as $page) {
	echo '<form action="?tn=moduls&sub=bulkedit.mod&a=metas" method="POST" class="auto_send">';
	echo '<div class="card p-1 mb-1">';
	echo '<div class="card-header">'.$page['page_permalink'].'</div>';
	echo '<div class="row mb-1">';
	
	echo '<div class="col-md-4">';
	echo '<label>Linkname</label>';
	echo '<div class="input-group">';
	echo '<span class="input-group-text" id="basic-addon1">#'.$page['page_id'].'</span>';
	echo '<input type="text" name="page_linkname" value="' .$page['page_linkname'].'" onchange="mySubmit(this.form)" class="form-control">';
	echo '</div>';
	echo '</div>';
		
	echo '<div class="col-md-8">';
	echo '<label>Titel</label>';
	echo '<input type="text" name="page_title" value="' .$page['page_title'].'" onchange="mySubmit(this.form)" class="form-control">';
	echo '</div>';
	
	echo '<div class="col-md-8 mt-2">';
	echo '<label>Description</label>';
	echo '<input type="text" name="page_meta_description" value="' .$page['page_meta_description'].'" onchange="mySubmit(this.form)" class="form-control">';
	echo '</div>';
	
	echo '<div class="col-md-4 mt-2">';
	echo '<label>Thumbnail</label>';
	echo '<select name="page_thumbnail" class="form-control" onchange="mySubmit(this.form)">';
	echo '<option value="">No selection</option>';
	foreach($thumbs as $thumb) {
		
		$sel = '';
		if($page['page_thumbnail'] == $thumb) {
			$sel = 'selected';
		}
		
		echo '<option value="'.$thumb.'" '.$sel.'>'.basename($thumb).'</option>';
	}
	echo '</select>';
	

	echo '</div>';
	
	echo '</div>';
	
	
	echo '<input type="hidden" name="page_id" value="'.$page['page_id'].'">';
	echo '<input type="hidden" name="csrf_token" value="'.$_SESSION['token'].'">';
	echo '</div>'; // card
	echo '</form>';
}

echo '</div>';


echo '</div>';
echo '<div class="col-md-3">';

echo '<div class="card p-1">';

echo '<div class="list-group">';

/* page type */
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

/* status type */
$set_be_st1 = ''; // all
$set_be_st2 = ''; // public
$set_be_st3 = ''; // ghost
$set_be_st4 = ''; // private
$set_be_st5 = ''; // draft

if($_SESSION['be_st'] == 'a') {
	$set_be_st1 = 'active';
} else if($_SESSION['be_st'] == 'p') {
	$set_be_st2 = 'active';
} else if($_SESSION['be_st'] == 'g') {
	$set_be_st3 = 'active';
} else if($_SESSION['be_st'] == 'pr') {
	$set_be_st4 = 'active';
} else if($_SESSION['be_st'] == 'd') {
	$set_be_st5 = 'active';
}

echo '<a href="?tn=moduls&sub=bulkedit.mod&a=metas&st=a" class="list-group-item list-group-item-ghost '.$set_be_st1.'">All</a>';
echo '<a href="?tn=moduls&sub=bulkedit.mod&a=metas&st=p" class="list-group-item list-group-item-ghost '.$set_be_st2.'">Public</a>';
echo '<a href="?tn=moduls&sub=bulkedit.mod&a=metas&st=g" class="list-group-item list-group-item-ghost '.$set_be_st3.'">Ghost</a>';
echo '<a href="?tn=moduls&sub=bulkedit.mod&a=metas&st=pr" class="list-group-item list-group-item-ghost '.$set_be_st4.'">Private</a>';
echo '<a href="?tn=moduls&sub=bulkedit.mod&a=metas&st=d" class="list-group-item list-group-item-ghost '.$set_be_st5.'">Draft</a>';
echo '</div><hr>';


$lang_btn_group = '<div class="btn-group">';
foreach($lang_codes as $lang_code) {
	$this_btn_status = '';
	if(strpos("$_SESSION[be_lang]", "$lang_code") !== false) {
		$this_btn_status = 'active';
	}
	$lang_btn_group .= '<a href="?tn=moduls&sub=bulkedit.mod&a=metas&switchLang='.$lang_code.'" class="btn btn-sm btn-fc '.$this_btn_status.'">'.$lang_code.'</a>';
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
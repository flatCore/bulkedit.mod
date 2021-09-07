<?php

echo '<div class="subHeader">bulkedit.mod / Search & Replace / (Matches: '.$cnt_pages.')</div>';



echo '<form action="?tn=moduls&sub=bulkedit.mod&a=search_replace" method="POST" id="searchreplace">';

echo '<fieldset class="mt-4">';
echo '<legend>Choose data rows</legend>';
echo '<div class="form-check form-check-inline">';
echo '<input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="data_row_title" value="true">';
echo '<label class="form-check-label" for="inlineCheckbox1">Page Title</label>';
echo '</div>';

echo '<div class="form-check form-check-inline">';
echo '<input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="data_row_desc" value="true">';
echo '<label class="form-check-label" for="inlineCheckbox2">Page Description</label>';
echo '</div>';

echo '<div class="form-check form-check-inline">';
echo '<input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="data_row_content" value="true">';
echo '<label class="form-check-label" for="inlineCheckbox3">Page Content</label>';
echo '</div>';

echo '</fieldset>';

echo '<div class="row">';
echo '<div class="col-md-5">';

echo '<label for="input_search" class="form-label">String, you want to replace</label>';
echo '<input class="form-control" id="input_search" name="search_string" type="text" placeholder="Search">';

echo '</div>';
echo '<div class="col-md-5">';

echo '<label for="input_replace" class="form-label">Your replacement</label>';
echo '<input class="form-control" name="replace_string" type="text" placeholder="Replace">';

echo '</div>';
echo '<div class="col-md-2">';
echo '<label class="form-label">Dare you</label>';
echo '<button class="btn btn-primary w-100" type="submit" name="start_bulk_replace">Search & Replace</button>';
echo '<input type="hidden" name="csrf_token" value="'.$_SESSION['token'].'">';
echo '</div>';
echo '</div>';

echo '</form>';


echo '<div id="formresult" class="card p-2 mt-3 mb-3">Results ...</div>';



?>

<script>
	
	$(function(){
		$("#searchreplace").on("submit", function(e){
			e.preventDefault();
    $.ajax({
        data: $("#searchreplace").serialize(), // get the form data
        type: $("#searchreplace").attr('method'), // GET or POST
        url: '../modules/bulkedit.mod/backend/ajax.searchreplace.php',
        success: function (response) { // on success..
            $('#formresult').html(response); // update the DIV
        }
    });
    
    });
});
	
</script>
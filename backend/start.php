<?php


echo '<div class="subHeader">bulkedit.mod</div>';

$readme = file_get_contents("../modules/bulkedit.mod/README.md");

echo '<div class="card p-3">';
$Parsedown = new Parsedown();
echo $Parsedown->text($readme);
echo '</div>';
?>
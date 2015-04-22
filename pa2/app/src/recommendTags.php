<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/controllers/PhotoCtrl.php");
echo json_encode(PhotoCtrl::recommendTags($_GET['tags']));
?>

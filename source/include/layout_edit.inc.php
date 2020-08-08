<?php
require('db_connect.inc.php');

session_start();
if(!$_SESSION['username']){
    header("Locate: ../layouts.php");
    exit();
} else {

$id = $_POST['id'];
$qptfile = $_POST['submitLayout'];
$previewfile = $_POST['submitPreview'];

if(isset($_POST['submit'])){

$layout_name = strip_tags($_POST["layoutName"]);
$layout_creator = strip_tags($_POST["layoutCreator"]);
$layout_description = strip_tags($_POST["layoutDescription"]);
$istiny = $_POST['istiny'];
$issmall = $_POST['issmall'];
$ismedium = $_POST['ismedium'];
$islarge = $_POST['islarge'];
$isscreen = $_POST['isscreen'];
$license = $_POST['license'];
if($_SESSION['moderator']){ // Only for moderators
    $featured = $_POST['layoutFeatured'];
} else {
    $featured = 0;
}

if(empty($layout_name) || empty($layout_creator) || empty($layout_description)){
    header("Location: ../layout_edit.php?error=incomplete");
    exit();
} else {


// Update Database
$sql = "UPDATE layouts SET layoutname=?, layoutcreator=?, layoutdescription=?, byuser=?, istiny=?, issmall=?, ismedium=?, islarge=?, isscreen=?, popular=? WHERE id=?;";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)) {
   header("Location: ../layout_edit.php?error=sql-error");
   exit();
} else {
    mysqli_stmt_bind_param($stmt, "ssssiiiiiii", $layout_name, $layout_creator, $layout_description, $_SESSION['username'], $istiny, $itsmall, $ismedium, $islarge, $isscreen, $featured, $id);
    mysqli_stmt_execute($stmt);
}
   
}

} else if (isset($_POST['delete'])){

// Delete Style from database
if(!unlink($qptfile)){
    header("Location: ../layout_edit.php?error=file-delete");
    exit();
}
if(!unlink($previewfile)){
    header("Location: ../layout_edit.php?error=file-delete");
    exit();
}
$sql = "DELETE FROM layouts WHERE id=?;";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)) {
   header("Location: ../layout_edit.php?error=sql-error");
   exit();
} else {
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}
}
} 
header("Location: ../layouts.php?change=successful");

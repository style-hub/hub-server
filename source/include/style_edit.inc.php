<?php
require('db_connect.inc.php');

session_start();
if(!$_SESSION['username']){
    header("Locate: ../styles.php");
    exit();
} else {

$id = $_POST['id'];
$xmlfile = $_POST['submitStyle'];
$previewfile = $_POST['submitPreview'];

if(isset($_POST['submit'])){

$style_name = $_POST["styleName"];
$style_creator = $_POST["styleCreator"];
$style_description = $_POST["styleDescription"];
$ismarker = $_POST['ismarker'];
$isline = $_POST['isline'];
$isfill = $_POST['isfill'];
$isramp = $_POST['isramp'];
$istext = $_POST['istext'];
$islabel = $_POST['islabel'];
$ispatch = $_POST['ispatch'];
$license = $_POST['license'];

if(empty($style_name) || empty($style_creator) || empty($style_description)){
    header("Location: ../style_edit.php?error=incomplete");
    exit();
} else {


// Update Database
$sql = "UPDATE styles SET stylename=?, stylecreator=?, styledescription=?, byuser=?, ismarker=?, isline=?, isfill=?, isramp=?, istext=?, islabel=?, ispatch=? WHERE id=?;";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)) {
   header("Location: ../style_edit.php?error=sql-error");
   exit();
} else {
   $pwdhash = password_hash($pwd1, PASSWORD_BCRYPT);
    mysqli_stmt_bind_param($stmt, "ssssiiiiiiii", $style_name, $style_creator, $style_description, $_SESSION['username'], $ismarker, $isline, $isfill, $isramp, $istext, $islabel, $ispatch, $id);
    mysqli_stmt_execute($stmt);
}
   
}

} else if (isset($_POST['delete'])){

// Delete Style from database
if(!unlink($xmlfile)){
    header("Location: ../style_edit.php?error=file-delete");
    exit();
}
if(!unlink($previewfile)){
    header("Location: ../style_edit.php?error=file-delete");
    exit();
}
$sql = "DELETE FROM styles WHERE id=?;";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)) {
   header("Location: ../style_edit.php?error=sql-error");
   exit();
} else {
   $pwdhash = password_hash($pwd1, PASSWORD_BCRYPT);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}
}
} 
header("Location: ../styles.php?change=successful");

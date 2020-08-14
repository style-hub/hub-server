<?php
if(isset($_POST['submit'])){
require('db_connect.inc.php');

session_start();
if(!$_SESSION['username']){
    header("Locate: ../layouts.php");
    exit();
} else {

$layout_name = strip_tags($_POST["layoutName"]);
$layout_creator = strip_tags($_POST["layoutCreator"]);
$layout_description = strip_tags($_POST["layoutDescription"]);
$istiny = $_POST['istiny'];
$issmall = $_POST['issmall'];
$ismedium = $_POST['ismedium'];
$islarge = $_POST['islarge'];
$isscreen = $_POST['isscreen'];
$iselement = $_POST['iselement'];
$license = $_POST['license'];
$images_dir = "../layouts/images/";
$layout_dir = "../layouts/resources/";
$qptfile = $_FILES['submitLayout'];
$previewfile = $_FILES['submitPreview'];

if(empty($layout_name) || empty($layout_creator) || empty($layout_description)){
    header("Location: ../layout_submit.php?error=incomplete");
    exit();
} else if (!$license){
    header("Location: ../layout_submit.php?error=license&name=".$layout_name."&creator=".$layout_creator."&desc=".$layout_description);
    exit();
} else {

// upload XML

$qpt_name = $qptfile['name'];
$img_name = $previewfile['name'];
$qpt_tmpname = $qptfile['tmp_name'];
$img_tmpname = $previewfile['tmp_name'];
$qpt_size = $qptfile['size'];
$img_size = $previewfile['size'];
$qpt_error = $qptfile['error'];
$img_error = $previewfile['error'];
$qpt_type = $qptfile['type'];
$img_type = $previewfile['type'];
$qpt_ext = strtolower(end(explode('.', $qpt_name)));
$img_ext = strtolower(end(explode('.', $img_name)));
$allowed_qpt = array('qpt');
$allowed_img = array('jpg','jpeg','png');
if(in_array($qpt_ext,$allowed_qpt) && in_array($img_ext,$allowed_img)){
    if($qpt_error === 0 && $img_error === 0){
        if($qpt_size < 500000 && $img_size < 500000){
            $qpt_new = uniqid('', true).".".$qpt_ext;
            $img_new = uniqid('',true).".".$img_ext;
            $qpt_destination = $layout_dir.$qpt_new;
            $img_destination = $images_dir.$img_new;
            move_uploaded_file($qpt_tmpname, $qpt_destination);
            move_uploaded_file($img_tmpname, $img_destination);
        } else {
            header("Location: ../layout_submit.php?error=file");
            exit();
        }
    } else {
        header("Location: ../layout_submit.php?error=file");
        exit();
    }
} else {
    header("Location: ../layout_submit.php?error=file");
    exit();
}

// Update Database
$sql = "INSERT INTO layouts (layoutname, layoutcreator, layoutdescription, layoutqpt, layoutpreview, byuser, istiny, issmall, ismedium, islarge, isscreen, iselement) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)) {
   header("Location: ../layout_submit.php?error=sql-error");
   exit();
} else {
    mysqli_stmt_bind_param($stmt, "ssssssiiiiii", $layout_name, $layout_creator, $layout_description, $qpt_destination, $img_destination, $_SESSION['username'], $istiny, $issmall, $ismedium, $islarge, $isscreen, $iselement);
    mysqli_stmt_execute($stmt);
}
   
}

}
}
header("Location: ../layouts.php?upload=successful");

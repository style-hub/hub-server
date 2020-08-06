<?php
if(isset($_POST['submit'])){
require('db_connect.inc.php');

session_start();
if(!$_SESSION['username']){
    header("Locate: ../styles.php");
    exit();
} else {

$style_name = strip_tags($_POST["styleName"]);
$style_creator = strip_tags($_POST["styleCreator"]);
$style_description = strip_tags($_POST["styleDescription"]);
$ismarker = $_POST['ismarker'];
$isline = $_POST['isline'];
$isfill = $_POST['isfill'];
$isramp = $_POST['isramp'];
$istext = $_POST['istext'];
$islabel = $_POST['islabel'];
$ispatch = $_POST['ispatch'];
$license = $_POST['license'];
$images_dir = "../styles/images/";
$style_dir = "../styles/resources/";
$xmlfile = $_FILES['submitStyle'];
$previewfile = $_FILES['submitPreview'];

if(empty($style_name) || empty($style_creator) || empty($style_description)){
    header("Location: ../style_submit.php?error=incomplete");
    exit();
} else if (!$license){
    header("Location: ../style_submit.php?error=license&name=".$style_name."&creator=".$style_creator."&desc=".$style_description);
    exit();
} else {

// upload XML

$xml_name = $xmlfile['name'];
$img_name = $previewfile['name'];
$xml_tmpname = $xmlfile['tmp_name'];
$img_tmpname = $previewfile['tmp_name'];
$xml_size = $xmlfile['size'];
$img_size = $previewfile['size'];
$xml_error = $xmlfile['error'];
$img_error = $previewfile['error'];
$xml_type = $xmlfile['type'];
$img_type = $previewfile['type'];
$xml_ext = strtolower(end(explode('.', $xml_name)));
$img_ext = strtolower(end(explode('.', $img_name)));
$allowed_xml = array('xml');
$allowed_img = array('jpg','jpeg','png');
if(in_array($xml_ext,$allowed_xml) && in_array($img_ext,$allowed_img)){
    if($xml_error === 0 && $img_error === 0){
        if($xml_size < 500000 && $img_size < 500000){
            $xml_new = uniqid('', true).".".$xml_ext;
            $img_new = uniqid('',true).".".$img_ext;
            $xml_destination = $style_dir.$xml_new;
            $img_destination = $images_dir.$img_new;
            move_uploaded_file($xml_tmpname, $xml_destination);
            move_uploaded_file($img_tmpname, $img_destination);
        } else {
            header("Location: ../style_submit.php?error=file");
            exit();
        }
    } else {
        header("Location: ../style_submit.php?error=file");
        exit();
    }
} else {
    header("Location: ../style_submit.php?error=file");
    exit();
}

// Update Database
$sql = "INSERT INTO styles (stylename, stylecreator, styledescription, stylexml, stylepreview, byuser, ismarker, isline, isfill, isramp, istext, islabel, ispatch) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)) {
   header("Location: ../style_submit.php?error=sql-error");
   exit();
} else {
   $pwdhash = password_hash($pwd1, PASSWORD_BCRYPT);
    mysqli_stmt_bind_param($stmt, "ssssssiiiiiii", $style_name, $style_creator, $style_description, $xml_destination, $img_destination, $_SESSION['username'], $ismarker, $isline, $isfill, $isramp, $istext, $islabel, $ispatch);
    mysqli_stmt_execute($stmt);
}
   
}

}
}
header("Location: ../styles.php?upload=successful");

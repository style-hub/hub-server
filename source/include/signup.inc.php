<?php

require('db_connect.inc.php');

$userName = $_POST['userName'];
$email = $_POST['email'];
$pwd1 = $_POST['pwd1'];
$pwd2 = $_POST['pwd2'];
$terms = $_POST['terms'];

function valid_email($str) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }

if(empty($userName) && empty($email)) {
    header("Location: ../signup.php?error=username-email&user=".$userName."&email=".$email."&terms=".$terms);
    exit();
} else if(empty($userName)) {
    header("Location: ../signup.php?error=username&user=".$userName."&email=".$email."&terms=".$terms);
    exit();
} else if(empty($email)) {
    header("Location: ../signup.php?error=email&user=".$userName."&email=".$email."&terms=".$terms);
    exit();
} else if (valid_email(!$email) && !preg_match("/^[a-zA-Z0-9]*$/", $userName)){
    header("Location: ../signup.php?error=username-email&user=".$userName."&email=".$email."&terms=".$terms);
    exit();
} else if (valid_email(!$email) ){
    header("Location: ../signup.php?error=email&user=".$userName."&email=".$email."&terms=".$terms);
    exit();
} else if (!preg_match("/^[a-zA-Z0-9]*$/", $userName)){
    header("Location: ../signup.php?error=username&user=".$userName."&email=".$email."&terms=".$terms);
    exit();
} else if(empty($pwd1)) {
    header("Location: ../signup.php?error=password&user=".$userName."&email=".$email."&terms=".$terms);
    exit();
} else if(!$terms) {
    header("Location: ../signup.php?error=terms&user=".$userName."&email=".$email);
    exit();
} else if ($pwd1 !== $pwd2){
    header("Location: ../signup.php?error=password&user=".$userName."&email=".$email."&terms=".$terms);
    exit();
} else {
    $sql = "SELECT username FROM users WHERE username=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../signup.php?error=sql-error");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $userName);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);
        if($resultCheck > 0){
            header("Location: ../signup.php?error=user&user=".$userName."&email=".$email."&terms=".$terms);
            exit();
        } else {
            $sql = "INSERT INTO users (username, useremail, userpwd) VALUES (?, ?, ?);";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../signup.php?error=sql-error");
                exit();
            } else {
                $pwdhash = password_hash($pwd1, PASSWORD_BCRYPT);
                mysqli_stmt_bind_param($stmt, "sss", $userName, $email, $pwdhash);
                mysqli_stmt_execute($stmt);
            }
        }
    }
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

session_start();
$_SESSION['username'] = $userName;
$_SESSION['usermail'] = $email;
header("Location: ../index.php?signup=successful");
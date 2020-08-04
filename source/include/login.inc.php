<?php

if(isset($_POST['login'])){
    require('db_connect.inc.php');

    $user = $_POST['user'];
    $pwd = $_POST['pwd'];

    if(empty($user) || empty($pwd)){
        header("Location: ../index.php?error=empty_fields");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE username=? OR useremail=?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../index.php?error=sql_error");
            exit();
        } else {
            
            mysqli_stmt_bind_param($stmt, "ss", $user, $user);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)){
                $pwdChk = password_verify($pwd, $row['userpwd']);
                if($pwdChk == false){
                    header("Location: ../index.php?error=login_fail");
                    exit();
                } else if($pwdChk == true){
                    // log in
                    session_start();
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['usermail'] = $row['useremail'];
                    header("Location: ../index.php?login=successful");
                }
            } else {
                header("Location: ../index.php?error=no_user");
                exit();
            }
        }
    }
} else {
    header("Location: ../index.php");
    exit();
}
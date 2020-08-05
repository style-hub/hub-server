<?php 
    
    // Parameters for MySQL connection.
    $db_server = 'localhost';
    $database = 'hub';
    $db_user = 'user';
    $db_password = '1#Password';

    $conn = mysqli_connect($db_server, $db_user, $db_password, $database);

    if(!$conn){
        die('MySQL Connection Failed.'.mysqli_connect_error());
    }
    
?>